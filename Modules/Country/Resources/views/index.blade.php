@php use App\Helpers\PaginationHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('countries'))
@section('content')
  <x-ui.table.view :columns="['ID', 'Name', 'Actions']" :title="'countries'"
                   :paginationObject="PaginationHelper::getPaginationObject($countries)">
    <x-ui.table.buttons>
      <x-ui.buttons.add url="{{ route('countries.create') }}"/>
    </x-ui.table.buttons>

    <x-ui.table.body>
      @foreach($countries->items() as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <x-ui.table.actions.view>
            <x-ui.table.actions.info url="{{ route('cities.index', $item->id) }}" :title="translate_ui('cities')"/>
            <x-ui.table.actions.edit url="{{ route('countries.edit', $item->id) }}"/>
            <x-ui.table.actions.delete url="{{ route('countries.destroy', $item->id) }}"/>
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
