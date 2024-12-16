<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Infrastructure\Eloquent\Models\CompanyEloquentModel;
use Src\CompanyEmployee\Domain\Employee;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeEmail;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeFirstName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeLastName;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeePhone;
use Src\CompanyEmployee\Infrastructure\Eloquent\Factories\EmployeeEloquentFactory;
use Src\Shared\Infrastructure\Models\CastableModel;

/**
 * @property-read string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property ?string $phone
 * @property string $company_id
 */
final class EmployeeEloquentModel extends CastableModel
{
    /** @use HasFactory<EmployeeEloquentFactory> */
    use HasFactory;

    use HasUuids;

    protected $table = 'employees';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'company_id'];

    /**
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [];

    protected static function newFactory(): EmployeeEloquentFactory
    {
        return EmployeeEloquentFactory::new();
    }

    /**
     * @return BelongsTo<CompanyEloquentModel, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyEloquentModel::class, 'company_id');
    }

    public function toEntity(): Employee
    {
        return new Employee(
            new EmployeeId($this->id),
            new EmployeeFirstName($this->first_name),
            new EmployeeLastName($this->last_name),
            new EmployeeEmail($this->email),
            EmployeePhone::fromNullable($this->phone),
            new CompanyId($this->company_id)
        );
    }
}
