<?php

namespace Modules\Testimonial\Models;

use App\Models\User;
use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use PaginationTrait;

    protected $fillable = ['user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
