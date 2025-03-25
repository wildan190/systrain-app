<?php

namespace App\Domain\Program\Action;

use App\Domain\Program\Model\Program;

class GetProgram
{
    public static function handle()
    {
        return Program::all();
    }
}
