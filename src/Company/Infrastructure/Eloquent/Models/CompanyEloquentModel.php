<?php

declare(strict_types=1);

namespace Src\Company\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Company\Domain\Company;
use Src\Company\Domain\CompanyFullAddress;
use Src\Company\Domain\ValueObjects\CompanyAddress;
use Src\Company\Domain\ValueObjects\CompanyCity;
use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Company\Domain\ValueObjects\CompanyName;
use Src\Company\Domain\ValueObjects\CompanyNip;
use Src\Company\Domain\ValueObjects\CompanyPostalCode;
use Src\Company\Infrastructure\Eloquent\Factories\CompanyEloquentFactory;
use Src\Shared\Domain\Exceptions\InvalidValueObjectException;
use Src\Shared\Infrastructure\Models\CastableModel;

/**
 * @property-read string $id
 * @property string $name
 * @property string $nip
 * @property string $address
 * @property string $city
 * @property string $postal_code
 */
final class CompanyEloquentModel extends CastableModel
{
    /** @use HasFactory<CompanyEloquentFactory> */
    use HasFactory;
    use HasUuids;

    protected $table = 'companies';

    protected $fillable = ['name', 'nip', 'address', 'city', 'postal_code'];

    /**
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [];

    protected static function newFactory(): CompanyEloquentFactory
    {
        return CompanyEloquentFactory::new();
    }

    /**
     * @throws InvalidValueObjectException
     */
    public function toEntity(): Company
    {
        return new Company(
            new CompanyId($this->id),
            new CompanyName($this->name),
            new CompanyNip($this->nip),
            new CompanyFullAddress(new CompanyCity($this->city),new CompanyPostalCode($this->postal_code),new CompanyAddress($this->address))
        );
    }
}
