<?php

namespace App\Domain\DataTraining\Presentation;

use App\Domain\DataTraining\Action\CreateOrUpdate;
use App\Domain\DataTraining\Action\Destroy;
use App\Domain\DataTraining\Infrastructure\DataTrainingRepository;
use App\Domain\DataTraining\Job\ProcessDataTraining;
use App\Domain\DetailPeserta\Model\DetailPeserta;
use App\Http\Controllers\Controller;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class DataTrainingController extends Controller
{
    protected DataTrainingRepository $repository;

    public function __construct(DataTrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show($detailPesertaId)
    {
        $dataTraining = $this->repository->findByDetailPesertaId($detailPesertaId);

        // Generate preview URLs
        if ($dataTraining) {
            $fileFields = [
                'detail_peserta_id',
                'upload_pas_foto_biru',
                'upload_ktp',
                'upload_npwp',
                'upload_cv',
                'upload_sk_kerja',
                'upload_keterangan_sehat',
                'upload_pakta_integritas',
                'upload_ijazah',
                'upload_sertifikat_k3',
            ];

            foreach ($fileFields as $field) {
                if ($dataTraining->$field) {
                    $dataTraining->{$field.'_url'} = $this->repository->getGoogleDriveFileUrl($dataTraining->$field);
                } else {
                    $dataTraining->{$field.'_url'} = null;
                }
            }
        }

        return view('pages.admin.data_training.show', compact('dataTraining', 'detailPesertaId'));
    }

    public function store(Request $request, CreateOrUpdate $action, $detailPesertaId)
    {
        $detailPeserta = DetailPeserta::findOrFail($detailPesertaId);

        // Validasi file harus PDF dan maksimal 5MB
        $fileFields = [
            'detail_peserta_id',
            'upload_pas_foto_biru',
            'upload_ktp',
            'upload_npwp',
            'upload_cv',
            'upload_sk_kerja',
            'upload_keterangan_sehat',
            'upload_pakta_integritas',
            'upload_ijazah',
            'upload_sertifikat_k3',
        ];

        $rules = [];
        foreach ($fileFields as $field) {
            $rules[$field] = 'nullable|file|mimes:pdf|max:5120'; // Maksimum 5MB (5120 KB)
        }

        $validatedData = $request->validate($rules);

        $fileUploads = [];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $filename = $field.'_'.time().'.'.$request->file($field)->getClientOriginalExtension();
                $fileUploads[$field] = $this->repository->uploadFileToGoogleDrive($request->file($field), $filename, $detailPeserta);
            }
        }

        $data = array_merge($request->except($fileFields), $fileUploads);

        // Buat batch job
        $batch = Bus::batch([
            new ProcessDataTraining($detailPesertaId, $data, new Request($data)),
        ])
            ->then(function (Batch $batch) {
                Log::info('Batch Selesai: '.$batch->id);
            })
            ->catch(function (Batch $batch, Throwable $e) {
                Log::error('Batch Gagal: '.$e->getMessage());
            })
            ->finally(function (Batch $batch) {
                Log::info('Batch Diproses: '.$batch->id);
            })
            ->dispatch();

        return redirect()->back()->with('success', 'Data Training sedang diproses dalam batch.');
    }

    public function destroy(Destroy $action, $id)
    {
        $action->execute($id);

        return redirect()->back()->with('success', 'Data Training berhasil dihapus dari database.');
    }
}
