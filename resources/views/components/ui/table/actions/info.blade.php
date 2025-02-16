@props(['url' => '#', 'icon' => 'alert-circle', 'title' => translate_ui('info'), 'target' => ''])
<a class="dropdown-item w-auto" href="{{$url}}" title="{{$title}}" target="{{$target}}">
    <i class="ti ti-{{$icon}}"></i>
</a>
