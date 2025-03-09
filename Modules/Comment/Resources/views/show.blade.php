@extends('layouts/layoutMaster')

@section('title', translate_ui('comment_details'))

@section('content')
    <x-ui.breadcrumbs :pages="['comments' => url()->previous(), 'show']"/>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ translate_ui('comment_details') }}</h4>
            </div>
            <div class="card-body">

                <form class="form form-horizontal" id="delete-form" action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="col-form-label" for="user">{{ translate_ui('user') }}</label>
                            <input type="text" id="user"
                                   class="form-control"
                                   readonly
                                   value="{{ $comment->user->name }}"
                            />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="col-form-label" for="user">{{ translate_ui('replied_user') }}</label>
                            <input type="text" id="user"
                                   class="form-control"
                                   readonly
                                   value="{{ $comment->repliedUser?->name ?: 'N/A' }}"
                            />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="col-form-label" for="content">{{ translate_ui('content') }}</label>
                            <textarea id="content" class="form-control" rows="5" readonly>{{ $comment->content }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger" id="submit-button">{{ translate_ui('delete') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-ui.toast/>
    <x-ui.sweetalert/>
    @push('custom-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                const form = document.querySelector('#delete-form');
                const button = document.querySelector('#submit-button');

                button.addEventListener('click', function(e){
                    e.preventDefault()
                    showSweetAlert(() => {
                        form.submit()
                    })
                })
            })
        </script>
    @endpush
@endsection
