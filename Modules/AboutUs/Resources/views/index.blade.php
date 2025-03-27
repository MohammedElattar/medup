@extends('layouts/layoutMaster')

@section('title', translate_ui('about_us'))
@section('content')
    <x-ui.table.view :columns="['ID', 'Title', 'Description', 'Actions']" :title="'about_us'" :paginated="false">
        <x-ui.table.body>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{!! $item->description !!}</td>
                    <x-ui.table.actions.view>
                        <x-ui.table.actions.edit url="{{ route('about_us.show', $item->id) }}"/>
                    </x-ui.table.actions.view>
                </tr>
            @endforeach
        </x-ui.table.body>
    </x-ui.table.view>

    <x-ui.sweetalert/>
@endsection
