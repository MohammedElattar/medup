@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('categories'))
@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
@endsection
@section('content')
    <x-ui.table.view :columns="['ID', 'Name', 'Actions']" :title="'categories'"
                     :paginationObject="PaginationHelper::getPaginationObject($categories)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('categories.create') }}"/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($categories->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('categories.edit', $item->id) }}"/>
                        <x-ui.table.actions.delete url="{{ route('categories.destroy', $item->id) }}"/>
                    </x-ui.table.actions.view>
                </tr>
            @endforeach
        </x-ui.table.body>
    </x-ui.table.view>
    <x-ui.toast />
    <x-ui.sweetalert/>
@endsection

@push('custom-scripts')
  @vite([
    'resources/assets/js/delete-alert.js'
  ])
@endpush
