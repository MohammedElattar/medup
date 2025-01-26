@props(['code' => '', 'name' => ''])
<td>
    <div class="d-flex flex-row align-items-center">
        <div class="mb-1 mx-1" style="width: 30px; height: 30px; background-color: {{ $code }};"></div>
        <span class="mb-1">{{ $name ?: $code }}</span>
    </div>
</td>