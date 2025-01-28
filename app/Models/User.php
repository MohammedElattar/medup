<?php

namespace App\Models;

use App\Models\Builders\UserBuilder;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Traits\HasVerifyTokens;
use Modules\Auth\Traits\UserRelations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens,
        HasFactory,
        HasVerifyTokens,
        InteractsWithMedia,
        Notifiable,
        PaginationTrait,
        Searchable,
        SoftDeletes,
        UserRelations;

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->name = $model->first_name . ' ' . $model->middle_name;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'email',
        'phone',
        'type',
        'status',
        'locale',
        'password',
        AuthEnum::VERIFIED_AT,
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'chat_active' => 'boolean',
            'last_time_seen' => 'datetime',
            'status' => 'boolean',
        ];
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    public function resetAvatar(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function routeNotificationForFcm(): ?string
    {
        return $this->fcm_token;
    }
}
