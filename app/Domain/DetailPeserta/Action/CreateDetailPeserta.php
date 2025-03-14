<?php

namespace App\Domain\DetailPeserta\Action;

use App\Domain\DetailPeserta\Model\DetailPeserta;

class CreateDetailPeserta
{
  public static function handle(array $data)
  {
    return DetailPeserta::create($data);
  }
}
