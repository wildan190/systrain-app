<?php

namespace App\Domain\Program\Action;

use App\Domain\Program\Model\Program;

class CreateProgram
{
    public static function handle(array $data)
    {
        return Program::create($data);
    }
}
