<?php

declare(strict_types=1);

namespace Src\Company\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Shared\Infrastructure\Models\CastableModel;

/**
 * @property-read int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 */
final class EmployeeEloquentModel extends CastableModel
{
    /** @use HasFactory<EmployeeEloquentFactory> */
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'company_id'];

    /**
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [];

    /**
     * @return BelongsTo<CompanyEloquentModel, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyEloquentModel::class);
    }

    protected static function newFactory(): EmployeeEloquentFactory
    {
        return EmployeeEloquentFactory::new();
    }
}
