<?php

declare(strict_types=1);

namespace Src\Company\Application\Providers;

use Src\Company\Application\UseCases\Create\CreateCompanyCommand;
use Src\Company\Application\UseCases\Create\CreateCompanyHandler;
use Src\Company\Application\UseCases\Delete\DeleteCompanyCommand;
use Src\Company\Application\UseCases\Delete\DeleteCompanyHandler;
use Src\Company\Application\UseCases\Update\UpdateCompanyCommand;
use Src\Company\Application\UseCases\Update\UpdateCompanyHandler;
use Src\Company\Domain\CompanyRepositoryInterface;
use Src\Company\Infrastructure\Eloquent\Repositories\CompanyEloquentRepository;
use Src\Shared\Infrastructure\Providers\BaseContextServiceProvider;

final class CompanyServiceProvider extends BaseContextServiceProvider
{
    protected array $binds = [
        CompanyRepositoryInterface::class => CompanyEloquentRepository::class,
    ];

    protected array $useCases = [
        CreateCompanyCommand::class => CreateCompanyHandler::class,
        UpdateCompanyCommand::class => UpdateCompanyHandler::class,
        DeleteCompanyCommand::class => DeleteCompanyHandler::class,
    ];
}
