<x-layouts.app title="Tambah Program">
    <div class="flex flex-col gap-4 p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">➕ Tambah Program</h1>
            <a href="{{ route('program.index') }}"
                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-md transition-all">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <form id="create-form" action="{{ route('program.store') }}" method="POST" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-100 border border-red-400 dark:border-red-600 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle"></i>
                            <span class="ml-2 font-semibold">Terjadi kesalahan!</span>
                        </div>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Nama Program</label>
                    <input type="text" name="nama_program" placeholder="Masukkan nama program"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Batch</label>
                    <input type="number" name="batch" placeholder="Masukkan batch"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Peserta</label>
                    <input type="number" name="peserta" placeholder="Jumlah peserta"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Harga</label>
                    <input type="number" name="harga" placeholder="Masukkan harga"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("create-form").addEventListener("submit", function(event) {
            event.preventDefault();
            Swal.fire({
                title: "Apakah data sudah benar?",
                text: "Pastikan semua data telah diisi dengan benar.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan!"
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    </script>
</x-layouts.app>
