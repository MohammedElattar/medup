@props(['name' => 'description'])

<textarea id="{{$name}}"
          class="form-control @error($name) is-invalid @enderror"
          name="{{$name}}"
          placeholder="{{ translate_ui($name) }}"
          translate
></textarea>
@error($name)
<span class="invalid-feedback">{{ $message }}</span>
@enderror