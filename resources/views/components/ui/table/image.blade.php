@props(['relation' => 'image', 'item' => null])

<img
        alt="{{$relation}}"
        height="50"
        width="50"
        style="object-fit: cover; border-radius: 1px"
        src="{{\App\Helpers\ResourceHelper::getFirstMediaOriginalUrl($item, $relation)}}"
/>