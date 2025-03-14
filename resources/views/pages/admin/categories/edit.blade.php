<x-layouts.app title="Edit Kategori">
    <div class="flex flex-col gap-4 p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">✏ Edit Kategori</h1>
            <a href="{{ route('categories.index') }}"
                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-md transition-all">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <form id="update-form" action="{{ route('categories.update', $category->id) }}" method="POST"
                class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ $category->nama_kategori }}"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="w-full border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">{{ $category->deskripsi }}</textarea>
                </div>
                <button type="submit"
                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md transition-all">
                    <i class="fas fa-check"></i> Update
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("update-form").addEventListener("submit", function(event) {
            event.preventDefault();
            Swal.fire({
                title: "Berhasil!",
                text: "Kategori berhasil diperbarui.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                event.target.submit();
            });
        });
    </script>
</x-layouts.app>
