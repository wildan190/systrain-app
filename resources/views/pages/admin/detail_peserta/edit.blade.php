<x-layouts.app title="Edit Peserta">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 w-full max-w-5xl">
            <h2 class="text-2xl font-semibold text-center mb-6">Edit Peserta</h2>

            <form action="{{ route('detail_peserta.update', $peserta->id) }}" method="POST">
                @csrf
                @method('PUT')

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

                <!-- 🔹 DATA PRIBADI -->
                <fieldset class="border p-4 rounded-lg mb-6">
                    <legend class="text-lg font-semibold px-2">Data Pribadi</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" required
                                value="{{ old('nama', $peserta->nama) }}" class="w-full border rounded-md px-4 py-2">
                        </div>

                        <div>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" required
                                value="{{ old('email', $peserta->email) }}" class="w-full border rounded-md px-4 py-2">
                        </div>

                        <div>
                            <label for="telepon">Nomor Telepon</label>
                            <input type="text" name="telepon" id="telepon" required
                                value="{{ old('telepon', $peserta->telepon) }}"
                                class="w-full border rounded-md px-4 py-2">
                        </div>

                        <div>
                            <label for="nik">NIK</label>
                            <input type="text" name="nomor_induk_kependudukan" id="nik" required
                                value="{{ old('nomor_induk_kependudukan', $peserta->nomor_induk_kependudukan) }}"
                                class="w-full border rounded-md px-4 py-2">
                        </div>

                        <div>
                            <label>Jenis Kelamin</label>
                            <div class="flex space-x-4">
                                <label><input type="radio" name="jenis_kelamin" value="Laki-laki"
                                        {{ $peserta->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
                                <label><input type="radio" name="jenis_kelamin" value="Perempuan"
                                        {{ $peserta->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
                            </div>
                        </div>

                        <div>
                            <label for="golongan_darah">Golongan Darah</label>
                            <select name="golongan_darah" id="golongan_darah"
                                class="w-full border rounded-md px-4 py-2">
                                <option value="" disabled
                                    {{ old('golongan_darah', $peserta->golongan_darah) == '' ? 'selected' : '' }}>Pilih
                                    Golongan Darah</option>
                                @foreach (['A', 'B', 'AB', 'O'] as $golongan)
                                    <option value="{{ $golongan }}"
                                        {{ old('golongan_darah', $peserta->golongan_darah) == $golongan ? 'selected' : '' }}>
                                        {{ $golongan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="agama">Agama</label>
                            <select name="agama" id="agama" class="w-full border rounded-md px-4 py-2">
                                <option value="" disabled
                                    {{ old('agama', $peserta->agama) == '' ? 'selected' : '' }}>Pilih Agama</option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                    <option value="{{ $agama }}"
                                        {{ old('agama', $peserta->agama) == $agama ? 'selected' : '' }}>
                                        {{ $agama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- 🔹 PENDIDIKAN -->
                <fieldset class="border p-4 rounded-lg mb-6">
                    <legend class="text-lg font-semibold px-2">Pendidikan</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir"
                                class="w-full border rounded-md px-4 py-2">
                                <option value="" disabled
                                    {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == '' ? 'selected' : '' }}>
                                    Pilih Pendidikan Terakhir</option>
                                @foreach (['SD', 'SMP', 'SMA', 'Diploma', 'Sarjana', 'Magister', 'Doktor'] as $level)
                                    <option value="{{ $level }}"
                                        {{ old('pendidikan_terakhir', $peserta->pendidikan_terakhir) == $level ? 'selected' : '' }}>
                                        {{ $level }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="nama_sekolah">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" id="nama_sekolah"
                                value="{{ old('nama_sekolah', $peserta->nama_sekolah) }}"
                                class="w-full border rounded-md px-4 py-2">
                        </div>
                    </div>
                </fieldset>

                <!-- 🔹 TEMPAT & TANGGAL LAHIR -->
                <fieldset class="border p-4 rounded-lg mb-6">
                    <legend class="text-lg font-semibold px-2">Tempat & Tanggal Lahir</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir"
                                value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}"
                                class="w-full border rounded-md px-4 py-2">
                        </div>

                        <div>
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $peserta->tanggal_lahir) }}"
                                class="w-full border rounded-md px-4 py-2">
                        </div>
                    </div>
                </fieldset>

                <!-- 🔹 ALAMAT -->
                <fieldset class="border p-4 rounded-lg mb-6">
                    <legend class="text-lg font-semibold px-2">Alamat</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="provinsi">Provinsi</label>
                            <input type="text" name="provinsi" id="provinsi"
                                value="{{ old('provinsi', $peserta->provinsi) }}"
                                class="w-full border rounded-md px-4 py-2">
                        </div>

                        <div>
                            <label for="kabupaten">Kabupaten</label>
                            <input type="text" name="kabupaten" id="kabupaten"
                                value="{{ old('kabupaten', $peserta->kabupaten) }}"
                                class="w-full border rounded-md px-4 py-2">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="w-full border rounded-md px-4 py-2">{{ old('alamat', $peserta->alamat) }}</textarea>
                    </div>
                </fieldset>

                <!-- 🔹 TOMBOL -->
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('detail_peserta.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md">Kembali</a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
