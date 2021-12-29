<div id="{{ $attribute->code }}_htmleditor" class="html-editor"></div>
<textarea name="{{ $attribute->code }}" id="{{ $attribute->code }}_textarea" style="display: none;"> {{ old($attribute->code) ?: $value }} </textarea>
{{-- <div id="popup">
    <div class="value-content">
        <div id="gridContainer"></div>
        <div class="options">
            <div class="option">
                <div id="submitButton"></div>
            </div>
        </div>
    </div>
</div> --}}
