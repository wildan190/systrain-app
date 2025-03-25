<?php

namespace App\Http\Controllers\Web;

use App\Domain\DetailPeserta\Model\DetailPeserta;
use App\Domain\Program\Model\DetailProgram;
use App\Domain\Program\Model\Program;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class K3GeneralKemnakerRIController extends Controller
{
    public function index()
    {
        $programs = Program::all(); // Ambil semua program untuk select option

        return view('pages.web.k3_general_kemnaker-ri.index', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_induk_kependudukan' => 'required|string|max:16',
            'email' => 'required|email|unique:detail_pesertas,email',
            'telepon' => 'required|string|max:15',
            'jenis_kelamin' => 'required|string|max:30',
            'category_id' => 'required|exists:categories,id',
            'ukuran_seragam' => 'required|string|max:10',
            'referal' => 'nullable|string|max:255',
            'sumber_informasi' => 'nullable|string|max:255',
            'program_id' => 'required|exists:programs,id',
        ]);

        // Simpan ke tabel detail_pesertas
        $peserta = DetailPeserta::create([
            'nama' => $request->nama,
            'nomor_induk_kependudukan' => $request->nomor_induk_kependudukan,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'category_id' => $request->category_id,
            'ukuran_seragam' => $request->ukuran_seragam,
            'referal' => $request->referal,
            'sumber_informasi' => $request->sumber_informasi,
        ]);

        // Buat nomor peserta
        $nomorPeserta = 'P-'.str_pad(DetailProgram::max('id') + 1, 5, '0', STR_PAD_LEFT);

        // Simpan ke tabel detail_programs
        DetailProgram::create([
            'program_id' => $request->program_id,
            'nomor_peserta' => $nomorPeserta,
            'detail_peserta_id' => $peserta->id,
        ]);

        return redirect()->route('k3.general.kemnaker.index')->with('success', 'Pendaftaran berhasil!');
    }
}
