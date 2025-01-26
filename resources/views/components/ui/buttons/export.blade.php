<div class="dropdown d-flex align-items-center">
    <button
            style="width: max-content;"
            class="btn btn-outline-secondary mb-0 me-1 flex-shrink-0" id="reset-selected" type="button">
        <i class="me-1 fa fa-share"></i>{{translate_ui('reset_selected')}}
    </button>
    <button class="btn btn-outline-secondary mb-0 dropdown-toggle mx-2 dropdown-toggle flex-shrink-0" type="button"
            style="width: max-content;"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="me-1 ti ti-share"></i>{{translate_ui('export')}}
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <button class="dropdown-item" id="export-all">
            <span class="align-middle">{{translate_ui('export_all')}}</span>
        </button>
        <button class="dropdown-item" id="export-selected">
            <span class="align-middle">{{translate_ui('export_selected')}}</span>
        </button>
    </div>
</div>
