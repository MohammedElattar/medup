@php use App\Helpers\PaginationHelper; use App\Helpers\ResourceHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('products'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Name', 'quantity', 'price', 'Category', 'Inventory Owner', 'Image', 'Actions']" :title="'products'"
                     :paginationObject="PaginationHelper::getPaginationObject($products)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url="{{ route('products.create') }}"/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($products->items() as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->inventoryOwner->user->name }}</td>
                    <td>
                        <x-ui.table.image :item="$item" relation="image"/>
                    </td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('products.edit', $item->id) }}"/>
                        <x-ui.table.actions.delete url="{{ route('products.destroy', $item->id) }}"/>
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
