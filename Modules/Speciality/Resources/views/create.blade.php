@extends('layouts/layoutMaster')

@section('title', translate_ui('create'))
@section('content')
    <x-ui.breadcrumbs :pages="['colleges' => route('colleges.index'), 'specialities' => route('specialities.index', $collegeId), 'create']"/>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('create') }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal send-form" action="{{ route('specialities.store', $collegeId) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div>
                            <x-forms.multi-lang>
                                <div class="mb-3 col-12">
                                    <div>
                                        <label class="col-form-label" for="name">{{ translate_ui('name') }}</label>
                                    </div>
                                    <div>
                                        <input type="text" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               translate
                                               placeholder="{{ translate_ui('name') }}"
                                        />
                                        @error('name')
                                        <span class="alert alert-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </x-forms.multi-lang>
                        </div>
                        <div class="mb-1 col-12">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="skills">{{ translate_ui('skills') }}</label>
                            </div>
                            <div>
                                <x-forms.select name="skills" :options="$skills"/>
                                @error('skills')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-1">{{ translate_ui('submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-forms.ajax-submit :callbackUrl="route('specialities.index', $collegeId)"/>
@endsection
