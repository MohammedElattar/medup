@php use Illuminate\Database\Eloquent\Collection;use Illuminate\Support\Str; @endphp
@props([
    'name' => '',
    'id' => '',
    'randomId' => true,
    'multiple' => true,
    'options' => [],
    'relationName' => '',
    'item' => null,
    'definitions' => ['value' => 'id', 'label' => 'name'],
    'takeFromQueryParams' => false,
])
@php
    $id = $id ?: ($randomId ? Str::random(8) : $name);
@endphp
@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/select2/select2.scss',
  ])
@endsection
@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/select2/select2.js',
  ])
@endsection

<select
        name="{{$name}}{{$multiple ? '[]' : ''}}"
        class="select2 form-select"
        {{$multiple ? 'multiple' : ''}}
        id="{{$id}}"
>
    @php
        if($item)
        {
            $relationName = $relationName ?: $name;
            $item = $item ?: collect();
            $items = $item->{$relationName} instanceof Collection
            ? $item->{$relationName}
            : collect([$item->{$relationName}]);
        } else {
                $items = collect();
        }

        $selected = old(
            $name,
                $takeFromQueryParams ? [request()->input($name)] : $items->keyBy($definitions['value'])->pluck($definitions['value'])->toArray()
            );
        $selectedValues = is_array($selected ?? []) ? $selected : [$selected];
        $selectedValues = array_combine($selectedValues ?: [], $selectedValues ?: []);
    @endphp
    <option value="">{{translate_ui('select_an_option')}}</option>
    @foreach($options as $option)
        <option value="{{ $option->{$definitions['value']} }}" {{ isset($selectedValues[$option->{$definitions['value']}]) ? 'selected' : '' }}>{{ $option->{$definitions['label']}  }}</option>
    @endforeach
</select>
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectMenu = $('#{{$id}}');

            selectMenu.each(function () {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this.select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $this.parent(),
                    closeOnSelect: false
                });
            });
        });
    </script>
@endpush
