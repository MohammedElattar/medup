@props([
    'name' => '',
    'editorId' =>
    'editorElement',
    'value' => '',
    'isTranslated' => false
])

<!-- Vendor Styles -->
@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/quill/typography.scss',
    'resources/assets/vendor/libs/quill/editor.scss'
  ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/quill/quill.js'
  ])
@endsection
<div class="quill-container">
    <input type='hidden' name="{{$name}}" translate>
    <div class="{{$editorId}} scrollbar-main text-dynamic" translate name="{{$name}}" style="min-height: 200px; max-height: 500px; overflow: auto;">
    </div>
</div>

@push('custom-scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.editorElement').forEach((e) => {
                let name = `[name="${e.getAttribute('name')}"]`;

                let quill = new Quill(e, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            ['bold', 'italic', 'underline'],
                            ['link'],
                            [{ 'align': [] }],
                            ['image'],
                            [{ 'color': [] }, { 'background': [] }],
                            ['blockquote', 'code-block'],
                            ['clean']
                        ]
                    }
                });

                quill.root.innerHTML = document.querySelector(name).value;
                quill.on('text-change', function(){
                    document.querySelector(name).value = quill.root.innerHTML;
                });
            })
        });
    </script>

@endpush
