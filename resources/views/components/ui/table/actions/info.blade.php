@props(['url' => '#', 'icon' => 'alert-circle', 'title' => translate_ui('info')])
<a class="dropdown-item w-auto" href="{{$url}}" title="{{$title}}">
    <i class="ti ti-{{$icon}}"></i>
</a>
