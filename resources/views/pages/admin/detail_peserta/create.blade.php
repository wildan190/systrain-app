<x-layouts.app title="Tambah Peserta">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 w-full max-w-4xl">
            <h2 class="text-2xl font-semibold text-center mb-6">Tambah Peserta</h2>

            <form action="{{ route('detail_peserta.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Terjadi kesalahan!</strong>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Nama -->
                <div class="space-y-1">
                    <label for="nama" class="block font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-user"></i> Nama Lengkap
                    </label>
                    <input type="text" name="nama" id="nama" required placeholder="Masukkan nama lengkap"
                        class="w-full border rounded-md px-4 py-2 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- NIK -->
                <div class="space-y-1 mt-4">
                    <label for="nik" class="block font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-id-card"></i> Nomor Induk Kependudukan (NIK)
                    </label>
                    <input type="text" name="nomor_induk_kependudukan" id="nik" required
                        placeholder="Masukkan NIK (16 digit)"
                        class="w-full border rounded-md px-4 py-2 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div class="space-y-1 mt-4">
                    <label for="email" class="block font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email" id="email" required placeholder="Masukkan email aktif"
                        class="w-full border rounded-md px-4 py-2 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Telepon -->
                <div class="space-y-1 mt-4">
                    <label for="telepon" class="block font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-phone"></i> Nomor Telepon
                    </label>
                    <input type="text" name="telepon" id="telepon" required placeholder="Masukkan nomor telepon"
                        class="w-full border rounded-md px-4 py-2 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Jenis Kelamin -->
                <div class="space-y-1 mt-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-venus-mars"></i> Jenis Kelamin
                    </label>
                    <div class="flex space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" required
                                class="form-radio text-blue-500 focus:ring-blue-500">
                            <span class="text-gray-700 dark:text-gray-300">Laki-laki</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" required
                                class="form-radio text-pink-500 focus:ring-pink-500">
                            <span class="text-gray-700 dark:text-gray-300">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="space-y-1 mt-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-list-alt"></i> Kategori
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($categories as $category)
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="category_id" value="{{ $category->id }}" required
                                    class="form-radio text-green-500 focus:ring-green-500">
                                <span class="text-gray-700 dark:text-gray-300">{{ $category->nama_kategori }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('detail_peserta.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert untuk Notifikasi -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
        </script>
    @endif
</x-layouts.app>
