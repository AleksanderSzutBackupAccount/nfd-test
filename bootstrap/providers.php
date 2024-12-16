<?php

use Src\Company\Application\Providers\CompanyServiceProvider;
use Src\CompanyEmployee\Application\Providers\EmployeeServiceProvider;
use Src\Shared\Application\Providers\SharedServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    SharedServiceProvider::class,
    CompanyServiceProvider::class,
    EmployeeServiceProvider::class,
];
