<x-layouts.app title="Tambah Peserta ke {{ $program->nama_program }}">
    <div class="p-6">
        <a href="{{ route('program.show', $program->id) }}" class="text-blue-500 dark:text-blue-400 hover:underline mb-4 inline-block">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Tambah Peserta</h1>

        <form action="{{ route('program.storeParticipants', $program->id) }}" method="POST">
            @csrf

            <div id="participant-list" class="mb-3 space-y-2">
                @foreach ($program->detailPrograms as $detail)
                    <div class="flex justify-between items-center p-2 border rounded-md dark:border-gray-600 bg-gray-100 dark:bg-gray-700 mb-2 selected-peserta" data-id="{{ $detail->detail_peserta_id }}">
                        <span class="text-gray-900 dark:text-gray-100">{{ $detail->detailPeserta->nama }}</span>
                        <input type="hidden" name="detail_peserta_id[]" value="{{ $detail->detail_peserta_id }}">
                        <button type="button" class="removePeserta bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded shadow-md transition-all duration-300 cursor-pointer">Hapus</button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="openModal" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-md transition-all duration-300 cursor-pointer">
                Pilih Peserta
            </button>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md mt-4 shadow-md transition-all duration-300 cursor-pointer">
                Simpan Peserta
            </button>
        </form>
    </div>

    <!-- MODAL -->
    <div id="participantModal" class="fixed inset-0 z-50 backdrop-blur-md flex items-center justify-center hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl w-11/12 md:w-2/3 lg:w-1/2 transition-all duration-300 transform scale-95 opacity-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Pilih Peserta</h2>
                <button id="closeModal" class="text-gray-500 dark:text-gray-300 hover:text-red-500 text-2xl cursor-pointer">&times;</button>
            </div>

            <div class="overflow-y-auto max-h-80 border dark:border-gray-700 rounded-md">
                <table id="pesertaTable" class="w-full border-collapse">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="p-3 text-left text-gray-900 dark:text-gray-100">Nama</th>
                            <th class="p-3 text-left text-gray-900 dark:text-gray-100">NIK</th>
                            <th class="p-3 text-left text-gray-900 dark:text-gray-100">Tgl Lahir</th>
                            <th class="p-3 text-center text-gray-900 dark:text-gray-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pesertaTableBody" class="dark:bg-gray-900 dark:text-gray-100">
                        @foreach ($pesertas as $peserta)
                            @if (!$program->detailPrograms->contains('detail_peserta_id', $peserta->id))
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all peserta-row" data-id="{{ $peserta->id }}">
                                    <td class="p-3">{{ $peserta->nama }}</td>
                                    <td class="p-3">{{ $peserta->nomor_induk_kependudukan }}</td>
                                    <td class="p-3">{{ $peserta->tanggal_lahir }}</td>
                                    <td class="p-3 text-center">
                                        <button type="button" class="selectPeserta bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md shadow-sm transition-all duration-300 cursor-pointer" data-id="{{ $peserta->id }}" data-nama="{{ $peserta->nama }}">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button id="closeModalFooter" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md w-full shadow-md transition-all duration-300 cursor-pointer">Tutup</button>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        const modal = document.getElementById('participantModal');
        const modalContent = modal.querySelector('.transition-all');
        const tableBody = document.getElementById('pesertaTableBody');

        function updatePesertaList() {
            document.querySelectorAll('.selected-peserta').forEach(el => {
                let id = el.getAttribute('data-id');
                let row = document.querySelector(`.peserta-row[data-id="${id}"]`);
                if (row) row.remove();
            });
        }

        document.getElementById('openModal').addEventListener('click', function () {
    updatePesertaList();
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 50);
});

function closeModal() {
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 200);
}

document.getElementById('closeModal').addEventListener('click', closeModal);
document.getElementById('closeModalFooter').addEventListener('click', closeModal);

// Event Delegation: Menangani klik pada tombol "Pilih" secara dinamis
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('selectPeserta')) {
        let id = event.target.getAttribute('data-id');
        let nama = event.target.getAttribute('data-nama');

        if (document.querySelector(`#participant-list [data-id="${id}"]`)) return;

        let container = document.getElementById('participant-list');
        let pesertaDiv = document.createElement('div');
        pesertaDiv.classList.add('flex', 'justify-between', 'items-center', 'p-2', 'border', 'rounded-md', 'dark:border-gray-600', 'bg-gray-100', 'dark:bg-gray-700', 'mb-2', 'selected-peserta');
        pesertaDiv.setAttribute('data-id', id);
        pesertaDiv.innerHTML = `
            <span class="text-gray-900 dark:text-gray-100">${nama}</span>
            <input type="hidden" name="detail_peserta_id[]" value="${id}">
            <button type="button" class="removePeserta bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded shadow-md transition-all duration-300 cursor-pointer">Hapus</button>
        `;

        container.appendChild(pesertaDiv);
        event.target.closest('tr').remove();  // Hapus peserta dari tabel modal
        closeModal();
    }
});

// Event Delegation: Menangani klik pada tombol "Hapus" secara dinamis
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('removePeserta')) {
        let pesertaDiv = event.target.closest('.selected-peserta');
        let id = pesertaDiv.getAttribute('data-id');
        let nama = pesertaDiv.querySelector('span').innerText;

        pesertaDiv.remove(); // Hapus dari daftar peserta yang dipilih

        let rowHTML = `
            <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all peserta-row" data-id="${id}">
                <td class="p-3">${nama}</td>
                <td class="p-3 text-center">
                    <button type="button" class="selectPeserta bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md shadow-sm transition-all duration-300 cursor-pointer" data-id="${id}" data-nama="${nama}">
                        Pilih
                    </button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', rowHTML);
    }
});

// Fungsi untuk menyembunyikan peserta yang sudah dipilih
function updatePesertaList() {
    document.querySelectorAll('.selected-peserta').forEach(el => {
        let id = el.getAttribute('data-id');
        let row = document.querySelector(`.peserta-row[data-id="${id}"]`);
        if (row) row.remove();
    });
}

updatePesertaList();

    </script>
</x-layouts.app>
