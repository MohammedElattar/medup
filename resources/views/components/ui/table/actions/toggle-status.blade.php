@props(['url' => '#', 'status' => false])

<a class="dropdown-item w-auto" href="{{$url}}"
   title="{{translate_ui($status ? 'deactivate' : 'activate')}}">
    <i class="fa fa-{{$status ? 'cancel' : 'check'}}"></i>
</a>
