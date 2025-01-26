@extends('layouts/layoutMaster')
@section('title', translate_ui('order_details'))
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('vendor_info') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(['name', 'email', 'phone'] as $field)
                        <div class="mb-1 col-md-6">
                            <div>
                                <label class="col-form-label" for="{{$field}}">{{ translate_ui($field) }}</label>
                            </div>
                            <div>
                                <input type="text"
                                       id="{{$field}}"
                                       class="form-control"
                                       name="{{$field}}"
                                       placeholder="{{ translate_ui($field) }}"
                                       value="{{ $transaction->order->{$field} }}"
                                       disabled
                                />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('transaction') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('from_user') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   placeholder="{{ translate_ui('from_user') }}"
                                   value="{{ $transaction->user->id ==  $transaction->order->product->inventoryOwner->user_id ? $transaction->order->name : $transaction->order->product->inventoryOwner->user->name  }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('to_user') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   placeholder="{{ translate_ui('to_user') }}"
                                   value="{{ $transaction->user->name }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('amount') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   placeholder="{{ translate_ui('amount') }}"
                                   value="{{ $transaction->amount }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('created_at') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   placeholder="{{ translate_ui('created_at') }}"
                                   value="{{ $transaction->created_at->format(\App\Helpers\DateHelper::defaultDateTimeFormat()) }}"
                                   disabled
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('product_details') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('name') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $transaction->order->product->name  }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('quantity') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   value="{{ number_format($transaction->order->quantity)  }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('original_price') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   value="{{ number_format($transaction->order->original_price)  }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('new_price') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   value="{{ number_format($transaction->order->new_price)  }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('inventory_owner_total') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   value="{{ number_format($transaction->order->original_price * $transaction->order->quantity) }}"
                                   disabled
                            />
                        </div>
                    </div>
                    <div class="mb-1 col-md-6">
                        <div>
                            <label class="col-form-label">{{ translate_ui('vendor_total') }}</label>
                        </div>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   value="{{ number_format($transaction->order->new_price - $transaction->order->original_price * $transaction->order->quantity) }}"
                                   disabled
                            />
                        </div>
            </div>
        </div>

    </div>
@endsection
