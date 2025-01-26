@props([
    'images' => [],
    'id' => 'multi-images',
    'name' => 'other_images',
    'deletedImagesName' => 'deleted_images',
])

<!-- Vendor Styles -->
@push('custom-styles')
  @vite([
    'resources/assets/vendor/libs/dropzone/dropzone.scss'
  ])
@endpush

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'])
@endsection

<div class="row">
<div class="col-12">
  <div class="col-12">
    <div class="card mb-6">
      <div class="card-body dropzone cursor-pointer" id="{{$id}}-dropzone">
          <div class="dz-message text-white">
            {{translate_ui('click_to_upload')}}
          </div>
      </div>
      <input type="file" hidden id="{{$id}}-initial-input" multiple accept="image/*">
      <input
        hidden
        type="file"
        id="{{$id}}-target-input"
        name="{{$name}}[]"
        multiple
      />
      @if($deletedImagesName)
        <select hidden name="{{$deletedImagesName}}[]" id="{{$id}}-{{$deletedImagesName}}" multiple="multiple">
          @foreach(old($deletedImagesName, []) as $deletedImage)
            <option value="{{$deletedImage}}" selected></option>
          @endforeach
        </select>
      @endif
    </div>
    <div class="accordion accordion-margin" id="{{$id}}-preview-accordion">
    </div>

    @error($name)
    <div class="invalid-feedback d-block fw-bold">{{ $message }}</div>
    @enderror
  </div>
</div>
</div>

@push('custom-scripts')
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'])
    <script>
        let images = @json($images);
        const allowedExtensions = ['jpeg', 'png', 'jpg'];
        const maxFileSize = 2 * 1024 * 1024;
        const eventHandler = new EventTarget()
        const targetFileInput = document.getElementById('{{$id}}-target-input');
        const deletedImagesIds = document.getElementById('{{$id}}-{{$deletedImagesName}}');

        document.addEventListener('DOMContentLoaded', function(){
            previewImages(images);

            const dropzone = document.getElementById('{{$id}}-dropzone');
            const fileInput = document.getElementById('{{$id}}-initial-input');

            dropzone.addEventListener('click', function (e) {
                e.preventDefault();

                fileInput.click();
            })

            fileInput.addEventListener('change', function(e){
                e.preventDefault();
                const filesList = Array.from(e.target.files);

                if(filesList.length)
                {
                    try {
                        addFiles(filesList);
                        updateTargetFilesList(filesList)
                        fileInput.value = ''
                    } catch(e) {
                        console.error(e)
                    }
                }
            })
        })

        const addFiles = (files) => {
            let validFiles = [];

            const filePromises = files.map(file => {
                return new Promise((resolve, reject) => {
                    try {
                        validateFile(file);
                        generateBase64(file).then((base64) => {
                            const uid = generateUUID();
                            file.id = uid;

                            validFiles.push({
                                id: uid,
                                url: base64,
                                isNew: true,
                                meta: {
                                    name: file.name,
                                    size: file.size
                                }
                            });

                            resolve();
                        }).catch((err) => {
                            reject(err);
                        });

                    } catch (err) {
                        reject(err);
                    }
                });
            });

            Promise.all(filePromises)
                .then(() => {
                    if (validFiles.length) {
                        images = images.concat(validFiles);
                        eventHandler.dispatchEvent(new CustomEvent('filesAdded', { detail: validFiles }));
                    }
                })
        }
        const validateFile = (file) => {
            //TODO validate file extension
            const fileExtension = file.name.split('.').pop();

            if(! allowedExtensions.includes(fileExtension))
            {
                throw new Error('not_allowed_extension')
            }

            const fileSize = file.size;

            if(fileSize > maxFileSize)
            {
                throw new Error('file_too_large')
            }
        }
        const formatFileSize = (bytes, decimals = 2) => {
            if (bytes === 0) return '0 B';

            const k = 1024;
            const sizes = ['B', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(decimals)) + ' ' + sizes[i];
        }
        const generateUUID = () => {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
        const generateBase64 = (file) => {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                reader.onload = function(e){
                    resolve(e.target.result);
                }

                reader.onerror = function(e){
                    reject(e);
                }

                reader.readAsDataURL(file);
            })
        }
        const updateTargetFilesList = (files = [], filesIds = []) => {
            const dataTransfer = new DataTransfer();

            Array.from(targetFileInput.files).forEach((file) => {
                dataTransfer.items.add(file);
            })

            files.forEach((file) => {
                dataTransfer.items.add(file);
            })

            filesIds.forEach((id) => {
                let fileObject = {};
                let fileIndex = -1;

                images.forEach((f, index) => {
                    if((f.id + '') === (id + ''))
                    {
                        fileObject = f;
                        fileIndex = index;
                    }
                })

                dataTransfer.items.remove(fileIndex);
                images.splice(fileIndex, 1)

                if(! fileObject.isNew && deletedImagesIds)
                {
                    deletedImagesIds.innerHTML+=`<option value="${fileObject.id}" selected>${fileObject.id}</option>`
                }
            })

            targetFileInput.files = dataTransfer.files;
        }

        const previewImages = (files) => {
            const accordion = document.getElementById('{{$id}}-preview-accordion');

            files.forEach((file) => {
                accordion.innerHTML+=`
            <div class="accordion-item" id="{{$id}}-${file.id}-accordion-item">
                <div class="accordion-header" id="{{$id}}-${file.id}-accordion-heading">
                    <div
                            class="accordion-button collapsed align-items-center"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{$id}}-${file.id}-accordion-id"
                            aria-expanded="false"
                            aria-controls="{{$id}}-${file.id}-accordion-id"
                    >
                        <div class="d-flex justify-content-start align-items-center w-100">
                            <p class="me-2 align-self-center fw-bold mb-0 file-number badge badge-center rounded-pill bg-label-danger"></p>
                            <img src="${file.url}" class="rounded" height="28" width="28" alt="image"/>
                            <div class="ms-1">
                                <p class="mb-0">${file?.meta?.name || 'N/A'}</p>
                                <p class="mb-0">${formatFileSize(file?.meta?.size) || 'N/A'}</p>
                            </div>
                        </div>
                        <button class="btn-icon me-2 btn btn-outline-danger btn-sm" id="${file.id}-delete-button" file-id='${file.id}'>
                            <i class='fa fa-x'></i>
                        </button>
                    </div>
                </div>
                <div
                        id="{{$id}}-${file.id}-accordion-id"
                        class="accordion-collapse collapse"
                        aria-labelledby="{{$id}}-${file.id}-accordion-heading"
                        data-bs-parent="#{{$id}}-${file.id}-accordion-id"
                >
                    <div class="accordion-body text-center">
                        <img
                                src="${file.url}"
                                class="responsive-image"
                                alt="Preview Image"
                        />
                    </div>
                </div>
            </div>`
            })

            document.querySelectorAll('.file-number').forEach((i, index) => {
              i.textContent = index+1;
            })
            // feather.replace()

            accordion.addEventListener('click', (e) => {
                if (e.target.closest('button')) {
                    const button = e.target.closest('button');
                    console.log('button', button)
                    const fileId = button.getAttribute('file-id');
                    const item = document.getElementById(`{{$id}}-${fileId}-accordion-item`);

                    if (item) {
                        item.remove();
                        updateTargetFilesList([], [fileId]);
                    }
                }
            });
        }

        eventHandler.addEventListener('filesAdded', function(e){
            previewImages(e.detail)
        })
    </script>
@endpush
