@php use App\Helpers\PaginationHelper;use Illuminate\Support\Carbon; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('blogs'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Title', 'sub_title', 'content', 'date', 'image', 'Actions']" :title="'blogs'"
                     :paginationObject="PaginationHelper::getPaginationObject($blogs)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('blogs.create') }}"/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($blogs->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->sub_title }}</td>
                    <td>{{ $item->content }}</td>
                    <td>{{ Carbon::parse($item->created_at)->format(\App\Helpers\DateHelper::defaultDateFormat()) }}</td>
                    <td>
                        <x-ui.table.image :item="$item" relation="image"/>
                    </td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('blogs.edit', $item->id) }}"/>
                        <x-ui.table.actions.delete url="{{ route('blogs.destroy', $item->id) }}"/>
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
