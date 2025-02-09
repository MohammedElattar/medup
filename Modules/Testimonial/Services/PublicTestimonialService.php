<?php

namespace Modules\Testimonial\Services;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Testimonial\Models\Testimonial;

class PublicTestimonialService
{
    public function index()
    {
        return cache()->rememberForever('testimonials', function () {
            return Testimonial::query()
                ->latest()
                ->with([
                    'user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(excludeColumns: ['phone', 'email', 'type', 'status']),
                ])
                ->paginatedCollection();
        });
    }
}
