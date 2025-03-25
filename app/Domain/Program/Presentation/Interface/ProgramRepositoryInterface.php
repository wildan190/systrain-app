<?php

namespace App\Domain\Program\Presentation\Interface;

interface ProgramRepositoryInterface
{
    public function getAll($perPage, $search);

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
