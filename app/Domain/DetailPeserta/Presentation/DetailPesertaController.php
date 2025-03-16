<?php

namespace App\Domain\DetailPeserta\Presentation;

use App\Domain\Category\Model\Category;
use App\Domain\DetailPerusahaan\Model\DetailPerusahaan;
use App\Domain\DetailPeserta\Action\CreateDetailPeserta;
use App\Domain\DetailPeserta\Action\DestroyDetailPeserta;
use App\Domain\DetailPeserta\Action\UpdateDetailPeserta;
use App\Domain\DetailPeserta\Infrastructure\DetailPesertaRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailPesertaController extends Controller
{
    protected $detailPesertaRepository;

    public function __construct(DetailPesertaRepository $detailPesertaRepository)
    {
        $this->detailPesertaRepository = $detailPesertaRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $peserta = $this->detailPesertaRepository->getAll(9, $search);

        return view('pages.admin.detail_peserta.index', compact('peserta', 'search'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('pages.admin.detail_peserta.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:detail_pesertas',
            'telepon' => 'required|string|max:13',
            'alamat' => 'nullable|string',
            'nomor_induk_kependudukan' => 'required|unique:detail_pesertas|max:16',
            'jenis_kelamin' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'nama_sekolah' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'ukuran_seragam' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'referal' => 'nullable|string',
            'sumber_informasi' => 'nullable|string',
        ]);

        CreateDetailPeserta::handle($data);

        return redirect()->route('detail_peserta.index')->with('success', 'Peserta berhasil ditambahkan');
    }

    public function edit($id)
    {
        $detailPerusahaan = DetailPerusahaan::where('detail_peserta_id', $id)->first();
        $peserta = $this->detailPesertaRepository->findById($id);
        $categories = Category::all();

        return view('pages.admin.detail_peserta.edit', compact('peserta', 'categories', 'detailPerusahaan'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:detail_pesertas,email,'.$id,
            'telepon' => 'required|string|max:13',
            'alamat' => 'required|string',
            'nomor_induk_kependudukan' => 'required|unique:detail_pesertas,nomor_induk_kependudukan,'.$id.'|max:16',
            'jenis_kelamin' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'nama_sekolah' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'ukuran_seragam' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'referal' => 'nullable|string',
            'sumber_informasi' => 'nullable|string',
        ]);

        $peserta = $this->detailPesertaRepository->findById($id);
        UpdateDetailPeserta::handle($peserta, $data);

        return response()->json([
          'success' => true,
          'message' => 'Peserta berhasil diperbarui',
          'redirect' => route('detail_peserta.index')
      ]);
      
    }

    public function destroy($id)
    {
        $peserta = $this->detailPesertaRepository->findById($id);
        DestroyDetailPeserta::handle($peserta);

        return redirect()->route('detail_peserta.index')->with('success', 'Peserta berhasil dihapus');
    }
}
