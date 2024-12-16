<?php

declare(strict_types=1);


namespace Src\Company\Domain\Exceptions;

 use Src\Company\Domain\ValueObjects\CompanyId;
 use Src\Shared\Domain\Exceptions\DomainError;

 final class CompanyNotFound extends DomainError {

     public function __construct(private readonly CompanyId $id)
     {
         parent::__construct();
     }

     public function errorCode(): string
     {
         return 'company_not_found';
     }

     protected function errorMessage(): string
     {
         return sprintf('The company <%s> has not been found', $this->id->value());
     }
 }
