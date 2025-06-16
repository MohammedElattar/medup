@extends('layouts/layoutMaster')

@section('title', translate_ui('edit'))

@section('content')
<x-ui.breadcrumbs :pages="['tags' => route('tags.index'), 'edit']"/>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ translate_ui('edit') }}</h4>
        </div>

        <div class="card-body">
            <form class="form form-horizontal send-form" action="{{ route('settings.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs nav-fill mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#email" role="tab">
                            <i class="tf-icons ti ti-mail me-1"></i> {{ translate_ui('email_settings') }}
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#stripe" role="tab">
                            <i class="tf-icons ti ti-credit-card me-1"></i> {{ translate_ui('stripe_settings') }}
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Email Tab -->
                    <div class="tab-pane fade show active" id="email" role="tabpanel">
                        <div class="row">
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">{{ translate_ui('mail_from') }}</label>
                                <input type="text" name="mail_from" class="form-control" value="{{ old('mail_from', $item->mail_from) }}">
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label">{{ translate_ui('mail_username') }}</label>
                                <input type="text" name="mail_username" class="form-control" value="{{ old('mail_username', $item->mail_username) }}">
                            </div>

                            <div class="mb-3 form-password-toggle col-lg-6">
                                <label class="form-label" for="mail_password">{{ translate_ui('mail_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        class="form-control form-control-merge"
                                        id="mail_password"
                                        name="mail_password"
                                        placeholder="••••••••••••"
                                        aria-describedby="mail_password"
                                        value="{{ old('mail_password', $item->mail_password) }}"
                                    />
                                    <span class="input-group-text cursor-pointer">
                                        <i class="ti ti-eye-off"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3 col-lg-6">
                                <label class="form-label">{{ translate_ui('mail_host') }}</label>
                                <input type="text" name="mail_host" class="form-control" value="{{ old('mail_host', $item->mail_host) }}">
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label class="form-label">{{ translate_ui('mail_port') }}</label>
                                <input type="text" name="mail_port" class="form-control" value="{{ old('mail_port', $item->mail_port) }}">
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label class="form-label">{{ translate_ui('mail_encryption') }}</label>
                                <input type="text" name="mail_encryption" class="form-control" value="{{ old('mail_encryption', $item->mail_encryption) }}">
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label class="form-label">{{ translate_ui('mail_protocol') }}</label>
                                <input type="text" name="mail_protocol" class="form-control" value="{{ old('mail_protocol', $item->mail_protocol) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Stripe Tab -->
                    <div class="tab-pane fade" id="stripe" role="tabpanel">
                        <div class="row">
                            <div class="mb-3 form-password-toggle col-md-12">
                                <label class="form-label" for="stripe_secret_key">{{ translate_ui('stripe_secret_key') }}</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        class="form-control form-control-merge"
                                        id="stripe_secret_key"
                                        name="stripe_secret_key"
                                        placeholder="••••••••••••"
                                        aria-describedby="stripe_secret_key"
                                        value="{{ old('stripe_secret_key', $item->secret_key) }}"
                                    />
                                    <span class="input-group-text cursor-pointer">
                                        <i class="ti ti-eye-off"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">{{ translate_ui('save_changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

