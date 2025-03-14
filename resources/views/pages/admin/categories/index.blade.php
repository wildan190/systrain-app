<x-layouts.app title="Daftar Kategori">
    <div class="flex flex-col gap-4 p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">📂 Daftar Kategori</h1>
            <a href="{{ route('categories.create') }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 shadow-md">
            <table class="w-full text-sm text-left text-gray-800 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3">Nama Kategori</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr
                            class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <td class="px-4 py-3">{{ $category->nama_kategori }}</td>
                            <td class="px-4 py-3">{{ $category->deskripsi }}</td>
                            <td class="px-4 py-3 flex justify-center gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button onclick="deleteCategory({{ $category->id }})"
                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>

                                <form id="delete-form-{{ $category->id }}"
                                    action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteCategory(categoryId) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data kategori ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${categoryId}`).submit();
                }
            });
        }
    </script>
</x-layouts.app>
