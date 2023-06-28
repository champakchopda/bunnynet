<?php

declare(strict_types=1);

namespace Sevenspan\Bunny\Facades;


use Illuminate\Support\Facades\Facade;

class Bunny extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Bunny';
    }
}
