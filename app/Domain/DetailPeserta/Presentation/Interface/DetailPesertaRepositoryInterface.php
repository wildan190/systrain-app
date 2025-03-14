<?php

namespace App\Domain\DetailPeserta\Presentation\Interface;

interface DetailPesertaRepositoryInterface
{
    public function getAll();

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
