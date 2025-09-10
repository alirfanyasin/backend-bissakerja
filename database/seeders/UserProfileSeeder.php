<?php

namespace Database\Seeders;

use App\Models\PerusahaanProfile;
use App\Models\PostLowongan;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProfile::create([
            'nik' => '3578123456789001',
            'tanggal_lahir' => '2000-05-15',
            'jenis_kelamin' => 'L',
            'no_telp' => '081234567890',
            'latar_belakang' => 'S1 Teknik Informatika',
            'status_kawin' => 0,
            'user_id' => 3,
            'disabilitas_id' => 1,
            'is_experience' => 1,
            'is_employment' => 0,
        ]);

        $perusahaanProfile = PerusahaanProfile::create([
            'user_id' => 4,
            'logo' => 'logos/company_a.png', // pastikan ada file di storage/public/logos/
            'nama_perusahaan' => 'PT Teknologi Nusantara',
            'industri' => 'Teknologi Informasi',
            'tahun_berdiri' => '2015',
            'jumlah_karyawan' => '200-500',
            'province_id' => '35', // contoh: Jawa Timur
            'regencie_id' => '3578', // contoh: Kota Surabaya
            'deskripsi' => 'Perusahaan yang bergerak di bidang software development dan solusi digital.',
            'no_telp' => '0311234567',
            'link_website' => 'https://www.teknologinusantara.co.id',
            'alamat_lengkap' => 'Jl. Raya Darmo No. 123, Surabaya',
            'visi' => 'Menjadi perusahaan teknologi terdepan di Asia Tenggara.',
            'misi' => 'Menyediakan solusi digital inovatif yang bermanfaat untuk masyarakat.',
            'nilai_nilai' => json_encode(['Integritas', 'Inovasi', 'Kolaborasi']),
            'sertifikat' => json_encode(['ISO 9001', 'ISO 27001']),
            'bukti_wajib_lapor' => 'documents/wajib_lapor.pdf',
            'nib' => '1234567890123',
            'linkedin' => 'https://linkedin.com/company/teknologinusantara',
            'instagram' => 'https://instagram.com/teknologinusantara',
            'facebook' => 'https://facebook.com/teknologinusantara',
            'twitter' => 'https://twitter.com/teknologinusantara',
            'youtube' => 'https://youtube.com/@teknologinusantara',
            'tiktok' => 'https://tiktok.com/@teknologinusantara',
            'status_verifikasi' => 'terverifikasi',
        ]);

        PostLowongan::create([
            'job_title' => 'Software Engineer',
            'job_type' => 'Full-time',
            'description' => 'Membuat, mengembangkan, dan memelihara aplikasi berbasis web/mobile.',
            'responsibilities' => 'Menulis clean code, kolaborasi dengan tim, melakukan code review.',
            'requirements' => 'Menguasai PHP/Laravel, React/Flutter, dan dasar-dasar database.',
            'education' => 'S1 Informatika / Ilmu Komputer',
            'experience' => 'Minimal 2 tahun di bidang software development.',
            'salary_range' => '8.000.000 - 12.000.000',
            'benefits' => 'BPJS, Asuransi Kesehatan, WFH fleksibel, pelatihan internal.',
            'location' => 'Surabaya',
            'application_deadline' => now()->addMonths(1), // deadline 1 bulan ke depan
            'accessibility_features' => 'Ruang kerja inklusif, akses lift, jalur kursi roda.',
            'work_accommodations' => 'Jam kerja fleksibel untuk kebutuhan tertentu.',
            'skills' => json_encode(['Laravel', 'React', 'Flutter', 'MySQL']),
            'perusahaan_profile_id' => $perusahaanProfile->id,
        ]);
    }
}
