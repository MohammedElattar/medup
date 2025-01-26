@props([
  'title' => 'are you sure?',
  'text' => 'This action cannot be undone.',
  'confirmButtonText' => 'confirm',
  'cancelButtonText' => 'cancel',
  'deleteUrl' => '#'
])

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/extended-ui-sweetalert2.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  ])
@endsection

@push('custom-scripts')
    <script>
        function showSweetAlert(handleDelete) {
            Swal.fire({
                title: '{{ translate_ui($title) }}',
                text: '{{ translate_ui($text) }}',
              confirmButtonText: '{{ translate_ui($confirmButtonText) }}',
              cancelButtonText: '{{ translate_ui($cancelButtonText) }}',
              icon: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                customClass: {
                  confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                  cancelButton: 'btn btn-secondary waves-effect waves-light'
                },
                buttonsStyling: false

            }).then((result) => {
                if (result.isConfirmed) {
                    handleDelete()
                }
            });
        }
    </script>
@endpush
