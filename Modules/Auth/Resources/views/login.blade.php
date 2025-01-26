@php
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
  ])
@endsection

@section('page-style')
  @vite([
    'resources/assets/vendor/scss/pages/page-auth.scss'
  ])
@endsection

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-6">
        <!-- Login -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-6">
              <a href="{{url('/')}}" class="app-brand-link">
                <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
                <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
              </a>
            </div>
            <!-- /Logo -->


            @if ($errors->any())
              <div class="alert alert-danger text-center">
                <ul>
                  @foreach ($errors->all() as $error)
                    {{ $error }}
                  @endforeach
                </ul>
              </div>
            @endif

            <form id="formAuthentication" class="mb-4" action="{{route('dashboard-login')}}" method="POST">
              @csrf
              <div class="mb-6">
                <label for="login-email" class="form-label">{{translate_ui('email')}}</label>
                <input
                  type="text"
                  class="form-control"
                  id="login-email"
                  name="email"
                  placeholder="john@example.com"
                  aria-describedby="login-email"
                  tabindex="1"
                  autofocus
                  value="{{old('email')}}"
                />
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="login-password">{{translate_ui('password')}}</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    class="form-control form-control-merge"
                    id="login-password"
                    name="password"
                    tabindex="2"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="login-password"
                    value="{{old('password')}}"
                  />
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
              </div>
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit">{{translate_ui('login')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
