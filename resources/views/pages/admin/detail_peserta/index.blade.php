<x-layouts.app title="Detail Peserta">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Detail Peserta</h1>

            <!-- Search Form -->
            <form action="{{ route('detail_peserta.index') }}" method="GET" class="flex space-x-2">
                <input type="text" name="search" placeholder="Cari peserta..." value="{{ request('search') }}"
                    class="border rounded-lg px-3 py-2 dark:bg-gray-800 dark:text-white">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <a href="{{ route('detail_peserta.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-plus"></i> Tambah Peserta
            </a>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif

        @if ($peserta->isEmpty())
            <div class="text-center text-gray-500 dark:text-gray-400">
                @if (request('search'))
                    <p>Peserta dengan kata kunci "{{ request('search') }}" tidak ditemukan.</p>
                @else
                    <p>Belum ada data peserta.</p>
                @endif
            </div>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($peserta as $item)
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 relative">
                        <img src="{{ asset('assets/img/avatar.png') }}" alt="Avatar"
                            class="w-20 h-20 rounded-full mx-auto mb-4">
                        <h2 class="text-xl font-semibold text-center">{{ $item->nama }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-center">{{ $item->email }}</p>
                        <p class="text-gray-700 dark:text-gray-300 text-center"><i class="fas fa-phone"></i>
                            {{ $item->telepon }}</p>
                        <p class="text-gray-500 text-sm text-center">Bergabung: {{ $item->created_at->format('d M Y') }}
                        </p>

                        <div class="flex justify-center space-x-4 mt-4">
                            <a href="{{ route('detail_peserta.edit', $item->id) }}"
                                class="text-yellow-500 hover:text-yellow-600">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete({{ $item->id }})"
                                class="text-red-500 hover:text-red-600">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            <a href="{{ route('data_skp.show', $item->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded">
                                <i class="fas fa-file-alt"></i> Doc SKP
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $peserta->links() }}
            </div>
        @endif

        <form id="delete-form" method="POST" style="display: none;">
            @csrf
        </form>

        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data akan dihapus permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("delete-form").setAttribute("action", "/detail-peserta/delete/" + id);
                        document.getElementById("delete-form").submit();
                    }
                });
            }
        </script>
    </div>
</x-layouts.app>
