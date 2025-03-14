<?php

namespace Database\Factories;

use App\Domain\Category\Model\Category;
use App\Domain\DetailPeserta\Model\DetailPeserta;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPesertaFactory extends Factory
{
    protected $model = DetailPeserta::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telepon' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'nomor_induk_kependudukan' => $this->faker->unique()->numerify('##########'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O', null]),
            'pendidikan_terakhir' => $this->faker->randomElement(['SD', 'SMP', 'SMA', 'Diploma', 'Sarjana']),
            'nama_sekolah' => $this->faker->company(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'provinsi' => $this->faker->state(),
            'kabupaten' => $this->faker->city(),
            'ukuran_seragam' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'referal' => $this->faker->name(),
            'sumber_informasi' => $this->faker->randomElement(['Media Sosial', 'Teman', 'Website', 'Brosur']),
        ];
    }
}
