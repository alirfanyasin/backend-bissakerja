<?php

namespace Database\Seeders;

use App\Models\Disabilitas;
use Illuminate\Database\Seeder;

class DisabilitasSeeder extends Seeder
{
    public function run(): void
    {
        $list = [
            ['kategori_disabilitas' => 'Tuna Netra', 'tingkat_disabilitas' => 'Sedang'],
            ['kategori_disabilitas' => 'Tuna Daksa', 'tingkat_disabilitas' => 'Ringan'],
            ['kategori_disabilitas' => 'Tuna Rungu', 'tingkat_disabilitas' => 'Berat'],
        ];

        foreach ($list as $item) {
            Disabilitas::firstOrCreate($item);
        }
    }
}
