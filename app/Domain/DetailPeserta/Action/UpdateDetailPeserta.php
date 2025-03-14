<?php

namespace App\Domain\DetailPeserta\Action;

use App\Domain\DetailPeserta\Model\DetailPeserta;

class UpdateDetailPeserta
{
  public static function handle(DetailPeserta $detailPeserta, array $data)
  {
    $detailPeserta->update($data);

    return $detailPeserta;
  }
}
