@extends('layouts/layoutMaster')

@section('title', translate_ui('update'))
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('update') }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ route("$route.update", $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach(['name', 'email', 'phone'] as $column)
                            <div class="mb-2 col-md-6">
                                <div>
                                    <label class="col-form-label" for="{{$column}}">{{ translate_ui($column) }}</label>
                                </div>
                                <div>
                                    <input type="{{$column}}" id="{{$column}}" class="form-control @error($column) is-invalid @enderror" name="{{$column}}" value="{{old($column, $item->user->{$column})}}" placeholder="{{ translate_ui($column) }}" />
                                    @error($column)
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="mb-2 col-md-6 mt-1">
                            <div>
                                <label class="form-label" for="password">{{ translate_ui('password') }}</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name='password' aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-1">{{ translate_ui('submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-ui.toast />
@endsection
