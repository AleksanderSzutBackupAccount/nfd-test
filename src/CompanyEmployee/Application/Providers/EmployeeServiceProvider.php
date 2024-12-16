<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\Providers;

use Src\CompanyEmployee\Application\UseCases\Create\CreateEmployeeCompanyCommand;
use Src\CompanyEmployee\Application\UseCases\Create\CreateEmployeeHandler;
use Src\CompanyEmployee\Application\UseCases\Delete\DeleteEmployeeCommand;
use Src\CompanyEmployee\Application\UseCases\Delete\DeleteEmployeeHandler;
use Src\CompanyEmployee\Application\UseCases\Update\UpdateEmployeeCommand;
use Src\CompanyEmployee\Application\UseCases\Update\UpdateEmployeeHandler;
use Src\CompanyEmployee\Domain\EmployeeRepositoryInterface;
use Src\CompanyEmployee\Infrastructure\Eloquent\Repositories\EmployeeEloquentRepository;
use Src\Shared\Infrastructure\Providers\BaseContextServiceProvider;

final class EmployeeServiceProvider extends BaseContextServiceProvider
{
    protected array $binds = [
        EmployeeRepositoryInterface::class => EmployeeEloquentRepository::class,
    ];

    protected array $useCases = [
        CreateEmployeeCompanyCommand::class => CreateEmployeeHandler::class,
        UpdateEmployeeCommand::class => UpdateEmployeeHandler::class,
        DeleteEmployeeCommand::class => DeleteEmployeeHandler::class,
    ];
}
