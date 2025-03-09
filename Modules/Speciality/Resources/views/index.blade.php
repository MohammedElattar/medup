@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('specialities'))
@section('content')
    <x-ui.breadcrumbs :pages="['colleges' => route('colleges.index'), 'specialities']"/>
    <x-ui.table.view :columns="['ID', 'Name', 'Actions']" :title="'specialities'"
                     :paginationObject="PaginationHelper::getPaginationObject($specialities)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('specialities.create', $collegeId) }}"/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($specialities->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('specialities.edit', ['collegeId' => $collegeId, 'id' => $item->id]) }}"/>
                        <x-ui.table.actions.delete url="{{ route('specialities.destroy', ['collegeId' => $collegeId, 'id' => $item->id]) }}"/>
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
