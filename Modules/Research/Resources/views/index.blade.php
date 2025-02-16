@php use App\Helpers\PaginationHelper;use Illuminate\Support\Carbon; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('researches'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Title', 'contributors', 'skills', 'notes', 'date', 'Actions']" :title="'researches'"
                     :paginationObject="PaginationHelper::getPaginationObject($researches)">
        <x-ui.table.body>
            @foreach($researches->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->contributors }}</td>
                    <td>{{ $item->skills }}</td>
                    <td>{{ $item->notes }}</td>
                    <td>{{ Carbon::parse($item->created_at)->format(\App\Helpers\DateHelper::defaultDateFormat()) }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.info url="{{ \App\Helpers\ResourceHelper::getFirstMediaOriginalUrl($item, 'file') }}" :title="translate_ui('pdf')" icon="file" target="_blank"/>
                        <x-ui.table.actions.delete url="{{ route('researches.delete', $item->id) }}"/>
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
