@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui($title))
@section('content')
    <x-ui.table.view :columns="['ID', 'Name', 'Email', 'Phone', 'Balance', 'Actions']" :title="$title"
                     :paginationObject="PaginationHelper::getPaginationObject($data)">
        <x-ui.table.buttons>
            <x-ui.buttons.add url='{{ route("$route.create") }}'/>
        </x-ui.table.buttons>

        <x-ui.table.body>
            @foreach($data->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->user->phone }}</td>
                    <td>{{ number_format($item->user->wallet_sum_balance, 2) }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.info :icon="'dollar-sign'" url="{!! route('transactions.index', ['id' => $item->id, 'user_id' => $item->user->id]) !!}"/>
                        <x-ui.table.actions.edit url='{{ route("$route.edit", $item->id) }}'/>
                        <x-ui.table.actions.delete url='{{ route("$route.destroy", $item->id) }}'/>
                    </x-ui.table.actions.view>
                </tr>
            @endforeach
        </x-ui.table.body>
    </x-ui.table.view>

    <x-ui.sweetalert/>
    <x-ui.toast />
@endsection

@push('custom-scripts')
  @vite([
    'resources/assets/js/delete-alert.js'
  ])
@endpush
