@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('colleges'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Name', 'description', 'icon', 'Actions']" :title="'colleges'"
                     :paginationObject="PaginationHelper::getPaginationObject($colleges)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('colleges.create') }}"/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($colleges->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <x-ui.table.image :item="$item" relation="icon"/>
                    </td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.info url="{{ route('specialities.index', $item->id) }}" :title="translate_ui('specialities')"/>
                        <x-ui.table.actions.edit url="{{ route('colleges.edit', $item->id) }}"/>
                        <x-ui.table.actions.delete url="{{ route('colleges.destroy', $item->id) }}"/>
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
