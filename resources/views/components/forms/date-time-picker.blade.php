@php use App\Helpers\DateHelper;use App\Helpers\TranslationHelper;use Illuminate\Support\Carbon; @endphp
@props([
    'id' => 'date',
    'placeholder' => 'choose_date',
    'name' => 'date',
    'errorKey' => '',
    'options' => [
        'enableTime' => true,
        'dateFormat' => 'Y-m-d H:i',
        'time_24hr' => false,
        'disableDate' => false,
    ],
    'errorMessage' => null,
    'overrideOptions' => [],
    'value' => ''
])

@php($value = $value instanceof Carbon ? $value->format(DateHelper::defaultDateTimeFormat()) : ($value ? Carbon::parse($value)->format(DateHelper::dateTimeFormat()) : ''))
@php($hideDate = $overrideOptions['disableDate'] ?? $options['disableDate'])
@php($errorKey = $errorKey ?: $name)
@php($value = $hideDate && ($overrideOptions['enableTime'] ?? $options['enableTime'] )? (explode(' ', $value)[1] ?? '') : $value)
<input type="text" id="{{$id}}" class="form-control @error($errorKey) is-invalid @enderror"
       placeholder="{{translate_ui($placeholder)}}" name="{{$name}}"
       value="{{$value}}"
>
@error($errorKey)
<div class="invalid-feedback">{{ $message }}</div>
@enderror

@if($errorMessage)
    <div class="invalid-feedback">{{ $errorMessage }}</div>
@endif

@push('custom-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@push('custom-scripts')
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const flatpickrOptions = {
                enableTime: {{ $overrideOptions['enableTime'] ?? $options['enableTime'] ? 'true' : 'false' }},
                dateFormat: "{{ $overrideOptions['dateFormat'] ?? $options['dateFormat'] }}",
                time_24hr: {{ $options['time_24hr'] ? 'true' : 'false' }},
                noCalendar: {{$hideDate ? 'true' : 'false'}},
                altInput: true,
                maxDate: "tomorrow",
                defaultDate: "{{ $value }}",
                locale: '{{ TranslationHelper::getCurrentLocale() }}'
            };

            flatpickr("#{{$id}}", flatpickrOptions);
        });
    </script>
@endpush
