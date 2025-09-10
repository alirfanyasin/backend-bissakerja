<?php

namespace App\Http\Controllers;

use App\Enum\StatusCandidateRecruitment;
use App\Enum\StatusPerusahaanRecruitment;
use App\Mail\InterviewInvitationMail;
use App\Models\Recruitment;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Enum;

/**
 * Controller yang handle fitur talent pull
 */
class RecruitmentController extends Controller
{
    use ApiResponse;

    /**
     * Method untuk mengirim permintaan rekruitmen dari perusahaan ke kandidat.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function sendRecruitmentToCandidate(Request $request)
    {
        DB::beginTransaction();
        try {
            $validateData = $request->validate([
                'user_profile_id' => 'required|exists:user_profiles,id',
                'post_lowongan_id' => 'required|exists:post_lowongan,id',
                'perusahaan_profile_id' => 'required|exists:perusahaan_profiles,id',
            ]);

            // Check apakah kandidat sudah pernah ditawari oleh perusahaan yg sama
            $isCandidateAlreadyInvite = Recruitment::where('user_profile_id', $validateData['user_profile_id'])
                ->where('post_lowongan_id', $validateData['post_lowongan_id'])
                ->where('perusahaan_profile_id', $validateData['perusahaan_profile_id'])->exists();

            if ($isCandidateAlreadyInvite) {
                return $this->errorResponse('Kandidat sudah pernah diinvite.');
            }

            $recruitment = Recruitment::create([
                'user_profile_id' => $validateData['user_profile_id'],
                'post_lowongan_id' => $validateData['post_lowongan_id'],
                'perusahaan_profile_id' => $validateData['perusahaan_profile_id'],
                'status_candidate' => StatusCandidateRecruitment::PENDING->value,
                'status_perusahaan' => StatusPerusahaanRecruitment::WAITING->value,
            ]);

            $emailCandidate = $recruitment->userProfile->user->email;
            $nameCandidate = $recruitment->userProfile->user->name;

            $emailPerusahaan = $recruitment->perusahaanProfile->user->email;
            $namePerusahaan = $recruitment->perusahaanProfile->user->name;

            // Send email to kandidat
            Mail::to($recruitment->userProfile->user->email)
                ->queue(new InterviewInvitationMail($emailCandidate, $nameCandidate, $emailPerusahaan, $namePerusahaan));

            DB::commit();

            return $this->successResponse('Success mengirim permintaan recruitment', 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('errorlog')->error('RecruitmentController [sendRecruitmentToCandidate]'.$e->getMessage());

            return $this->errorResponse('Gagal mengirim recruitment.', 500);
        }
    }

    /**
     * Method untuk mendapatkan seluruh recruitment perusahaan
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecruitment(Request $request)
    {
        try {
            $query = Recruitment::with([
                'postLowongan',
                'perusahaanProfile.user:id,name,email',
                'userProfile.user:id,name,email',
            ]);

            // Filter based on perusahaan
            if ($request->has('perusahaan_profile_id')) {
                $query->whereHas('perusahaanProfile', function ($query) use ($request) {
                    $query->where('id', $request->perusahaan_profile_id);
                });
            }

            // Filter based on user
            if ($request->has('user_profile_id')) {
                $query->whereHas('userProfile', function ($query) use ($request) {
                    $query->where('id', $request->user_profile_id);
                });
            }

            $perPage = $request->has('per_page') ? (int) $request->per_page : 15;

            $recruitment = $query->paginate($perPage);

            return $this->successResponse($recruitment, 200);
        } catch (\Throwable $e) {
            Log::channel('errorlog')->error('RecruitmentController [getRecruitment]'.$e->getMessage());

            return $this->errorResponse('Gagal mengambil recruitment. ', 500);
        }
    }

    /**
     * Update status untuk user.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function updateUserRecruitmentStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $validateData = $request->validate([
                'recruitment_id' => 'required|exists:recruitments,id',
                'status_candidate' => ['required', new Enum(StatusCandidateRecruitment::class)],
            ]);

            $recruitment = Recruitment::findOrFail($validateData['recruitment_id']);

            if ($recruitment->status_candidate !== StatusCandidateRecruitment::PENDING->value) {
                return $this->errorResponse('Tidak bisa mengubah status lagi.');
            }

            $recruitment->status_candidate = $validateData['status_candidate'];
            $recruitment->save();

            DB::commit();

            return $this->successResponse('Success mengubah status recruitment user.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('errorlog')->error('RecruitmentController [updateUserRecruitmentStatus]'.$e->getMessage());

            return $this->errorResponse('Gagal update status recruitment user.', 500);
        }
    }

    /**
     * Update status recruitment perusahaa.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function updatePerusahaanRecruitmentStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $validateData = $request->validate([
                'recruitment_id' => 'required|exists:recruitments,id',
                'status_perusahaan' => ['required', new Enum(StatusPerusahaanRecruitment::class)],
            ]);

            $recruitment = Recruitment::findOrFail($validateData['recruitment_id']);

            $recruitment->status_perusahaan = $validateData['status_perusahaan'];
            $recruitment->save();

            DB::commit();

            return $this->successResponse('Success mengubah status recruitment perusahaan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('errorlog')->error('RecruitmentController [updatePerusahaanRecruitmentStatus]'.$e->getMessage());

            return $this->errorResponse('Gagal update status recruitment perusahaan.', 500);
        }
    }
}
