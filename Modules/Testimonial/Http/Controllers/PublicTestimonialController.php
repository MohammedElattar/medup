<?php

namespace Modules\Testimonial\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Testimonial\Services\PublicTestimonialService;
use Modules\Testimonial\Transformers\TestimonialResource;

class PublicTestimonialController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicTestimonialService $publicTestimonialService)
    {
    }

    public function index()
    {
        $testimonials = $this->publicTestimonialService->index();

        return $this->paginatedResponse($testimonials, TestimonialResource::class);
    }
}
