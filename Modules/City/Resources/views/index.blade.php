@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('cities'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Name', 'Actions']" :title="'cities'"
                     :paginationObject="PaginationHelper::getPaginationObject($cities)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('cities.create', $countryId) }}"/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($cities->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('cities.edit', ['countryId' => $countryId, 'id' => $item->id]) }}"/>
                        <x-ui.table.actions.delete url="{{ route('cities.destroy', ['countryId' => $countryId, 'id' => $item->id]) }}"/>
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
