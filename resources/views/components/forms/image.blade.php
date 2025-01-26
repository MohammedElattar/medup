@php use Illuminate\Support\Str; @endphp
@props([
    'name' => 'image',
    'relation' => '',
    'id' => '',
    'item' => null,
])

@php($id = $id ?: Str::random())
@php($relation = $relation ?: $name)
<div>
<input type="file" id="{{$id}}"
       accept="image/*"
       class="form-control @error($name) is-invalid @enderror"
       name="{{$name}}"
       placeholder="{{ translate_ui($name) }}"
/>
@error('image')
<span class="invalid-feedback">{{ $message }}</span>
@enderror

<img
        alt="image"
        class="mt-1 responsive-image"
        id="{{$id}}-preview"
        src="{{$item ? \App\Helpers\ResourceHelper::getFirstMediaOriginalUrl($item, $relation): asset('storage/default/store.png')}}"
/>

</div>
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){

        const imageInput = document.getElementById('{{$id}}');
        imageInput.addEventListener('change', function(event){
            console.log('input changed')
            const files = event.target.files;

            if(files.length)
            {
                const file = files[0];
                const reader = new FileReader();

                reader.onload = function(e){
                    const image = document.getElementById("{{$id}}-preview");
                    image.src = e.target.result;

                    imageInput.parentElement.appendChild(image);
                }

                reader.readAsDataURL(file);
            }
        })
        })

    </script>
@endpush
