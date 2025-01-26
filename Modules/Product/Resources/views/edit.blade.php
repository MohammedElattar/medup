@php use Modules\Auth\Enums\UserTypeEnum; @endphp
@extends('layouts/layoutMaster')

@section('title', translate_ui('update'))

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('update') }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal send-form" action="{{ route('products.update', $item->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div>
                            <x-forms.multi-lang :item="$item">
                                <div class="mb-1 col">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="name">{{ translate_ui('name') }}</label>
                                    </div>
                                    <div>
                                        <input type="text" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               placeholder="{{ translate_ui('name') }}"
                                               translate
                                        />
                                        @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-1 col">
                                    <div class="col-sm-3">
                                        <label class="col-form-label"
                                               for="description">{{ translate_ui('description') }}</label>
                                    </div>
                                    <div>
                                    <textarea type="text" id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              placeholder="{{ translate_ui('description') }}"
                                              translate
                                    ></textarea>
                                        @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </x-forms.multi-lang>
                        </div>
                        <div class="mb-1 col-sm-12">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="quantity">{{ translate_ui('quantity') }}</label>
                            </div>
                            <div>
                                <input type="number" id="quantity"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       name="quantity"
                                       value="{{old('quantity', $item->quantity)}}"
                                       placeholder="{{ translate_ui('quantity') }}"
                                />
                                @error('quantity')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-1 col-sm-12">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="price">{{ translate_ui('price') }}</label>
                            </div>
                            <div>
                                <input type="number" id="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       name="price"
                                       value="{{old('price', $item->price)}}"
                                       placeholder="{{ translate_ui('price') }}"
                                />
                                @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-1 col-12">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="category_id">{{ translate_ui('category') }}</label>
                            </div>
                            <div>
                                <x-forms.select name="category_id" :options="$categories" :multiple="false" :item="$item" :relationName="'category'"/>
                                @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if(UserTypeEnum::getUserType() != UserTypeEnum::INVENTORY_OWNER)
                            <div class="mb-1 col-12">
                                <div class="col-sm-3">
                                    <label class="col-form-label"
                                           for="inventory_owner_id">{{ translate_ui('inventory_owner') }}</label>
                                </div>
                                <div>
                                    <x-forms.select name="inventory_owner_id" :options="$inventoryOwners" :multiple="false" :item="$item" :relationName="'inventoryOwner'"/>
                                    @error('inventory_owner_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="mb-3 col">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="main_image">{{translate_ui('image')}}</label>
                                </div>
                                <x-forms.image :name="'image'" :relation="'image'" :item="$item"/>
                                @error('image')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
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
    <x-ui.toast/>
@endsection
