<?php

namespace App\Domain\Program\Action;

use App\Domain\Program\Model\Program;

class DestroyProgram
{
    public static function handle(Program $program)
    {
        return $program->delete();
    }
}
