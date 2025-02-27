@php use App\Helpers\DateHelper;use App\Helpers\PaginationHelper;use Illuminate\Support\Carbon; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('ideas'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Title', 'college', 'speciality', 'expert', 'comments_count', 'date', 'Actions']"
                     :title="'ideas'"
                     :paginationObject="PaginationHelper::getPaginationObject($ideas)">
        <x-ui.table.body>
            @foreach($ideas->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->speciality->college->name ?? 'N/A' }}</td>
                    <td>{{ $item->speciality->name ?? 'N/A' }}</td>
                    <td>{{ $item->expert->user->name ?? 'N/A' }}</td>
                    <td>{{ number_format($item->comments_count)}}</td>
                    <td>{{ Carbon::parse($item->created_at)->format(DateHelper::defaultDateTimeFormat()) }}</td>
                    <x-ui.table.actions.view>
                        <a class="dropdown-item w-auto" href="{{route('comments.index', ['type' => 'collaborate', 'commentable_id' => $item->id])}}"
                           title="{{translate_ui('comments')}}">
                            <i class="fa fa-comments"></i>
                        </a>
                        <a class="dropdown-item w-auto" href="{{route('ideas.change_status', $item->id)}}"
                           title="{{translate_ui($item->status ? 'deactivate' : 'activate')}}">
                            <i class="fa fa-{{$item->status ? 'cancel' : 'check'}}"></i>
                        </a>
                        <a class="dropdown-item w-auto" href="{{route('ideas.edit', $item->id)}}"
                           title="{{translate_ui('show')}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <x-ui.table.actions.delete url="{{ route('ideas.destroy', $item->id) }}"/>
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
