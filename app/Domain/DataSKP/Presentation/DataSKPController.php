<?php

namespace App\Domain\DataSKP\Presentation;

use App\Domain\DataSKP\Action\CreateOrUpdate;
use App\Domain\DataSKP\Action\Destroy;
use App\Domain\DataSKP\Infrastructure\DataSKPRepository;
use App\Domain\DetailPeserta\Model\DetailPeserta;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessSKPData;
use Illuminate\Http\Request;

class DataSKPController extends Controller
{
    protected DataSKPRepository $repository;

    public function __construct(DataSKPRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show($detailPesertaId)
    {
        $dataSKP = $this->repository->findByDetailPesertaId($detailPesertaId);

        // Generate preview URLs
        if ($dataSKP) {
            $fileFields = [
                'upload_surat_permohonan',
                'upload_sertifikat_pembinaan',
                'upload_sk_kerja',
                'upload_surat_pernyataan_kerja',
                'upload_rekapitulasi',
                'upload_pas_foto',
                'upload_ijazah_terakhir',
                'upload_paklaring',
                'upload_surat_pengantar',
                'upload_pernyataan_personel',
                'upload_ktp',
                'upload_keahlian_teknis',
                'upload_cv',
                'upload_laporan_kegiatan',
                'upload_sk_pensiun',
            ];

            foreach ($fileFields as $field) {
                if ($dataSKP->$field) {
                    $dataSKP->{$field.'_url'} = $this->repository->getGoogleDriveFileUrl($dataSKP->$field);
                } else {
                    $dataSKP->{$field.'_url'} = null;
                }
            }
        }

        return view('pages.admin.data_skp.show', compact('dataSKP', 'detailPesertaId'));
    }

    public function store(Request $request, CreateOrUpdate $action, $detailPesertaId)
    {
        $detailPeserta = DetailPeserta::findOrFail($detailPesertaId); // Ambil data peserta

        $fileUploads = [];
        $fileFields = [
            'upload_surat_permohonan',
            'upload_sertifikat_pembinaan',
            'upload_sk_kerja',
            'upload_surat_pernyataan_kerja',
            'upload_rekapitulasi',
            'upload_pas_foto',
            'upload_ijazah_terakhir',
            'upload_paklaring',
            'upload_surat_pengantar',
            'upload_pernyataan_personel',
            'upload_ktp',
            'upload_keahlian_teknis',
            'upload_cv',
            'upload_laporan_kegiatan',
            'upload_sk_pensiun',
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $filename = $field.'_'.time().'.'.$request->file($field)->getClientOriginalExtension();
                $fileUploads[$field] = $this->repository->uploadFileToGoogleDrive($request->file($field), $filename, $detailPeserta);
            }
        }

        $data = array_merge($request->except($fileFields), $fileUploads);

        // Dispatch job untuk memproses data ke queue Redis
        ProcessSKPData::dispatch($detailPesertaId, $data, new Request($data));

        return redirect()->back()->with('success', 'Data SKP berhasil diperbarui.');
    }

    public function destroy(Destroy $action, $id)
    {
        $action->execute($id);

        return redirect()->back()->with('success', 'Data SKP berhasil dihapus dari database.');
    }
}
