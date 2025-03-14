<?php

namespace App\Domain\DetailPeserta\Action;

use App\Domain\DetailPeserta\Model\DetailPeserta;

class GetDetailPeserta
{
    public static function handle()
    {
        return DetailPeserta::with('category')->get();
    }
}
