<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahli K3 Specialist - Sertifikasi Kemnaker RI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Pendaftaran Ahli K3 Specialist<br><small class="text-muted">Sertifikasi Kemnaker RI</small></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('k3.general.kemnaker.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="row">
            <!-- Nama -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>

            <!-- Telepon -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" required>
                </div>
            </div>

            <!-- Kategori -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach(App\Domain\Category\Model\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Ukuran Seragam -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ukuran_seragam" class="form-label">Ukuran Seragam</label>
                    <input type="text" name="ukuran_seragam" class="form-control" required>
                </div>
            </div>

            <!-- Referal -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="referal" class="form-label">Referal</label>
                    <input type="text" name="referal" class="form-control">
                </div>
            </div>

            <!-- Sumber Informasi -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="sumber_informasi" class="form-label">Sumber Informasi</label>
                    <input type="text" name="sumber_informasi" class="form-control">
                </div>
            </div>

            <!-- Pilihan Program -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="program_id" class="form-label">Pilih Program</label>
                    <select name="program_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Program Kepelatihan</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
