<?php

namespace App\Domain\DetailPeserta\Action;

use App\Domain\DetailPeserta\Model\DetailPeserta;

class DestroyDetailPeserta
{
  public static function handle(DetailPeserta $detailPeserta)
  {
    return $detailPeserta->delete();
  }
}
