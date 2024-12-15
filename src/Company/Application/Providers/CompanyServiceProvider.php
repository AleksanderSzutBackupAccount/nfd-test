<?php

declare(strict_types=1);

namespace Src\Company\Application\Providers;

use Src\Company\Application\Create\CreateCompanyCommand;
use Src\Company\Application\Create\CreateCompanyHandler;
use Src\Company\Application\Update\UpdateCompanyCommand;
use Src\Company\Application\Update\UpdateCompanyHandler;
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
    ];
}
