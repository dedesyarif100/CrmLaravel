<textarea
    name="{{ $attribute->code }}"
    class="control"
    id="{{ $attribute->code }}"
    v-validate="'{{$validations}}'"
    data-vv-as="&quot;{{ $attribute->name }}&quot;"
    v-pre>{{ old($attribute->code) ?: $value}}</textarea>

{{-- <input
    type="text"
    name="{{ $attribute->code }}"
    class="control"
    id="{{ $attribute->code }}"
    value="{{ old($attribute->code) ?: $value }}"
    @if ($attribute->code == 'sku') v-validate="{{$validations}}" @else v-validate="'{{$validations}}'" @endif
    data-vv-as="&quot;{{ $attribute->name }}&quot;"/> --}}
