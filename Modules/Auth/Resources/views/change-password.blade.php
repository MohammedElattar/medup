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
          <li class="nav-item"><a class="nav-link" href="{{route('profile.show')}}"><i class="ti-sm ti ti-users me-1_5"></i>{{translate_ui('account_details')}}</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{route('change-password-view')}}"><i class="ti-sm ti ti-lock me-1_5"></i>{{translate_ui('security')}}</a></li>
        </ul>
      </div>
    </div>
    <div class="card mb-6">
      <h5 class="card-header">{{translate_ui('change_password')}}</h5>
      <div class="card-body pt-1">
        <form id="formAccountSettings" method="POST" action="{{route('admin.update-password')}}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="mb-6 col-md-6 form-password-toggle">
              <label class="form-label" for="currentPassword">{{translate_ui('current_password')}}</label>
              <div class="input-group input-group-merge">
                <input class="form-control @error('old_password') is-invalid @enderror"
                       type="password"
                       name="old_password"
                       id="currentPassword"
                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                @error('old_password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-6 col-md-6 form-password-toggle">
              <label class="form-label" for="newPassword">{{translate_ui('new_password')}}</label>
              <div class="input-group input-group-merge">
                <input class="form-control @error('new_password') is-invalid @enderror"
                       type="password"
                       id="newPassword"
                       name="new_password"
                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                @error('new_password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            <div class="mb-6 col-md-6 form-password-toggle">
              <label class="form-label" for="confirmPassword">{{translate_ui('new_password_confirmation')}}</label>
              <div class="input-group input-group-merge">
                <input class="form-control @error('new_password_confirmation') is-invalid @enderror"
                       type="password"
                       name="new_password_confirmation"
                       id="confirmPassword"
                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                @error('new_password_confirmation')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="mt-6">
            <button type="submit" class="btn btn-primary me-3">{{translate_ui('submit')}}</button>
            <button type="reset" class="btn btn-label-secondary">{{translate_ui('reset')}}</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <x-ui.toast />
@endsection
