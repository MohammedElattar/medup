@php use App\Helpers\TranslationHelper; @endphp
@props(['message' => session('toast')])
@if($message)
  <div
    class="basic-toast toast toast-success alert alert-outline-success d-flex align-items-center position-fixed {{ TranslationHelper::isRtl() ? 'top-0 start-0' : 'top-0 end-0' }} m-3" style="z-index: 999999;">

  <span class="alert-icon rounded">
          <i class="ti ti-check"></i>
        </span>
    <div class="toast-body">{{$message}}</div>
  </div>
@endif

@push('custom-scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let toastElement = document.querySelector('.basic-toast');

      if(toastElement) {
        setTimeout(() => {
          toastElement.classList.add('d-none')
        }, 3000)
      }
    });
  </script>
@endpush
