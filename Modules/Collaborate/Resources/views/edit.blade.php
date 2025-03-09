@extends('layouts/layoutMaster')

@section('title', translate_ui('edit'))

@section('content')
    <x-ui.breadcrumbs :pages="['collaborate' => route('collaborates.index'), 'update']"/>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('collaborate') }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="#" method="POST"
                      enctype="multipart/form-data">
                    <div class="row">
                        <div>
                            <div class="mb-3 col-12">
                                <label class="col-form-label" for="title">{{ translate_ui('title') }}</label>
                                <input type="text" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       name="title"
                                       disabled
                                       placeholder="{{ translate_ui('title') }}"
                                />
                                @error('title')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-12">
                                <label class="col-form-label" for="content">{{ translate_ui('description') }}</label>
                                <x-forms.textarea
                                    name="description"
                                    :disabled="true"
                                    :value="$item->description"
                                    style="height: 25vh"
                                />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">{{ translate_ui('date') }}</label>
                                <input type="text" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       disabled
                                       value="{{$item->created_at->format(\App\Helpers\DateHelper::defaultDateTimeFormat())}}"
                                />
                            </div>
                            @error('created_at')
                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ translate_ui('college') }}</label>
                                <input type="text" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       disabled
                                       value="{{$item->speciality->college->name}}"
                                />
                            </div>
                            @error('created_at')
                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ translate_ui('speciality') }}</label>
                                <input type="text" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       disabled
                                       value="{{$item->speciality->name}}"
                                />
                            </div>
                            @error('created_at')
                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="col-form-label" for="user">{{ translate_ui('expert') }}</label>
                                <input type="text" id="user"
                                       class="form-control @error('user') is-invalid @enderror"
                                       name="user"
                                       disabled
                                       placeholder="{{ translate_ui('expert') }}"
                                       value="{{$item->expert->user->name}}"
                                />
                                @error('user')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-forms.ajax-submit :callbackUrl="route('collaborates.index')"/>
@endsection
