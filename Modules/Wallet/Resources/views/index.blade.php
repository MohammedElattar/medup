@php use App\Helpers\DateHelper;use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('transactions'))
@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
@endsection
@section('content')
    <x-ui.table.view :columns="['id', 'from user', 'target user', 'amount', 'from vendor', 'created_at', 'actions']" :title="'transactions'"
                     :paginationObject="PaginationHelper::getPaginationObject($transactions)">
        <x-ui.table.body>
            @foreach($transactions->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->id ==  $item->order->product->inventoryOwner->user_id ? $item->order->name : $item->order->product->inventoryOwner->user->name }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ number_format($item->amount) }}</td>
                    <td>
                        {{ $item->user->id ==  $item->order->product->inventoryOwner->user_id ? 'yes' : 'no' }}
                    </td>
                    <td>{{ $item->created_at->format(DateHelper::defaultDateTimeFormat()) }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.info url="{{ route('transactions.show', $item->id) }}"/>
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
