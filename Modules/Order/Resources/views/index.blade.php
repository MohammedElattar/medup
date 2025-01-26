@php use App\Helpers\DateHelper;use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('orders'))
@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
@endsection
@section('content')
    <x-ui.table.view :columns="['ID', 'product name', 'inventory owner', 'Vendor Name', 'email', 'phone', 'quantity', 'price', 'total', 'created_at']" :title="'orders'"
                     :paginationObject="PaginationHelper::getPaginationObject($orders)">
        <x-ui.table.body>
            @foreach($orders->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->inventoryOwner->user->name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ number_format($item->quantity) }}</td>
                    <td>{{ number_format($item->new_price) }}</td>
                    <td>{{ number_format($item->new_price * $item->quantity) }}</td>
                    <td>{{ $item->created_at->format(DateHelper::defaultDateTimeFormat()) }}</td>
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
