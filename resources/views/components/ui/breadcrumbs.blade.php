@props(['pages' => []])

@if(!empty($pages))
    <div class="card mb-3 d-flex justify-content-center">
        <div class="card-body pb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @php($lastKey = array_key_last($pages))
                    @foreach($pages as $name => $link)
                        @if($name != $lastKey)
                            <li class="breadcrumb-item">
                                <a href="{{$link}}">{{translate_ui($name)}}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active">{{translate_ui(is_numeric($name) ? $link : $name)}}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
@endif