@extends('layouts/layoutMaster')

@section('title', translate_ui('create'))

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('create') }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ route('blogs.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div>
                            <x-forms.multi-lang>
                                <div class="mb-3 col-12">
                                    <label class="col-form-label" for="title">{{ translate_ui('title') }}</label>
                                    <input type="text" id="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           translate
                                           placeholder="{{ translate_ui('title') }}"
                                    />
                                    @error('title')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="col-form-label" for="sub_title">{{ translate_ui('sub_title') }}</label>
                                    <input type="text" id="sub_title"
                                           class="form-control @error('sub_title') is-invalid @enderror"
                                           name="sub_title"
                                           translate
                                           placeholder="{{ translate_ui('sub_title') }}"
                                    />
                                    @error('sub_title')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="col-form-label" for="content">{{ translate_ui('content') }}</label>
                                    <x-forms.textarea name="content"/>
                                </div>
                            </x-forms.multi-lang>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">{{ translate_ui('date') }}</label>
                                <x-forms.date-time-picker
                                    name="created_at"
                                    :value="old('date')"
                                    :overrideOptions="['enableTime' => false, 'dateFormat' => 'Y-m-d']"
                                />
                            </div>
                            @error('created_at')
                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="col-form-label" for="user">{{ translate_ui('user') }}</label>
                                <input type="text" id="user"
                                       class="form-control @error('user') is-invalid @enderror"
                                       name="user"
                                       value="{{old('user')}}"
                                       placeholder="{{ translate_ui('user') }}"
                                />
                                @error('user')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="col-form-label" for="tags">{{ translate_ui('tags') }}</label>
                                <x-forms.select :options="$tags" name="tags"/>
                                @error('tags')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="col-form-label" for="image">{{ translate_ui('image') }}</label>
                                <x-forms.image name="image" relation="image"/>
                                @error('image')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-1">{{ translate_ui('submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-ui.toast/>
@endsection
