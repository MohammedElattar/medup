@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('ads'))
@section('content')
<x-ui.table.view :columns="['ID','Image', 'Actions']" :title="'ads'"
    :paginationObject="PaginationHelper::getPaginationObject($ads)">
    <x-ui.table.buttons>
        <x-ui.buttons.add url="{{ route('ads.create') }}" permission="store-ad"/>
    </x-ui.table.buttons>
    <x-ui.table.body>
        @foreach($ads->items() as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                <x-ui.table.image :item="$item" relation="image"/>
            </td>
            <x-ui.table.actions.view>
                <x-ui.table.actions.edit url="{{ route('ads.edit', $item->id) }}" permission="update-ad"/>
                <x-ui.table.actions.delete url="{{ route('ads.destroy', $item->id) }}" permission="delete-ad"/>
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
