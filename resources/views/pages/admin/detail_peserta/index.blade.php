<x-layouts.app title="Detail Peserta">
    <div class="p-6">
        <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Detail Peserta</h1>

            <!-- Search Form -->
            <form action="{{ route('detail_peserta.index') }}" method="GET" class="flex space-x-2">
                <input type="text" name="search" placeholder="Cari peserta..." value="{{ request('search') }}"
                    class="border rounded-lg px-3 py-2 dark:bg-gray-800 dark:text-white focus:ring focus:ring-blue-300">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <a href="{{ route('detail_peserta.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
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
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 relative">
                        <div class="absolute top-3 right-3">
                            <!-- Dropdown Button -->
                            <div class="relative">
                                <button onclick="toggleDropdown(event, {{ $item->id }})"
                                    class="text-gray-600 dark:text-gray-300 hover:text-gray-800 focus:outline-none">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="dropdown-{{ $item->id }}"
                                    class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 border rounded-lg shadow-lg z-10">
                                    <a href="{{ route('detail_peserta.edit', $item->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete({{ $item->id }})"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-600">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <img src="{{ asset('assets/img/avatar.png') }}" alt="Avatar"
                            class="w-20 h-20 rounded-full mx-auto mb-4">
                        <h2 class="text-xl font-semibold text-center text-gray-900 dark:text-white">{{ $item->nama }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 text-center">{{ $item->email }}</p>
                        <p class="text-gray-700 dark:text-gray-300 text-center"><i class="fas fa-phone"></i>
                            {{ $item->telepon }}</p>
                        <p class="text-green-500 dark:text-green-400 text-center">
                            <a href="https://wa.me/{{ $item->telepon }}" target="_blank">
                                <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                            </a>
                        </p>
                        <p class="text-yellow-500 dark:text-yellow-400 text-center">
                            {{ $item->category->nama_kategori }}</p>
                        <p class="text-gray-500 text-sm text-center">Bergabung:
                            {{ $item->created_at->format('d M Y') }}</p>

                        <div class="flex justify-center mt-4 space-x-4">
                            {{-- <a href="{{ route('data_skp.show', $item->id) }}"
                                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition duration-300">
                                <i class="fas fa-file-alt"></i> Doc SKP
                            </a> --}}

                            <a href="{{ route('data_training.show', $item->id) }}"
                                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition duration-300">
                                <i class="fas fa-file-alt"></i> Data Training
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
            @method('DELETE')
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
                        document.getElementById("delete-form").setAttribute("action", "/admin/detail-peserta/" + id);
                        document.getElementById("delete-form").submit();
                    }
                });
            }

            function toggleDropdown(event, id) {
                event.stopPropagation();
                let dropdown = document.getElementById("dropdown-" + id);
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                    if (el !== dropdown) {
                        el.classList.add("hidden");
                    }
                });
                dropdown.classList.toggle("hidden");
            }

            document.addEventListener("click", function() {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                    el.classList.add("hidden");
                });
            });
        </script>
    </div>
</x-layouts.app>
