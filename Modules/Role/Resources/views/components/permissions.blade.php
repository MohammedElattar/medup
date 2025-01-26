@props([
    'permissions' => [],
    'name' => 'permissions',
    'defaultPermissions' => [],
])
<div>
    <h4 class="mt-2 pt-50">Permissions</h4>
    <div class="table-responsive">
        <table class="table table-flush-spacing permissions-table">
            <tbody>
            <tr>
                <td class="text-nowrap fw-bolder">
                    Administrator Access
                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                                                                        <i data-feather="info"></i>
                                                                    </span>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAllPermissions" />
                        <label class="form-check-label" for="selectAllPermissions"> Select All </label>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <select hidden name="{{$name}}[]" id="permissions-menu" multiple>
        @foreach($defaultPermissions as $permission)
            <option value="{{$permission->id}}" selected></option>
        @endforeach
    </select>
</div>

@php
    $pages = collect($permissions)->pluck('name')->map(fn($name) => explode('-', $name)[1])->unique();
    $mappedPages = [];
    foreach($pages as $page)
    {
        $mappedPages[$page] = translate_ui($page);
    }

    $operations = collect($permissions)->pluck('name')->map(fn($name) => explode('-', $name)[0])->unique();
    $mappedOperations = [];
    foreach($operations as $operation)
    {
        $mappedOperations[$operation] = translate_ui($operation);
    }

    $defaultIds = collect(old($name, collect($defaultPermissions)->pluck('id')))->keyBy(fn($id) => $id)->toArray();
@endphp
@push('custom-scripts')
    <script>
        const permissionsTable = document.querySelector('.permissions-table tbody');
        let permissions = Array.from(@json($permissions));
        const permissionsObject = {};
        let operations = new Set();
        let pages = new Set();
        const translatedPages = @json($mappedPages);
        const translatedOperations = @json($mappedOperations);
        const defaultIds = @json($defaultIds);
        const inputsSelector = '.permissions-checkbox:not(:disabled)';
        const syncSelectAllCheckbox = () => {
            document.querySelector('#selectAllPermissions').checked = Object.values(defaultIds).length === permissions.length;
        }
        const getParsedId = (id) => {
            return id.split('-')[2];
        }
        const unSelectPermission = (id, shouldParse = false) => {
            id = shouldParse ? getParsedId(id) : id;
            document.querySelector(`#permissions-menu option[value="${id}"]`)?.remove();

            delete defaultIds[id]
            syncSelectAllCheckbox()
        }
        const selectPermission = (id) => {
            id = getParsedId(id);
            unSelectPermission(id);
            document.querySelector('#permissions-menu').innerHTML+=`<option value="${id}" selected></option>`;
            defaultIds[id] = id;
            syncSelectAllCheckbox()
        }
        const refreshClickListener = () => {
            document.querySelectorAll(inputsSelector).forEach((element) => {
                element.addEventListener('click', function(e){
                    const checked = e.target.checked;

                    if(checked)
                        selectPermission(e.target.id)
                    else
                        unSelectPermission(e.target.id, true);
                })
            })
        }

        permissions.forEach((permissionItem) => {
            [operation, page] = permissionItem.name.split('-');
            pages.add(page);
            operations.add(operation)
            permissionsObject[permissionItem.name] = permissionItem.id;
        })

        operations = Array.from(operations).sort()
        pages = Array.from(pages).sort()

        pages.forEach((page) => {
            const trElement = document.createElement('tr');

            const trTitle = document.createElement('td');
            trTitle.classList.add('text-nowrap', 'fw-bolder');
            trTitle.textContent = translatedPages[page];

            const trContent = document.createElement('td');
            const operationsWrapper = document.createElement('div');
            operationsWrapper.classList.add('d-flex');

            operations.forEach((operation) => {
                const id = permissionsObject[`${operation}-${page}`];
                const child = document.createElement('div');

                child.classList.add('form-check', 'me-3', 'me-lg-5');
                child.innerHTML+= `<input class="permissions-checkbox form-check-input" type="checkbox" id="permissions-item-${id}" ${defaultIds[id] ? 'checked' : ''} ${id === undefined ? 'disabled' : ''}/>
                                                    <label class="form-check-label" for="permissions-item-${id}"> ${translatedOperations[operation]} </label>`
                operationsWrapper.innerHTML+=child.outerHTML;
            })

            trContent.appendChild(operationsWrapper);
            trElement.appendChild(trTitle)
            trElement.appendChild(trContent)
            permissionsTable.appendChild(trElement);

            refreshClickListener()
        })

        document.querySelector('#selectAllPermissions').addEventListener('click', function(e){
            const checked = e.target.checked;

            document.querySelectorAll(inputsSelector).forEach((element) => {
                element.checked = checked;

                if(checked)
                    selectPermission(element.id)
                else
                    unSelectPermission(element.id, true);
            })
        })

        syncSelectAllCheckbox()
    </script>
@endpush