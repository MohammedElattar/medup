@php use App\Helpers\DateHelper;use App\Helpers\PaginationHelper;use Illuminate\Support\Carbon; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('users'))
@section('content')
    <x-ui.table.view :columns="['ID', 'name', 'college', 'speciality', 'type', 'join_date', 'Actions']"
                     :title="'users'"
                     :paginationObject="PaginationHelper::getPaginationObject($experts)">
        <x-ui.table.body>
            @foreach($experts->items() as $item)
        @php
        $speciality = in_array($item->type, [\Modules\Auth\Enums\UserTypeEnum::STUDENT, \Modules\Auth\Enums\UserTypeEnum::TRAINEE]) ? $item->student->speciality : $item->expert->speciality;
    @endphp
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name ?? 'N/A' }}</td>
                    <td>{{ $speciality->college->name ?? 'N/A' }}</td>
                    <td>{{ $speciality->name ?? 'N/A' }}</td>
                    <td>{{ translate_ui(\Modules\Auth\Enums\UserTypeEnum::alphaTypes()[$item->type]) ?: 'N/A' }}</td>
                    <td>{{ Carbon::parse($item->created_at)->format(DateHelper::defaultDateTimeFormat()) }}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.toggle-status url="{{ route('experts.change_status', $item->id) }}" status="{{ $item->status }}"/>
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
