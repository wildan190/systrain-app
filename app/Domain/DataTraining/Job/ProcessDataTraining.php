<?php

namespace App\Domain\DataTraining\Job;

use App\Domain\DataTraining\Action\CreateOrUpdate;
use App\Domain\DetailPeserta\Model\DetailPeserta;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDataTraining implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $detailPesertaId;

    public $data;

    public $request;

    // Constructor untuk menerima data yang diperlukan
    public function __construct($detailPesertaId, array $data, $request)
    {
        $this->detailPesertaId = $detailPesertaId;
        $this->data = $data;
        $this->request = $request;
    }

    public function handle(CreateOrUpdate $action)
    {
        try {
            // Mengambil data peserta berdasarkan ID
            $detailPeserta = DetailPeserta::findOrFail($this->detailPesertaId);

            // Memproses data menggunakan action CreateOrUpdate
            $action->execute($this->request, $this->detailPesertaId);

            // Menambahkan log jika berhasil
            Log::info('Data Training berhasil diproses untuk peserta ID '.$this->detailPesertaId);
        } catch (\Exception $e) {
            // Menambahkan log jika terjadi kesalahan
            Log::error('Terjadi kesalahan saat memproses Data DataTraining: '.$e->getMessage());
        }
    }
}
