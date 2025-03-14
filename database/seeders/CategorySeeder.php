<?php

namespace Database\Seeders;

use App\Domain\Category\Model\Category;
use App\Domain\DetailPeserta\Model\DetailPeserta;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['nama_kategori' => 'Personal', 'deskripsi' => 'Kategori untuk penggunaan pribadi'],
            ['nama_kategori' => 'Utusan Perusahaan', 'deskripsi' => 'Kategori untuk perwakilan perusahaan'],
        ]);
        DetailPeserta::factory()->count(50)->create();
    }
}
