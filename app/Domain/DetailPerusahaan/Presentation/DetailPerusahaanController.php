<?php

namespace App\Domain\DetailPerusahaan\Presentation;

use App\Domain\DetailPerusahaan\Action\CreateOrUpdate;
use App\Domain\DetailPerusahaan\Action\Destroy;
use App\Domain\DetailPerusahaan\Infrastructure\DetailPerusahaanRepository;
use App\Domain\DetailPeserta\Model\DetailPeserta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailPerusahaanController extends Controller
{
    protected DetailPerusahaanRepository $repository;

    public function __construct(DetailPerusahaanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show($detailPesertaId)
    {
        $detailPerusahaan = $this->repository->findByDetailPesertaId($detailPesertaId);

        return view('pages.admin.detail_perusahaan.show', compact('detailPerusahaan', 'detailPesertaId'));
    }

    public function store(Request $request, CreateOrUpdate $action, $detailPesertaId)
    {
        $detailPeserta = DetailPeserta::findOrFail($detailPesertaId);

        $validatedData = $request->validate([
            'kode_perusahaan' => 'nullable|string|max:255',
            'nama_perusahaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $action->execute($request, $detailPesertaId);

        return redirect()->back()->with('success', 'Data Detail Perusahaan berhasil disimpan.');
    }

    public function destroy(Destroy $action, $id)
    {
        $action->execute($id);

        return redirect()->back()->with('success', 'Data Detail Perusahaan berhasil dihapus.');
    }
}
