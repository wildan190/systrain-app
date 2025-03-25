<?php

namespace App\Domain\Program\Action;

use App\Domain\Program\Model\Program;

class UpdateProgram
{
    public static function handle(Program $program, array $data)
    {
        $program->update($data);

        return $program;
    }
}
