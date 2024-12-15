<?php

use Src\Company\Application\Providers\CompanyServiceProvider;
use Src\Shared\Application\Providers\SharedServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    SharedServiceProvider::class,
    CompanyServiceProvider::class
];
