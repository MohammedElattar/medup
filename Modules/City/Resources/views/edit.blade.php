@extends('layouts/layoutMaster')

@section('title', translate_ui('edit'))
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('edit') }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ route('cities.update', ['countryId' => $countryId, 'id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div>
                            <x-forms.multi-lang :item="$item">
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

                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary me-1">{{ translate_ui('update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-ui.toast />
@endsection
