@php use App\Helpers\ResourceHelper; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('about_us'))
@php($sections = ['one', 'two', 'three', 'four', 'five'])
@section('content')
    @if(session('success'))
        <x-ui.toast :message="session('success')"/>
    @endif
    <x-ui.breadcrumbs :pages="['about_us' => route('about_us.index'), 'edit']"/>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui("update") }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal send-form" action="{{ route('about_us.update', $item->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <x-forms.multi-lang :item="$item">
                            <div class="mb-1 col">
                                <div>
                                    <label class="col-form-label" for="title">{{ translate_ui('title') }}</label>
                                </div>
                                <div>
                                    <input type="text" id="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           placeholder="{{ translate_ui('title') }}"
                                           translate
                                    />
                                    @error('title')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <x-forms.quill-editor name="description" value="{{ $item->description }}"
                                                  :isTranslated="true"/>
                        </x-forms.multi-lang>
                        @if($item->id !== 1)
                            <div>
                                <div class="mb-3 col">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">{{ translate_ui('first_image') }}</label>
                                    </div>
                                    <div>
                                        <x-forms.image name="first_image" :item="$item" :relation="'firstImage'"/>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($item->id == 1)
                            <div class="mb-1 col-12">
                                <div class="col-3">
                                    <label class="col-form-label"
                                           for="other_images">{{ translate_ui('other_images') }}</label>
                                </div>
                                <x-ui.file-uploader.multi :images="ResourceHelper::getImagesObject($item, 'otherImages')"/>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-9 mt-2">
                        <button type="submit" class="btn btn-primary me-1">
                            {{ translate_ui('submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-forms.ajax-submit :callbackUrl="route('about_us.index')"/>
@endsection
