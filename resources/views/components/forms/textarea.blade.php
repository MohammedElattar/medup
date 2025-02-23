@props(['name' => 'description', 'disabled' => false, 'value' => '', 'style' => ''])

<textarea id="{{$name}}"
          class="form-control @error($name) is-invalid @enderror"
          name="{{$name}}"
          style="{{$style}}"
          translate
          {{$disabled ? 'disabled' : ''}}
          placeholder="{{ translate_ui($name) }}"

>{{$value}}</textarea>
@error($name)
<span class="invalid-feedback">{{ $message }}</span>
@enderror
