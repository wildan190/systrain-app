<?php

namespace App\Domain\Program\Infrastructure;

use App\Domain\Program\Model\Program;
use App\Domain\Program\Presentation\Interface\ProgramRepositoryInterface;

class ProgramRepository implements ProgramRepositoryInterface
{
    public function getAll($perPage = 10, $search = null)
    {
        $query = Program::latest();

        if ($search) {
            $query->where('nama_program', 'like', "%$search%")
                ->orWhere('batch', 'like', "%$search%");
        }

        return $query->paginate($perPage);
    }

    public function findById($id)
    {
        return Program::findOrFail($id);
    }

    public function create(array $data)
    {
        return Program::create($data);
    }

    public function update($id, array $data)
    {
        $program = Program::findOrFail($id);
        $program->update($data);

        return $program;
    }

    public function delete($id)
    {
        return Program::destroy($id);
    }
}
