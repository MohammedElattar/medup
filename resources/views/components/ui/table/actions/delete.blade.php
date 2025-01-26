@props(['url' => '#'])
<a class="dropdown-item delete-button w-auto" href="javascript:void(0)" title="{{translate_ui('delete')}}">
    <i class="ti ti-trash"></i>
    <form action="{{$url}}" method="POST" class="delete-form d-none">
        @csrf
        @method('DELETE')
    </form>
</a>
