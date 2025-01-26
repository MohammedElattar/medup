@php use App\Helpers\TranslationHelper; @endphp
@props([
    'columns' => [],
    'title' => '',
    'shouldTranslate' => true,
    'paginated' => true,
    'paginationObject' => [],
    'multiSelectRow' => false,
])

<div class="col-12">
  <div class="card">
    <div class="card-header border-bottom p-4 d-flex justify-content-between flex-wrap">
      <h4 class="card-title">{{$shouldTranslate && $title ? translate_ui($title) : $title}}</h4>
      <div class="">
        @if(isset($tableButtons))
          {!! $tableButtons!!}
        @endif
      </div>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
        <tr>
          @if($multiSelectRow)
            <th>
              <input class="select-all form-check-input" type="checkbox"/>
            </th>
          @endif
          @foreach($columns as $column)
            <th>{{ TranslationHelper::translateWord($column) }}</th>
          @endforeach
        </tr>
        </thead>
        <tbody>
        {!! $tableBody !!}
        </tbody>
        @if(isset($tableFooter))
          <tfoot>
          {!! $tableFooter !!}
          </tfoot>
        @endif
      </table>
    </div>
    @if($paginated)
      <nav aria-label="Page navigation" class="parent-pagination">
        <ul class="pagination mt-3 justify-content-end mx-2">
          @if($paginationObject['currentPage'] > 1)
            <li class="page-item" value="1">
              <a class="page-link" href="javascript:void(0)">&laquo;</a>
            </li>
          @endif
          @php($rangeCount = 3)
          @php($alreadyReplaced = false)
          @foreach(range($paginationObject['currentPage'], $paginationObject['lastPage']) as $page)
            @if(($page <= $paginationObject['currentPage'] + $rangeCount) || $page >= $paginationObject['lastPage'] - $rangeCount)
              <li
                value="{{$page}}"
                class="page-item {{$page == $paginationObject['currentPage'] ? 'active' : ''}}"
              >
                <a class="page-link" href="javascript:void(0)">{{$page}}</a></li>
            @elseif(! $alreadyReplaced)
              @php($alreadyReplaced = true)
              <div class="page-item">
                <a class="page-link" href="javascript:void(0)">...</a></div>
            @endif
          @endforeach
          @if($paginationObject['currentPage'] < $paginationObject['lastPage'])
            <li class="page-item" value="{{$paginationObject['lastPage']}}">
              <a class="page-link" href="javascript:void(0)">&raquo;</a>
            </li>
          @endif
        </ul>
      </nav>
    @endif
  </div>
</div>

@push('custom-scripts')
  @vite([
    'resources/assets/js/pagination.js'
])
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    const selectAllInput = document.querySelector('.form-check-input.select-all')
    const sessionKey = `select-all-${window.location.pathname}`;

    if (selectAllInput) {
      const allSelectInputs = document.querySelectorAll('.form-check-input.one-row');
      const sessionData = JSON.parse(sessionStorage.getItem(sessionKey)) || {};

      function syncStorage() {
        sessionStorage.setItem(sessionKey, JSON.stringify(sessionData));
      }

      function isAllSelected() {
        return Array.from(allSelectInputs).every((input) => input.checked);
      }

      function syncAllSelected() {
        allSelectInputs.forEach((input) => {
          input.checked = selectAllInput.checked
          sessionData[input.value] = input.checked;
        })

        syncStorage();
      }

      function resetSelected() {
        allSelectInputs.forEach((input) => {
          input.checked = false;
          sessionData[input.value] = false;
        })

        selectAllInput.checked = false;
        sessionStorage.removeItem(sessionKey);
      }

      allSelectInputs.forEach((input) => {
        input.checked = sessionData[input.value] || false;
        input.addEventListener('change', () => {
          sessionData[input.value] = input.checked;
          selectAllInput.checked = isAllSelected();

          syncStorage();
        });
      })

      selectAllInput.addEventListener('change', () => {
        syncAllSelected()
      })

      document.querySelector('#reset-selected').addEventListener('click', () => {
        resetSelected();
      })

      selectAllInput.checked = isAllSelected();
    }
  </script>
@endpush
