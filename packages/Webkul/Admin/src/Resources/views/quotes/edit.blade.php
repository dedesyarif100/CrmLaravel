@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.quotes.edit-title') }}
@stop

@section('css')
    <style>
        #backToTop {
            position: fixed;
            width: 50px;
            height: 50px;
            bottom: 20px;
            right: 30px;
        }
        .quote-item-list td:not(:first-child) input {
            text-align: right;
        }
    </style>
@endsection

@section('content-wrapper')
    <button id="backToTop" class="btn btn-md btn-primary" onclick="backToTop();">
        <i class="fad fa-angle-double-up"></i>
    </button>

    <div class="content full-page adjacent-center">
        {!! view_render_event('admin.quotes.edit.header.before', ['quote' => $quote]) !!}

        <div class="page-header">

            {{ Breadcrumbs::render('quotes.edit', $quote) }}

            <div class="page-title">
                <h1>{{ __('admin::app.quotes.edit-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('admin.quotes.edit.header.after', ['quote' => $quote]) !!}

        <form method="POST" action="{{ route('admin.quotes.update', $quote->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            {{-- @dd($quote->term_and_condition) --}}
            <div class="page-content">
                <div class="form-container">

                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('admin.quotes.edit.form_buttons.before', ['quote' => $quote]) !!}

                            <button type="submit" class="btn btn-md btn-primary">
                                {{ __('admin::app.quotes.save-btn-title') }}
                            </button>

                            <a href="{{ route('admin.quotes.index') }}">{{ __('admin::app.quotes.back') }}</a>

                            {!! view_render_event('admin.quotes.edit.form_buttons.after', ['quote' => $quote]) !!}
                        </div>

                        <div class="panel-body">
                            {!! view_render_event('admin.quotes.edit.form_controls.before', ['quote' => $quote]) !!}

                            @csrf()

                            <input name="_method" type="hidden" value="PUT">

                            {!! view_render_event('admin.quotes.edit.form_controls.information.before', ['quote' => $quote]) !!}

                            <accordian :title="'{{ __('admin::app.quotes.quote-information') }}'" :active="true">
                                <div slot="body">

                                    @include('admin::common.custom-attributes.edit', [
                                        'customAttributes'       => app('Webkul\Attribute\Repositories\AttributeRepository')
                                            ->scopeQuery(function($query){
                                                return $query
                                                    ->where('entity_type', 'quotes')
                                                    ->whereIn('code', [
                                                        'user_id',
                                                        'subject',
                                                        'description',
                                                        'term_and_condition',
                                                        'expired_at',
                                                        'person_id',
                                                    ]);
                                            })->get(),
                                        'customValidations'      => [
                                            'expired_at' => [
                                               'required',
                                               'date_format:yyyy-MM-dd',
                                               'after:' . \Carbon\Carbon::yesterday()->format('Y-m-d')
                                            ],
                                        ],
                                        'entity'                 => $quote,
                                    ])

                                    <div class="form-group">
                                        <label for="validation">{{ __('admin::app.quotes.lead') }}</label>

                                        @include('admin::common.custom-attributes.edit.lookup')

                                        @php
                                            $lookUpEntityData = app('Webkul\Attribute\Repositories\AttributeRepository')
                                                ->getLookUpEntity(
                                                    'leads',
                                                    old('lead_id')
                                                        ?: (
                                                            ($lead = $quote->leads()->first())
                                                            ? $lead->id
                                                            : null
                                                        )
                                                    );
                                        @endphp

                                        <lookup-component
                                            :attribute="{'code': 'lead_id', 'name': 'Lead', 'lookup_type': 'leads'}"
                                            :data='@json($lookUpEntityData)'
                                        ></lookup-component>
                                    </div>

                                </div>
                            </accordian>

                            {!! view_render_event('admin.quotes.edit.form_controls.information.after', ['quote' => $quote]) !!}


                            {!! view_render_event('admin.quotes.edit.form_controls.address.before', ['quote' => $quote]) !!}

                            <accordian :title="'{{ __('admin::app.quotes.address-information') }}'" :active="true">
                                <div slot="body">

                                    @include('admin::common.custom-attributes.edit', [
                                        'customAttributes' => app('Webkul\Attribute\Repositories\AttributeRepository')
                                        ->scopeQuery(function($query){
                                            return $query
                                                ->where('entity_type', 'quotes')
                                                ->whereIn('code', [
                                                    'billing_address',
                                                    'shipping_address',
                                                ]);
                                        })->get(),
                                        'entity'           => $quote,
                                    ])

                                </div>
                            </accordian>

                            {!! view_render_event('admin.quotes.edit.form_controls.address.after', ['quote' => $quote]) !!}


                            {!! view_render_event('admin.quotes.edit.form_controls.items.before', ['quote' => $quote]) !!}

                            <accordian :title="'{{ __('admin::app.quotes.quote-items') }}'" :active="true">
                                <div slot="body">
                                    quote item
                                    <quote-item-list :data='@json($quote->items)'></quote-item-list>
                                </div>
                            </accordian>

                            {!! view_render_event('admin.quotes.edit.form_controls.items.after', ['quote' => $quote]) !!}

                            {!! view_render_event('admin.quotes.edit.form_controls.after', ['quote' => $quote]) !!}
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
@stop

@push('scripts')
    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

    <script type="text/x-template" id="quote-item-list-template">
        <div class="quote-item-list">
            <div class="table">
                <table>

                    <thead>
                        <tr>
                            <th class="name">
                                <div class="form-group">
                                    <label class="required">
                                         {{ __('admin::app.quotes.name') }}
                                    </label>
                                </div>
                            </th>

                            <th class="quantity">
                                <div class="form-group">
                                    <label class="required">
                                        {{ __('admin::app.quotes.quantity') }}
                                    </label>
                                </div>
                            </th>

                            <th class="price">
                                <div class="form-group">
                                    <label class="required">
                                         {{ __('admin::app.quotes.price') }}
                                        <span class="currency-code">(Rp)</span>
                                    </label>
                                </div>
                            </th>

                            <th class="amount">
                                <div class="form-group">
                                    <label class="required">
                                        {{ __('admin::app.quotes.amount') }}
                                        <span class="currency-code">(Rp)</span>
                                    </label>
                                </div>
                            </th>

                            <th class="discount">
                                <div class="form-group">
                                    <label class="required">
                                        {{ __('admin::app.quotes.discount') }}
                                         <span class="currency-code">(Rp)</span>
                                    </label>
                                </div>
                            </th>

                            <th class="tax">
                                <div class="form-group">
                                    <label class="required">
                                        {{ __('admin::app.quotes.tax') }}
                                        <span class="currency-code">(Rp)</span>
                                    </label>
                                </div>
                            </th>

                            <th class="total">
                                <div class="form-group">
                                    {{ __('admin::app.quotes.total') }}
                                    <span class="currency-code">(Rp)</span>
                                </div>
                            </th>

                            <th class="actions"></th>
                        </tr>
                    </thead>

                    <tbody>

                        <quote-item
                            v-for='(product, index) in products'
                            :product="product"
                            :key="index"
                            :index="index"
                            @onRemoveProduct="removeProduct($event)"
                        ></quote-item>

                    </tbody>

                </table>

                <a class="add-more-link" href @click.prevent="addProduct">+ {{ __('admin::app.common.add_more') }}</a>
            </div>

            {!! view_render_event('admin.quotes.edit.form_controls.summary.before', ['quote' => $quote]) !!}

            <div class="quote-summary">
                <table>
                    <tr>
                        <td>
                            {{ __('admin::app.quotes.sub-total') }}
                            <span class="currency-code">(Rp)</span>
                        </td>

                        <td>-</td>

                        <td>
                            <div class="form-group">
                                <input type="text" name="sub_total" class="control" :value="subTotal" readonly>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ __('admin::app.quotes.discount') }}
                            <span class="currency-code">(Rp)</span>
                        </td>

                        <td>-</td>

                        <td>
                            <div class="form-group">
                                <input type="text" name="discount_amount" class="control" v-model="discountAmount" readonly>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ __('admin::app.quotes.tax') }}
                            <span class="currency-code">(Rp)</span>
                        </td>

                        <td>-</td>

                        <td>
                            <div class="form-group">
                                <input type="text" name="tax_amount" class="control" :value="taxAmount" readonly>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ __('admin::app.quotes.adjustment') }}
                            <span class="currency-code">(Rp)</span>
                        </td>

                        <td>-</td>

                        <td>
                            <div class="form-group" :class="[errors.has('adjustment_amount') ? 'has-error' : '']">
                                <input
                                    type="text"
                                    name="adjustment_amount"
                                    class="control"
                                    v-model="adjustmentAmount"
                                    v-validate="'decimal:4'"
                                    data-vv-as="&quot;{{ __('admin::app.quotes.adjustment') }}&quot;"
                                />

                                <span class="control-error" v-if="errors.has('adjustment_amount')">
                                    @{{ errors.first('adjustment_amount') }}
                                </span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ __('admin::app.quotes.grand-total') }}
                            <span class="currency-code">(Rp)</span>
                        </td>

                        <td>-</td>

                        <td>
                            <div class="form-group">
                                <input type="text" name="grand_total" class="control" :value="grandTotal" readonly>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {!! view_render_event('admin.quotes.edit.form_controls.summary.after', ['quote' => $quote]) !!}
        </div>
    </script>

    <script type="text/x-template" id="quote-item-template">
        <tr>
            <td>
                <div class="form-group" :class="[errors.has(inputName + '[product_id]') ? 'has-error' : '']">
                    <input
                        type="text"
                        :name="[inputName + '[product_id]']"
                        class="control"
                        v-model="product['name']"
                        autocomplete="off"
                        v-validate="'required'"
                        data-vv-as="&quot;{{ __('admin::app.quotes.name') }}&quot;"
                        v-on:keyup="search"
                    />

                    <input
                        type="hidden"
                        :name="[inputName + '[product_id]']"
                        v-model="product.product_id"
                        v-validate="'required'"
                        data-vv-as="&quot;{{ __('admin::app.quotes.name') }}&quot;"
                    />

                    <div class="lookup-results" v-if="state == ''">
                        <ul>
                            <li v-for='(product, index) in products' @click="addProduct(product)">
                                <span>@{{ product.name }}</span>
                            </li>

                            <li v-if="! products.length && product['name'].length && ! is_searching">
                                <span>{{ __('admin::app.common.no-result-found') }}</span>
                            </li>
                        </ul>
                    </div>

                    <i class="icon loader-active-icon" v-if="is_searching"></i>

                    <span class="control-error" v-if="errors.has(inputName + '[product_id]')">
                        @{{ errors.first(inputName + '[product_id]') }}
                    </span>
                </div>
            </td>

            <td>
                <div class="form-group" :class="[errors.has(inputName + '[quantity]') ? 'has-error' : '']">
                    <input
                        type="text"
                        :name="[inputName + '[quantity]']"
                        class="control"
                        v-model="product.quantity"
                        v-validate="'required|decimal:4'"
                        data-vv-as="&quot;{{ __('admin::app.quotes.quantity') }}&quot;"
                    />

                    <span class="control-error" v-if="errors.has(inputName + '[quantity]')">
                        @{{ errors.first(inputName + '[quantity]') }}
                    </span>
                </div>
            </td>

            <td>
                <div class="form-group" :class="[errors.has(inputName + '[price]') ? 'has-error' : '']">
                    <input
                        type="text"
                        :name="[inputName + '[price]']"
                        class="control"
                        v-model="product.price"
                        v-validate="'required|decimal:4'"
                        data-vv-as="&quot;{{ __('admin::app.quotes.price') }}&quot;"
                    />

                    <span class="control-error" v-if="errors.has(inputName + '[price]')">
                        @{{ errors.first(inputName + '[price]') }}
                    </span>
                </div>
            </td>

            <td>
                <div class="form-group" :class="[errors.has(inputName + '[price]') ? 'has-error' : '']">
                    <input
                        type="text"
                        :name="[inputName + '[total]']"
                        class="control"
                        v-model="product.price * product.quantity"
                        readonly
                    />
                </div>
            </td>

            <td>
                <div class="form-group" :class="[errors.has(inputName + '[discount_amount]') ? 'has-error' : '']">
                    <input
                        type="text"
                        :name="[inputName + '[discount_amount]']"
                        class="control"
                        v-model="product.discount_amount"
                        v-validate="'required|decimal:4'"
                        data-vv-as="&quot;{{ __('admin::app.quotes.discount') }}&quot;"
                    />

                    <span class="control-error" v-if="errors.has(inputName + '[discount_amount]')">
                        @{{ errors.first(inputName + '[discount_amount]') }}
                    </span>
                </div>
            </td>

            <td>
                <div class="form-group" :class="[errors.has(inputName + '[tax_amount]') ? 'has-error' : '']">
                    <input
                        type="text"
                        :name="[inputName + '[tax_amount]']"
                        class="control"
                        v-model="product.tax_amount"
                        v-validate="'required|decimal:4'"
                        data-vv-as="&quot;{{ __('admin::app.quotes.tax') }}&quot;"
                    />

                    <span class="control-error" v-if="errors.has(inputName + '[tax_amount]')">
                        @{{ errors.first(inputName + '[tax_amount]') }}
                    </span>
                </div>
            </td>

            <td>
                <div class="form-group" :class="[errors.has(inputName + '[price]') ? 'has-error' : '']">
                    <input
                        type="text"
                        :value="parseFloat(product.price * product.quantity) + parseFloat(product.tax_amount) - parseFloat(product.discount_amount)"
                        class="control"
                        readonly
                    />
                </div>
            </td>

            <td class="actions">
                <i class="icon trash-icon" @click="removeProduct" v-if="this.$parent.products.length > 1"></i>
            </td>
        </tr>
    </script>

    <script>
        Vue.component('quote-item-list', {

            template: '#quote-item-list-template',

            props: ['data'],

            inject: ['$validator'],

            data: function () {
                return {
                    adjustmentAmount: 0,

                    products: this.data ? this.data : [{
                        'id': null,
                        'product_id': null,
                        'name': '',
                        'quantity': 0,
                        'price': 0,
                        'discount_amount': 0,
                        'tax_amount': 0,
                    }],
                }
            },

            computed: {
                subTotal:  function() {
                    var total = 0;

                    this.products.forEach(product => {
                        total += parseFloat(product.price * product.quantity);
                    });

                    return total;
                },

                discountAmount: function() {
                    var total = 0;

                    this.products.forEach(product => {
                        total += parseFloat(product.discount_amount);
                    });

                    return total;
                },

                taxAmount: function() {
                    var total = 0;

                    this.products.forEach(product => {
                        total += parseFloat(product.tax_amount);
                    });

                    return total;
                },

                grandTotal: function() {
                    var total = 0;

                    this.products.forEach(product => {
                        total += parseFloat(product.price * product.quantity) + parseFloat(product.tax_amount) - parseFloat(product.discount_amount) + parseFloat(this.adjustmentAmount);
                    });

                    return total;
                }
            },

            methods: {
                addProduct: function() {
                    this.products.push({
                        'id': null,
                        'product_id': null,
                        'name': '',
                        'quantity': null,
                        'price': null,
                        'discount_amount': null,
                        'tax_amount': null,
                    })
                },

                removeProduct: function(product) {
                    if (this.products.length == 1) {
                        this.products = [{
                            'id': null,
                            'product_id': null,
                            'name': '',
                            'quantity': null,
                            'price': null,
                            'discount_amount': null,
                            'tax_amount': null,
                        }];
                    } else {
                        const index = this.products.indexOf(product);

                        Vue.delete(this.products, index);
                    }
                }
            }
        });

        Vue.component('quote-item', {

            template: '#quote-item-template',

            props: ['index', 'product'],

            inject: ['$validator'],

            data: function () {
                return {
                    is_searching: false,

                    state: this.product['product_id'] ? 'old' : '',

                    products: [],
                }
            },

            computed: {
                inputName: function () {
                    if (this.product.id) {
                        return "items[" + this.product.id + "]";
                    }

                    return "items[item_" + this.index + "]";
                }
            },

            methods: {
                search: debounce(function () {
                    this.state = '';

                    this.product['product_id'] = null;

                    this.is_searching = true;

                    if (this.product['name'].length < 2) {
                        this.products = [];

                        this.is_searching = false;

                        return;
                    }

                    var self = this;

                    this.$http.get("{{ route('admin.products.search') }}", {params: {query: this.product['name']}})
                        .then (function(response) {
                            self.$parent.products.forEach(function(addedProduct) {

                                response.data.forEach(function(product, index) {
                                    if (product.id == addedProduct.product_id) {
                                        response.data.splice(index, 1);
                                    }
                                });

                            });

                            self.products = response.data;

                            self.is_searching = false;
                        })
                        .catch (function (error) {
                            self.is_searching = false;
                        })
                }, 500),

                addProduct: function(result) {
                    this.state = 'old';

                    Vue.set(this.product, 'product_id', result.id);
                    Vue.set(this.product, 'name', result.name);
                    Vue.set(this.product, 'price', result.price);
                    Vue.set(this.product, 'quantity', result.quantity);
                    Vue.set(this.product, 'discount_amount', 0);
                    Vue.set(this.product, 'tax_amount', 0);
                },

                removeProduct: function () {
                    this.$emit('onRemoveProduct', this.product);
                }
            }
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        function backToTop() {
            window.scrollTo(0,0);
        }

        let selectedTemplate = [];

        $(function() {
            function selectionChanged(e) {
                selectedTemplate = e.selectedRowsData.map((data) => {
                    return data.template;
                });
            }

            let popupInstance;
            let string;
            let data;
            let tampung = [];
            let textarea;

            // MUNCULKAN EDITOR TERM AND CONDITION DARI DEV EXTREME ----------------------------------------------------------------------
            const term_and_condition = $('#term_and_condition_htmleditor').dxHtmlEditor({
                height: "35vh",
                placeholder: "Term And Condition",
                value: @json( $quote->term_and_condition ),
                onValueChanged(e) {
                    $('#term_and_condition_textarea').html(e.value)
                },
                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        'separator',
                        {
                            name: 'header',
                            acceptedValues: [false, 1, 2, 3, 4, 5],
                        },
                        'separator',
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'separator',
                        'alignLeft',
                        'alignCenter',
                        'alignRight',
                        'alignJustify',
                        'separator',
                        'orderedList',
                        'bulletList',
                        {
                            widget: 'dxButton',
                            options: {
                                text: 'Template T&C',
                                stylingMode: 'text',
                                onClick() {
                                    popupInstance.show();
                                },
                            },
                        },
                    ],
                }
            }).dxHtmlEditor('instance');

            // MUNCULKAN EDITOR DESCRIPTION DARI DEV EXTREME ----------------------------------------------------------------------
            const description = $('#description_htmleditor').dxHtmlEditor({
                height: "35vh",
                placeholder: "Description",
                value: @json( $quote->description ),
                onValueChanged(e) {
                    $('#description_textarea').html(e.value)
                },
                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        'separator',
                        {
                            name: 'header',
                            acceptedValues: [false, 1, 2, 3, 4, 5],
                        },
                        'separator',
                        'bold',
                        'italic',
                        'strike',
                        'underline',
                        'separator',
                        'alignLeft',
                        'alignCenter',
                        'alignRight',
                        'alignJustify',
                        'separator',
                        'orderedList',
                        'bulletList'
                    ],
                }
            }).dxHtmlEditor('instance');

            $(document).ready(() => {
                $('body').append(
                    `<div id="popup">
                        <div class="value-content">
                            <div id="gridContainer"></div>
                            <div class="options">
                                <div class="option">
                                    <div id="submitButton"></div>
                                </div>
                            </div>
                        </div>
                    </div>`
                );

                // TABEL UNTUK MENAMPILKAN DATA DI DALAM POPUP EDITOR TERM_AND_CONDITION DEV EXTREME ----------------------------------------------------------------------
                let tabel = $('#gridContainer').dxDataGrid({
                    dataSource: @json( $dataTermAndConditions ),
                    keyExpr: 'id',
                    showBorders: true,
                    selection: {
                        mode: 'multiple',
                        showCheckBoxesMode: "always"
                    },
                    paging: {
                        pageSize: 10,
                    },
                    pager: {
                        visible: true,
                        allowedPageSizes: [5, 10],
                        showPageSizeSelector: true,
                        showInfo: true,
                        showNavigationButtons: true,
                    },
                    editing: {
                        mode: 'form',
                        allowUpdating: true,
                        allowAdding: true,
                        allowDeleting: true,
                        startEditAction: 'click',
                    },
                    filterRow: {
                        visible: true,
                        applyFilter: 'auto',
                    },
                    columns: [
                        {
                            dataField: 'template',
                            validationRules: [{ type: "required" }],
                            headerFilter: {
                                allowSearch: true,
                            },
                        }
                    ],
                    onSelectionChanged: selectionChanged,
                    onRowInserting: function(e) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('admin.termandcondition.create') }}",
                            data: {
                                template: e.data.template,
                            },
                            success: function(data) {
                                toastr.success(data.message);
                            }
                        });
                    },
                    onRowUpdating: function(e) {
                        $.ajax({
                            type: 'PUT',
                            url: "{{ url('admin/termandcondition/update') }}" + '/' + e.oldData.id,
                            data: {
                                id: e.oldData.id,
                                template: e.newData.template
                            },
                            success: function(data) {
                                toastr.success(data.message);
                            }
                        });
                    },
                    onRowRemoving: function(e) {
                        $.ajax({
                            type: 'DELETE',
                            url: "{{ url('admin/termandcondition/delete') }}" + '/' + e.data.id,
                            data: {
                                id: e.data.id,
                            },
                            success: function(data) {
                                toastr.success(data.message);
                            }
                        });
                    }
                }).dxDataGrid('instance');

                // BUTTON KIRIM TEMPLATE KE TERM_AND_CONDITION DI DALAM POPUP DEV EXTREME ----------------------------------------------------------------------
                $(document).on('click', '#submitButton', function() {
                    hasilMap = selectedTemplate.map((val) => {
                        return `<li data-list="ordered" style="text-align: left;">${val}</li>`;
                    });
                    $('#term_and_condition_htmleditor').find('.ql-editor').append(`<ol>${hasilMap}</ol>`);
                    $('#term_and_condition_textarea').html(
                        $('#term_and_condition_htmleditor').find('.ql-editor').html()
                    );
                });

                // BUTTON SENDDATA DI DALAM POPUP EDITOR TERM_AND_CONDITION DEV EXTREME ----------------------------------------------------------------------
                let send = $('#submitButton').dxButton({
                    stylingMode: 'contained',
                    text: 'Submit',
                    type: 'success',
                    width: 120,
                    onClick() {
                        DevExpress.ui.notify('Data Berhasil Ditambahkan');
                        $('#popup').dxPopup('hide');
                    },
                });

                // MUNCULKAN POPUP DALAM EDITOR DEV EXTREME ----------------------------------------------------------------------
                popupInstance = $('#popup').dxPopup({
                    showTitle: true,
                    title: 'Template',
                    dragEnabled: false,
                    onShowing() {
                        tabel.clearSelection();
                        $('.value-content').text(tabel.option('value'));
                    }
                }).dxPopup('instance');
            });
        });
    </script>
@endpush
