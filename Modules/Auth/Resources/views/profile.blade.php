@extends('layouts/layoutMaster')

@section('title', 'Account settings - Account')
@section('page-script')
  @vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="nav-align-top">
        <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
          <li class="nav-item"><a class="nav-link active" href="{{route('profile.show')}}"><i class="ti-sm ti ti-users me-1_5"></i>{{translate_ui('account_details')}}</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('change-password-view')}}"><i class="ti-sm ti ti-lock me-1_5"></i>{{translate_ui('security')}}</a></li>
        </ul>
      </div>
      <div class="card mb-6">
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-6">
            <img src="{{ \App\Helpers\ResourceHelper::getFirstMediaOriginalUrl($user, defaultImageName: 'user.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
            <div class="button-wrapper">
              <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                <span class="d-none d-sm-block">{{translate_ui('upload')}}</span>
                <i class="ti ti-upload d-block d-sm-none"></i>
              </label>
              <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                <span class="d-none d-sm-block">{{translate_ui('reset')}}</span>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body pt-4">
          <form id="formAccountSettings" method="POST" action="{{route('admin.update-profile')}}" enctype="multipart/form-data">
            @csrf
            <input name="avatar" type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
            <div class="row">
              <div class="mb-4 col-md-6">
                <label for="name" class="form-label">{{translate_ui('name')}}</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" />
                @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="mb-4 col-md-6">
                <label for="email" class="form-label">{{translate_ui('email')}}</label>
                <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" name="email" value="{{ old('email', $user->email) }}" />
                @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="mb-4 col-md-12">
                <label class="form-label" for="phone">{{translate_ui('phone')}}</label>
                <div class="input-group input-group-merge">
                  <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="202 555 0111" value="{{ old('phone', $user->phone) }}" />
                  @error('phone')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-3">{{translate_ui('submit')}}</button>
              <button type="reset" class="btn btn-label-secondary">{{translate_ui('cancel')}}</button>
            </div>
          </form>
        </div>
        <!-- /Account -->
      </div>
    </div>
  </div>
  <x-ui.toast />
@endsection
