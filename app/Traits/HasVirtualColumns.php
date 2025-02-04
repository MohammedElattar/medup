<?php

namespace App\Traits;

use App\Helpers\TranslationHelper;

trait HasVirtualColumns
{
    public array $virtualColumns = [];

    public function __construct(...$args)
    {
        if (isset($this->translatable)) {
            $this->virtualColumns = TranslationHelper::generateVirtualColumns($this->translatable);
        }

        return parent::__construct(... $args);
    }
}
