@php use App\Helpers\DateHelper;use App\Helpers\PaginationHelper;use Illuminate\Support\Carbon;use Illuminate\Support\Str; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('comments'))
@section('content')
    @php($type = Str::plural(request()->input('type')))
    <x-ui.breadcrumbs :pages="['previous' => url('admin/'. $type), 'comments']"/>
    <x-ui.table.view :columns="['ID', 'User', 'content', 'date', 'likes_count', 'Actions']"
                     :title="'comments'"
                     :paginationObject="PaginationHelper::getPaginationObject($comments)">
        <x-ui.table.body>
            @foreach($comments->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->content }}</td>
                    <td>{{ Carbon::parse($item->created_at)->format(DateHelper::defaultDateTimeFormat()) }}</td>
                    <td>{{ $item->favorites_count }}</td>
                    <x-ui.table.actions.view>
                        <a class="dropdown-item w-auto" href="{{route('comments.show', $item->id)}}"
                           title="{{translate_ui('show')}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <x-ui.table.actions.delete url="{{ route('comments.destroy', $item->id) }}"/>
                    </x-ui.table.actions.view>
                </tr>
            @endforeach
        </x-ui.table.body>
    </x-ui.table.view>
    <x-ui.toast/>
    <x-ui.sweetalert/>
@endsection

@push('custom-scripts')
    @vite([
      'resources/assets/js/delete-alert.js'
    ])
@endpush
