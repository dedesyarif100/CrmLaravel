{{-- <textarea
    name="{{ $attribute->code }}HtmlEditor"
    class="control"
    id="{{ $attribute->code }}HtmlEditor"
    v-validate="'{{$validations}}'"
    data-vv-as="&quot;{{ $attribute->name }}&quot;"
    v-pre>{{ old($attribute->code) ?: $value}}</textarea> --}}

<textarea
name="reply"
class="control"
id="HTMLEditor"
v-validate="'required'"
data-vv-as="&quot;{{ __('admin::app.leads.reply') }}&quot;"
></textarea>
