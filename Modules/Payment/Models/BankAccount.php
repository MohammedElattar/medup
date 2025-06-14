<?php

namespace Modules\Payment\Models;

use App\Helpers\MediaHelper;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Models\Builders\BankAccountBuilder;
use Modules\Payment\Traits\BankAccountRelations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BankAccount extends Model implements HasMedia
{
    use BankAccountRelations, HasFactory, InteractsWithMedia, Searchable;

    protected $fillable = [
        'account_number',
        'iban',
        'swift_code',
        'other_details',
        'bankable_type',
        'bankable_id',
        'name',
        'default',
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    public function newEloquentBuilder($query): BankAccountBuilder
    {
        return new BankAccountBuilder($query);
    }

    public function image()
    {
        return MediaHelper::mediaRelationship($this, 'bank_account_image');
    }

    public function resetImage(): void
    {
        $this->addMediaCollection('bank_account_image')->singleFile();
    }
}
