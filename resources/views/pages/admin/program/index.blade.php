<x-layouts.app title="Daftar Program">
    <div class="p-6">
        <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Program</h1>

            <!-- Search Form -->
            <form action="{{ route('program.index') }}" method="GET" class="flex space-x-2">
                <input type="text" name="search" placeholder="Cari program..." value="{{ request('search') }}"
                    class="border rounded-lg px-3 py-2 dark:bg-gray-800 dark:text-white focus:ring focus:ring-blue-300">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <a href="{{ route('program.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Program
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

        @if ($programs->isEmpty())
            <div class="text-center text-gray-500 dark:text-gray-400">
                @if (request('search'))
                    <p>Program dengan kata kunci "{{ request('search') }}" tidak ditemukan.</p>
                @else
                    <p>Belum ada data program.</p>
                @endif
            </div>
        @else
            <div class="grid md:grid-cols-3 gap-6">
    @foreach ($programs as $program)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 relative border border-gray-200 dark:border-gray-700">

            <!-- Dropdown Button -->
            <div class="absolute top-3 right-3">
                <div class="relative">
                    <button onclick="toggleDropdown(event, {{ $program->id }})"
                        class="text-gray-600 dark:text-gray-300 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdown-{{ $program->id }}"
                        class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 border rounded-lg shadow-lg z-10">
                        <a href="{{ route('program.edit', $program->id) }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button onclick="confirmDelete({{ $program->id }})"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-600">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>

            <!-- Icon Header -->
            <div class="flex justify-center items-center bg-blue-500 text-white w-16 h-16 rounded-full mx-auto shadow-md">
                <i class="fas fa-chalkboard-teacher text-2xl"></i>
            </div>

            <!-- Nama Program -->
            <h2 class="text-xl font-semibold text-center text-gray-900 dark:text-white mt-4">
                {{ $program->nama_program }}
            </h2>

            <!-- Informasi Program -->
            <div class="flex flex-col items-center text-gray-700 dark:text-gray-300 text-sm mt-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-layer-group"></i> <span>Batch {{ $program->batch }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-users"></i> 
                    <span>{{ $program->detailPrograms->count() }} Peserta Terdaftar</span>
                </div>
            </div>

            <!-- Jadwal -->
            <div class="mt-3 text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    <i class="fas fa-calendar-alt mr-1"></i> Mulai:
                    {{ date('d M Y', strtotime($program->tanggal_mulai)) }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    <i class="fas fa-calendar-check mr-1"></i> Selesai:
                    {{ date('d M Y', strtotime($program->tanggal_selesai)) }}
                </p>
            </div>

            <!-- Harga -->
            <p class="flex justify-center items-center gap-2 text-green-600 font-bold text-lg mt-3">
                <i class="fas fa-money-bill-wave"></i> Rp {{ number_format($program->harga, 0, ',', '.') }}
            </p>

            <!-- Tombol Lihat Detail -->
            <a href="{{ route('program.show', $program->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm flex justify-center mt-3">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
        </div>
    @endforeach
</div>


            <div class="mt-6">
                {{ $programs->links() }}
            </div>
        @endif

        <form id="delete-form" method="POST" style="display: none;">
            @csrf
            @method('POST')
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
                        document.getElementById("delete-form").setAttribute("action", "/program/delete/" + id);
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
