<?php

namespace App\Http\Controllers;

use App\Models\PostLowongan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PublicJobController extends Controller
{
    /**
     * Get all public job vacancies (untuk frontend)
     */
    public function index(): JsonResponse
    {
        try {
            Log::info('PublicJobController: Fetching public job vacancies');
            
            $jobs = PostLowongan::with(['perusahaanProfile', 'disabilitas'])
                ->whereDate('application_deadline', '>=', now()) // hanya yang masih aktif
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('PublicJobController: Found ' . $jobs->count() . ' jobs');

            // Transform data sesuai dengan format yang dibutuhkan frontend
            $transformedJobs = $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'job_title' => $job->job_title ?? 'No Title',
                    'job_type' => $job->job_type ?? 'Full Time',
                    'description' => $job->description ?? 'No description available',
                    'responsibilities' => $job->responsibilities ?? '',
                    'requirements' => $job->requirements ?? '',
                    'education' => $job->education ?? '',
                    'experience' => $job->experience ?? '',
                    'salary_range' => $job->salary_range ?? 'Competitive',
                    'benefits' => $job->benefits ?? '',
                    'location' => $job->location ?? 'Remote',
                    'application_deadline' => $job->application_deadline ? $job->application_deadline->format('Y-m-d') : now()->addDays(30)->format('Y-m-d'),
                    'accessibility_features' => $job->accessibility_features ?? '',
                    'work_accommodations' => $job->work_accommodations ?? '',
                    'skills' => is_string($job->skills) ? json_decode($job->skills, true) ?? [] : ($job->skills ?? []),
                    'perusahaan_profile' => $job->perusahaanProfile ?? [
                        'id' => 0,
                        'nama_perusahaan' => 'Unknown Company',
                        'industri' => 'Technology',
                        'logo' => null,
                        'status_verifikasi' => 'pending'
                    ],
                    'disabilitas' => $job->disabilitas ?? [],
                    'created_at' => $job->created_at,
                    'updated_at' => $job->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data lowongan berhasil diambil',
                'data' => $transformedJobs
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching public job vacancies: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data lowongan',
                'error' => $e->getMessage(),
                'debug_info' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }

    /**
     * Get specific job vacancy detail (untuk frontend)
     */
    public function show($id): JsonResponse
    {
        try {
            $job = PostLowongan::with(['perusahaanProfile', 'disabilitas'])
                ->where('id', $id)
                ->first();

            if (!$job) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lowongan pekerjaan tidak ditemukan'
                ], 404);
            }

            // Transform data
            $transformedJob = [
                'id' => $job->id,
                'job_title' => $job->job_title,
                'job_type' => $job->job_type,
                'description' => $job->description,
                'responsibilities' => $job->responsibilities,
                'requirements' => $job->requirements,
                'education' => $job->education,
                'experience' => $job->experience,
                'salary_range' => $job->salary_range,
                'benefits' => $job->benefits,
                'location' => $job->location,
                'application_deadline' => $job->application_deadline ? $job->application_deadline->format('Y-m-d') : null,
                'accessibility_features' => $job->accessibility_features,
                'work_accommodations' => $job->work_accommodations,
                'skills' => $job->skills ?? [],
                'perusahaan_profile' => $job->perusahaanProfile,
                'disabilitas' => $job->disabilitas,
                'created_at' => $job->created_at,
                'updated_at' => $job->updated_at,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Detail lowongan berhasil diambil',
                'data' => $transformedJob
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching job vacancy detail: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail lowongan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get job vacancies with filters (untuk frontend search/filter)
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = PostLowongan::with(['perusahaanProfile', 'disabilitas'])
                ->where('application_deadline', '>=', now());

            // Filter by search term (job title, company name, skills)
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('job_title', 'LIKE', "%{$searchTerm}%")
                      ->orWhereHas('perusahaanProfile', function($qq) use ($searchTerm) {
                          $qq->where('nama_perusahaan', 'LIKE', "%{$searchTerm}%");
                      })
                      ->orWhereJsonContains('skills', $searchTerm);
                });
            }

            // Filter by location
            if ($request->has('location') && !empty($request->location)) {
                $query->where('location', 'LIKE', "%{$request->location}%");
            }

            // Filter by job type
            if ($request->has('job_type') && !empty($request->job_type)) {
                $query->where('job_type', $request->job_type);
            }

            // Filter by industry
            if ($request->has('industry') && !empty($request->industry)) {
                $query->whereHas('perusahaanProfile', function($q) use ($request) {
                    $q->where('industri', 'LIKE', "%{$request->industry}%");
                });
            }

            // Filter by disability support
            if ($request->has('disability_support') && $request->disability_support == 'true') {
                $query->has('disabilitas');
            }

            $jobs = $query->orderBy('created_at', 'desc')->get();

            // Transform data
            $transformedJobs = $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'job_title' => $job->job_title,
                    'job_type' => $job->job_type,
                    'description' => $job->description,
                    'responsibilities' => $job->responsibilities,
                    'requirements' => $job->requirements,
                    'education' => $job->education,
                    'experience' => $job->experience,
                    'salary_range' => $job->salary_range,
                    'benefits' => $job->benefits,
                    'location' => $job->location,
                    'application_deadline' => $job->application_deadline ? $job->application_deadline->format('Y-m-d') : null,
                    'accessibility_features' => $job->accessibility_features,
                    'work_accommodations' => $job->work_accommodations,
                    'skills' => $job->skills ?? [],
                    'perusahaan_profile' => $job->perusahaanProfile,
                    'disabilitas' => $job->disabilitas,
                    'created_at' => $job->created_at,
                    'updated_at' => $job->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data lowongan berhasil diambil',
                'data' => $transformedJobs,
                'total' => $transformedJobs->count(),
                'filters_applied' => $request->only(['search', 'location', 'job_type', 'industry', 'disability_support'])
            ]);

        } catch (\Exception $e) {
            \Log::error('Error searching job vacancies: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencari lowongan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}