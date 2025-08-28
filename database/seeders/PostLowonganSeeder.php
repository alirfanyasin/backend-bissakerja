<?php
// database/seeders/PostLowonganSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostLowongan;
use App\Models\PerusahaanProfile;
use App\Models\Disabilitas;
use App\Models\User;

class PostLowonganSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada data disabilitas dulu
        $disabilitasData = [
            ['kategori_disabilitas' => 'Tuna Daksa', 'tingkat_disabilitas' => 'Ringan'],
            ['kategori_disabilitas' => 'Tuna Netra', 'tingkat_disabilitas' => 'Sedang'],
            ['kategori_disabilitas' => 'Tuna Rungu', 'tingkat_disabilitas' => 'Ringan'],
        ];

        foreach ($disabilitasData as $data) {
            Disabilitas::firstOrCreate($data, $data);
        }

        // Ambil atau buat perusahaan profiles yang sudah ada
        $perusahaan1 = PerusahaanProfile::first();
        
        if (!$perusahaan1) {
            // Jika belum ada perusahaan, buat user dulu
            $user1 = User::firstOrCreate(
                ['email' => 'admin@techinnovate.com'],
                [
                    'name' => 'Tech Innovate Admin',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            $perusahaan1 = PerusahaanProfile::create([
                'user_id' => $user1->id,
                'nama_perusahaan' => 'Tech Innovate',
                'industri' => 'Technology',
                'tahun_berdiri' => '2020',
                'jumlah_karyawan' => '50-100',
                'province_id' => '31',
                'regencie_id' => '3171',
                'deskripsi' => 'Perusahaan teknologi yang berfokus pada inovasi dan pengembangan aplikasi web dan mobile.',
                'no_telp' => '021-1234567',
                'link_website' => 'https://techinnovate.com',
                'alamat_lengkap' => 'Jl. Sudirman No. 123, Jakarta Selatan, DKI Jakarta',
                'visi' => 'Menjadi perusahaan teknologi terdepan di Indonesia',
                'misi' => 'Memberikan solusi teknologi terbaik untuk kemajuan bangsa',
                'nilai_nilai' => 'Innovation, Quality, Integrity',
                'status_verifikasi' => 'verified',
            ]);
        }

        // Buat perusahaan kedua jika belum ada
        $perusahaan2 = PerusahaanProfile::where('nama_perusahaan', 'Digital Solutions')->first();
        
        if (!$perusahaan2) {
            $user2 = User::firstOrCreate(
                ['email' => 'admin@digitalsolutions.com'],
                [
                    'name' => 'Digital Solutions Admin',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            $perusahaan2 = PerusahaanProfile::create([
                'user_id' => $user2->id,
                'nama_perusahaan' => 'Digital Solutions',
                'industri' => 'Software Development',
                'tahun_berdiri' => '2019',
                'jumlah_karyawan' => '10-50',
                'province_id' => '32',
                'regencie_id' => '3273',
                'deskripsi' => 'Penyedia solusi digital untuk berbagai industri dengan fokus pada kualitas dan inovasi.',
                'no_telp' => '022-9876543',
                'link_website' => 'https://digitalsolutions.com',
                'alamat_lengkap' => 'Jl. Dago No. 456, Bandung, Jawa Barat',
                'visi' => 'Digitalisasi untuk semua kalangan',
                'misi' => 'Membantu bisnis bertransformasi digital',
                'nilai_nilai' => 'Excellence, Innovation, Collaboration',
                'status_verifikasi' => 'verified',
            ]);
        }

        // Buat lowongan pekerjaan
        $lowonganData = [
            [
                'job_title' => 'Frontend Developer',
                'job_type' => 'Full Time',
                'description' => 'Kami mencari Frontend Developer yang berpengalaman untuk bergabung dengan tim pengembangan kami. Kandidat yang ideal memiliki passion dalam menciptakan user interface yang menarik dan fungsional.',
                'responsibilities' => 'Mengembangkan aplikasi web responsif menggunakan React.js, Berkolaborasi dengan tim UI/UX untuk implementasi desain, Optimasi performa aplikasi frontend, Maintain dan debug aplikasi yang sudah ada',
                'requirements' => 'Minimal S1 Teknik Informatika atau bidang terkait, Pengalaman 2-3 tahun dalam pengembangan web, Menguasai HTML, CSS, JavaScript, React.js, Familiar dengan Git dan version control, Memiliki portfolio yang dapat ditunjukkan',
                'education' => 'S1 Teknik Informatika',
                'experience' => '2-3 tahun',
                'salary_range' => 'Rp 8.000.000 - Rp 12.000.000',
                'benefits' => 'Asuransi kesehatan, Bonus tahunan, Flexible working hours, Learning budget Rp 2.000.000/tahun',
                'location' => 'Jakarta, Indonesia',
                'application_deadline' => now()->addDays(30)->format('Y-m-d'),
                'accessibility_features' => 'Kantor ramah kursi roda, Fasilitas parkir khusus disabilitas',
                'work_accommodations' => 'Flexible working hours, Remote work option, Assistive technology support',
                'skills' => json_encode(['React', 'TypeScript', 'CSS', 'JavaScript', 'Git', 'HTML']),
                'perusahaan_profile_id' => $perusahaan1->id,
                'disabilitas_ids' => [1, 3] // Tuna Daksa dan Tuna Rungu
            ],
            [
                'job_title' => 'Backend Developer',
                'job_type' => 'Full Time',
                'description' => 'Bergabunglah dengan tim backend kami untuk mengembangkan sistem yang robust dan scalable. Kami mencari developer yang memiliki pemahaman mendalam tentang server-side development.',
                'responsibilities' => 'Mengembangkan dan maintain REST API, Mengelola database dan optimasi query, Implementasi security best practices, Code review dan dokumentasi teknis',
                'requirements' => 'Minimal S1 Teknik Informatika, Pengalaman 1-2 tahun dengan Node.js atau PHP, Menguasai database MySQL/PostgreSQL, Familiar dengan cloud services (AWS/GCP), Pemahaman tentang API design patterns',
                'education' => 'S1 Teknik Informatika',
                'experience' => '1-2 tahun',
                'salary_range' => 'Rp 7.000.000 - Rp 10.000.000',
                'benefits' => 'Remote work available, Health insurance, Learning and development budget, Annual company retreat',
                'location' => 'Bandung, Indonesia',
                'application_deadline' => now()->addDays(25)->format('Y-m-d'),
                'accessibility_features' => 'Akses kursi roda, Toilet khusus disabilitas',
                'work_accommodations' => 'Remote work tersedia, Screen reader compatible workspace, Adjustable desk',
                'skills' => json_encode(['Node.js', 'MongoDB', 'Express', 'API', 'MySQL', 'Docker']),
                'perusahaan_profile_id' => $perusahaan2->id,
                'disabilitas_ids' => [2] // Tuna Netra
            ],
            [
                'job_title' => 'UI/UX Designer',
                'job_type' => 'Full Time',
                'description' => 'Kami mencari UI/UX Designer yang kreatif dan detail-oriented untuk menciptakan pengalaman pengguna yang luar biasa dalam produk digital kami.',
                'responsibilities' => 'Membuat wireframe dan prototype, Melakukan user research dan usability testing, Mendesain interface yang user-friendly, Berkolaborasi dengan developer untuk implementasi design',
                'requirements' => 'Minimal D3 Desain Grafis atau bidang terkait, Pengalaman 2+ tahun dalam UI/UX design, Menguasai Figma, Adobe XD, Sketch, Pemahaman tentang design thinking dan user-centered design, Portfolio yang kuat wajib',
                'education' => 'D3 Desain Grafis',
                'experience' => '2+ tahun',
                'salary_range' => 'Rp 6.500.000 - Rp 9.500.000',
                'benefits' => 'Creative workspace, Design tools allowance, Health insurance, Flexible hours',
                'location' => 'Jakarta, Indonesia',
                'application_deadline' => now()->addDays(20)->format('Y-m-d'),
                'accessibility_features' => 'Pencahayaan yang dapat disesuaikan, Workspace yang ergonomis',
                'work_accommodations' => 'Peralatan design khusus, Software assistive tersedia',
                'skills' => json_encode(['Figma', 'Adobe XD', 'Sketch', 'Prototyping', 'User Research', 'Photoshop']),
                'perusahaan_profile_id' => $perusahaan1->id,
                'disabilitas_ids' => [] // Normal job tanpa requirement khusus disabilitas
            ]
        ];

        foreach ($lowonganData as $data) {
            $disabilitasIds = $data['disabilitas_ids'];
            unset($data['disabilitas_ids']);

            $lowongan = PostLowongan::create($data);

            // Attach disabilitas jika ada
            if (!empty($disabilitasIds)) {
                $lowongan->disabilitas()->attach($disabilitasIds);
            }
        }

        echo "Post Lowongan seeded successfully!\n";
        echo "Created " . PostLowongan::count() . " job vacancies.\n";
    }
}