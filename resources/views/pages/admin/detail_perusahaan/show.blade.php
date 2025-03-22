<x-layouts.app title="Tambah Detail Perusahaan">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h2 class="text-2xl font-semibold mb-4">Tambah Detail Perusahaan</h2>

            <!-- Menampilkan error jika ada -->
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

            <!-- Form untuk menyimpan Detail Perusahaan -->
            <form id="formDetailPerusahaan" action="{{ route('detail_perusahaan.store', $detailPesertaId) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kode_perusahaan" class="block text-sm font-medium">Kode Perusahaan</label>
                        <input type="text" name="kode_perusahaan" id="kode_perusahaan"
                               value="{{ $detailPerusahaan->kode_perusahaan ?? '-' }}"
                               class="w-full border rounded-md px-4 py-2" required>
                    </div>

                    <div>
                        <label for="nama_perusahaan" class="block text-sm font-medium">Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan"
                               value="{{ $detailPerusahaan->nama_perusahaan ?? '-' }}"
                               class="w-full border rounded-md px-4 py-2" required>
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium">Alamat</label>
                        <input type="text" name="alamat" id="alamat"
                               value="{{ $detailPerusahaan->alamat ?? '-' }}"
                               class="w-full border rounded-md px-4 py-2">
                    </div>

                    <div>
                        <label for="telepon" class="block text-sm font-medium">Telepon</label>
                        <input type="text" name="telepon" id="telepon"
                               value="{{ $detailPerusahaan->telepon ?? '-' }}"
                               class="w-full border rounded-md px-4 py-2">
                    </div>

                    <div>
                        <label for="jabatan" class="block text-sm font-medium">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                               value="{{ $detailPerusahaan->jabatan ?? '-' }}"
                               class="w-full border rounded-md px-4 py-2">
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('detail_peserta.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md">Kembali</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tambahkan SweetAlert dan Skrip Redirect -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('formDetailPerusahaan').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form langsung submit

            let form = this;

            Swal.fire({
                title: 'Sukses!',
                text: 'Detail Perusahaan berhasil ditambahkan',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form setelah Swal ditutup
                }
            });
        });
    </script>
</x-layouts.app>
