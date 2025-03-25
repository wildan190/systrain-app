<x-layouts.app title="Detail Program - {{ $program->nama_program }}">
    <div class="p-6">
        <a href="{{ route('program.index') }}" class="text-blue-500 hover:underline mb-4 inline-block">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Program
        </a>

        <h1 class="text-2xl font-bold mb-4">{{ $program->nama_program }}</h1>

        <div class="mb-6">
            <p><strong>Batch:</strong> {{ $program->batch }}</p>
            <p><strong>Peserta:</strong> {{ $program->peserta }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ date('d M Y', strtotime($program->tanggal_mulai)) }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ date('d M Y', strtotime($program->tanggal_selesai)) }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($program->harga, 0, ',', '.') }}</p>
        </div>

        <a href="{{ route('program.addParticipants', $program->id) }}" 
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
            <i class="fas fa-user-plus"></i> Tambah Peserta
        </a>

        <h2 class="text-xl font-bold mt-6">Peserta Terdaftar</h2>

        @if ($pesertas->isEmpty())
            <p class="text-gray-500 mt-3">Belum ada peserta dalam program ini.</p>
        @else
            <table class="w-full mt-4 border-collapse border border-gray-300 dark:border-gray-600">
    <thead>
        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <th class="border px-4 py-2">No.</th>
            <th class="border px-4 py-2">Nomor Peserta</th>
            <th class="border px-4 py-2">Nama Peserta</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesertas as $index => $peserta)
            <tr class="border border-gray-300 dark:border-gray-600">
                <td class="border px-4 py-2 text-center text-gray-800 dark:text-gray-200">{{ $index + 1 }}</td>
                <td class="border px-4 py-2 text-center text-gray-800 dark:text-gray-200">{{ $peserta->nomor_peserta }}</td>
                <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">{{ $peserta->detailPeserta->nama }}</td>
                <td class="border px-4 py-2 text-center">
                    <button onclick="confirmDelete({{ $peserta->id }})"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md dark:bg-red-600 dark:hover:bg-red-700">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

        @endif

        <form id="delete-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Peserta akan dihapus dari program ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("delete-form").setAttribute("action", "/admin/program/peserta/delete/" + id);
                        document.getElementById("delete-form").submit();
                    }
                });
            }
        </script>
    </div>
</x-layouts.app>
