<?php

namespace App\Helpers;

use App\Models\User;
use Cerbero\JsonParser\JsonParser;
use Closure;
use Modules\Country\Models\Country;

class JsonParserHelper
{
    private JsonParser $jsonParser;
    private int $chunkSize = 100;

    public function __construct(string $source)
    {
        $this->jsonParser = JsonParser::parse($source);
    }

    public static function parse(string $source)
    {
        return new self($source);
    }


    public function seedChunks(string $model, Closure $preparePayload, bool $shouldMerge = false, int|null $size = null)
    {
        $this->setChunkSize($size);
        $chunk = [];
        $counter = 0;

        $this->jsonParser->traverse(function($item, $key) use (&$counter, &$chunk, $preparePayload, $model, $shouldMerge){
            if($counter > 0 && $counter % $this->chunkSize === 0) {
                $model::query()->insert($chunk);
                $chunk = [];
            }

            $counter++;

            if($shouldMerge) {
                $chunk = array_merge($chunk, $preparePayload($item, $key));
            } else {
                $chunk[] = $preparePayload($item, $key);
            }
        });
    }

    public function setChunkSize(int|null $size)
    {
        if(! is_null($size)) {
            $this->chunkSize = $size;
        }

        return $this;
    }
}
