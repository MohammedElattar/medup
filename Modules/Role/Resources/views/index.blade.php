@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('roles'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Name', 'Actions']" :title="'roles'"
                     :paginationObject="PaginationHelper::getPaginationObject($roles)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('roles.create') }}"/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($roles->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('roles.edit', $item->id) }}"/>
                        <x-ui.table.actions.delete url="{{ route('roles.destroy', $item->id) }}"/>
                    </x-ui.table.actions.view>
                </tr>
            @endforeach
        </x-ui.table.body>
    </x-ui.table.view>

    <x-ui.sweetalert/>
@endsection

@push('custom-scripts')
  @vite([
    'resources/assets/js/delete-alert.js'
  ])
@endpush
