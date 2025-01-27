@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('skills'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Name', 'icon', 'Actions']" :title="'skills'"
                     :paginationObject="PaginationHelper::getPaginationObject($skills)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('skills.create') }}"/>
        </x-ui.table.buttons>
        <x-ui.table.body>
            @foreach($skills->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <x-ui.table.image :item="$item" relation="icon"/>
                    </td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('skills.edit', $item->id) }}"/>
                        <x-ui.table.actions.delete url="{{ route('skills.destroy', $item->id) }}"/>
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

