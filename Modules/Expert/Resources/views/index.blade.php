@php use App\Helpers\DateHelper;use App\Helpers\PaginationHelper;use Illuminate\Support\Carbon; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('experts'))
@section('content')
    <x-ui.table.view :columns="['ID', 'name', 'college', 'speciality', 'join_date', 'Actions']"
                     :title="'experts'"
                     :paginationObject="PaginationHelper::getPaginationObject($experts)">
        <x-ui.table.body>
            @foreach($experts->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                    <td>{{ $item->speciality->college->name ?? 'N/A' }}</td>
                    <td>{{ $item->speciality->name ?? 'N/A' }}</td>
                    <td>{{ Carbon::parse($item->created_at)->format(DateHelper::defaultDateTimeFormat()) }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.toggle-status url="{{ route('experts.change_status', $item->id) }}" status="{{ $item->user->status }}"/>
{{--                        <x-ui.table.actions.delete url="{{ route('experts.destroy', $item->id) }}"/>--}}
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
