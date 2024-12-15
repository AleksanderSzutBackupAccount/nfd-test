<?php

declare(strict_types=1);

namespace Src\Company\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Shared\Infrastructure\Models\CastableModel;

/**
 * @property-read int $id
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
}
