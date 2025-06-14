@extends('layouts/layoutMaster')

@section('title', translate_ui('create'))

@section('content')
    <x-ui.breadcrumbs :pages="['ads' => route('ads.index'), 'create']"/>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('create') }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal send-form" action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div>
                            <div class="mb-3 col">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="image">{{ translate_ui('image') }}</label>
                                </div>
                                <div>
                                    <x-forms.image name="image"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ translate_ui('submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-forms.ajax-submit :callbackUrl="route('ads.index')"/>
@endsection
