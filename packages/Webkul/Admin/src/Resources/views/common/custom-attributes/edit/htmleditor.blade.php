<textarea
    name="{{ $attribute->code }}HtmlEditor"
    class="control"
    id="{{ $attribute->code }}HtmlEditor"
    v-validate="'{{$validations}}'"
    data-vv-as="&quot;{{ $attribute->name }}&quot;"
    v-pre>{{ old($attribute->code) ?: $value}}</textarea>
