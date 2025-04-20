
@php use App\Helpers\PaginationHelper;use Illuminate\Support\Carbon; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('library'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Title', 'description', 'speciality', 'college', 'price', 'pages_count', 'cover', 'Actions']" :title="'library'"

                     :paginationObject="PaginationHelper::getPaginationObject($library)">
        {{-- <x-ui.table.buttons> --}}
        {{--     <x-ui.buttons.add url="{{ route('library.create') }}"/> --}}
        {{-- </x-ui.table.buttons> --}}

        <x-ui.table.body>
            @foreach($library->items() as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->speciality->name }}</td>
                    <td>{{ $item->speciality->college->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->pages_count }}</td>
                    <td>
                        <x-ui.table.image :item="$item" relation="cover"/>
                    </td>
                    <x-ui.table.actions.view>
                        {{-- <x-ui.table.actions.edit url="{{ route('library.edit', $item->id) }}"/> --}}
                        <x-ui.table.actions.delete url="{{ route('library.destroy', $item->id) }}"/>
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
