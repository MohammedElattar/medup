@extends('layouts/layoutMaster')

@section('title', translate_ui('update'))
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{translate_ui('update')}}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 mb-1">
                            <div>
                                <div class="mb-1 col">
                                    <div>
                                        <label class="col-form-label" for="name">{{ translate_ui('name') }}</label>
                                    </div>
                                    <div>
                                        <input type="text" id="name"
                                               class="form-control  @error('name') is-invalid @enderror"
                                               name="name"
                                               placeholder="{{ translate_ui('name') }}"
                                               value="{{old('name', $role->name)}}"
                                        />
                                        @error('name')
                                        <span class="alert alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <x-role::permissions :permissions="$permissions" :defaultPermissions="$role->permissions"/>
                        </div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-1">{{ translate_ui('submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
