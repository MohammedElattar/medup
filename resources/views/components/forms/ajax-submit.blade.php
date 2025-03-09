@props([
     'selector' => '.send-form',
     'method' => 'POST',
     'callbackUrl' => ''
 ])

<x-ui.loader/>

@push('custom-scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite([
            'resources/assets/js/loader.js'
        ])
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const form = document.querySelector('{{ $selector }}');

            form.addEventListener('submit', function(e){
                e.preventDefault()
                let data = new FormData(form)
                const isFormData = true

                if(! isFormData) {
                    data = Object.fromEntries(data.entries())
                    console.log('data', Object.fromEntries(data.entries()))
                }

                dispatchLoading()

                window.axios.defaults.headers.common['show-toast'] = 0;

                axios({
                    method: '{{$method}}',
                    url: form.action,
                    data,
                    headers: {
                        accept: isFormData ? 'multipart/form-data' : 'application/json'
                    }
                }).then(()=> {
                    window.location.replace('{{$callbackUrl}}')
                }).catch(errors => {
                    if(errors.status === 422) {
                        handleValidationErrors(form, errors.response.data.data)
                    }
                }).finally(() => dispatchLoaded())
            })
        })


        async function handleValidationErrors(form, errors) {
            form.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(el => {
                el.remove();
            });

            const firstKey   = Object.keys(errors)[0];
            const translatedKey = await axios.get('{{route('translate-word')}}?field=' + firstKey);
            const error = `${translatedKey.data}: ${errors[firstKey]}`;

            flasher.error(error);

            Object.keys(errors).forEach(field => {
                const match = field.match(/^(.+)\.(en|ar|fr)$/);
                let accessKey = field;

                if(match) {
                    [, inpt, locale] = match;
                    accessKey = `${inpt}[${locale}]`;
                }

                const input = form.querySelector(`[name="${accessKey}"]`);
                if (input) {
                    input.classList.add('is-invalid');

                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = errors[field];
                    input.parentNode.appendChild(feedback);
                }
            });
        }

    </script>
@endpush
