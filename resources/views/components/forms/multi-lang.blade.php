@php use App\Helpers\TranslationHelper; @endphp
@php
    $currentLocale = TranslationHelper::getCurrentLocale();
@endphp
@props(['item' => null])

<div class="mb-5 col-12">
    <!-- Language Tab Navigation -->
    <ul class="nav nav-tabs" id="multi-lang-tabs" role="tablist">
        @foreach(TranslationHelper::getAvailableLocales() as $lang)
            <li class="nav-item" role="presentation">
                <a
                        class="nav-link {{$currentLocale == $lang ? 'active' : '' }}"
                        id="tab-{{ $lang }}"
                        data-bs-toggle="tab"
                        href="#content-{{ $lang }}"
                        aria-controls="content-{{ $lang }}"
                        role="tab"
                        aria-selected="{{ $currentLocale == $lang ? 'true' : 'false' }}">
                    {{ translate_ui($lang) }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Language Tab Content -->
    <div class="tab-content p-0 mt-5" id="multi-lang-tab-content">
        @foreach(TranslationHelper::getAvailableLocales() as $lang)
            <div
                    class="tab-pane {{ $currentLocale == $lang ? 'active show' : '' }}"
                    id="content-{{ $lang }}"
                    role="tabpanel"
                    aria-labelledby="tab-{{ $lang }}">

                @php
                    $dom = new DOMDocument('1.0', 'UTF-8');
                    libxml_use_internal_errors(true);

                    $dom->loadHTML(mb_convert_encoding($slot, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    libxml_clear_errors();

                    $xpath = new DOMXPath($dom);
                    $translatedElements = $xpath->query('//*[@translate]');
                    $hasError = false;

                    foreach ($translatedElements as $element) {
                        if ($element->hasAttribute('name')) {
                            $originalName = $element->getAttribute('name');
                            $value = old("$originalName.$lang", $item?->getTranslations($originalName)[$lang]) ?: '';
                            $error = isset($errors) ? $errors->first("$originalName.$lang") : null;
                            $hasError = (bool) $error;
                            $element->setAttribute('name', "{$originalName}[$lang]");

                            if ($element->tagName === 'textarea') {
                                $element->textContent = $value;
                            } else {
                                $element->setAttribute('value', $value);
                            }
                            $element->removeAttribute('translate');

                            if($error)
                            {
                                $errorElement = $dom->createElement('div', $error);
                                $errorElement->setAttribute('class', 'alert alert-danger');
                                $element->parentNode->appendChild($errorElement);
                            }
                        }
                    }

                    $updatedContent = $dom->saveHTML($dom->getElementsByTagName('body')->item(0));
                    header('Content-Type: text/html; charset=UTF-8');

                    echo $updatedContent;
                @endphp
            </div>
        @endforeach
    </div>
</div>
