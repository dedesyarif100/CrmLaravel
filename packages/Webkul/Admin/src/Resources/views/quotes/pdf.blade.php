<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

        <style type="text/css">
            * {
                font-family: DejaVu Sans;
            }
            body {
                margin-top: 2cm;
                margin-left: 0;
                margin-right: 0;
                margin-bottom: 2cm;
            }
            body, th, td, h5 {
                font-size: 12px;
                color: #000;
            }

            .container {
                padding: 0px;
                margin: 0;
                display: block;
                /* background-color: yellow; */
                /* padding-top: 40px; */
            }

            .quote-summary {
                margin-bottom: 20px;
            }

            .table {
                margin-top: 20px;
            }

            .table table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
            }

            .table thead th {
                font-weight: 700;
                border-top: solid 1px #d3d3d3;
                border-bottom: solid 1px #d3d3d3;
                border-left: solid 1px #d3d3d3;
                padding: 5px 10px;
                background: #F4F4F4;
            }

            .table thead th:last-child {
                border-right: solid 1px #d3d3d3;
            }

            .table tbody td {
                padding: 5px 10px;
                border-bottom: solid 1px #d3d3d3;
                border-left: solid 1px #d3d3d3;
                color: #3A3A3A;
                vertical-align: middle;
            }

            .table tbody td p {
                margin: 0;
            }

            .table tbody td:last-child {
                border-right: solid 1px #d3d3d3;
            }

           .sale-summary {
                margin-top: 40px;
                float: right;
            }

            .sale-summary tr td {
                padding: 3px 5px;
            }

            .sale-summary tr.bold {
                font-weight: 600;
            }

            .label {
                color: #000;
                font-weight: bold;
            }

            .logo {
                height: 70px;
                width: 70px;
            }

            .text-center {
                text-align: center;
            }

            @page {
                margin-top: 100px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: -50px;
                left: 0cm;
                right: 0cm;
                height: 3cm;
                /* background-color: red; */
                border-bottom: 5px solid #af974f;
                /* padding-bottom: 10px; */
                /* opacity: 0.7; */
            }

            /** Define the footer rules **/
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
            }

            .row {
                content: "";
                /* display: table; */
                /* clear: both; */
            }

            .col {
                float: left;
                width: 70%;
                padding: 10px;
                font-size: 10px;
            }
            img {
                width: 50%;
            }
        </style>
    </head>

    <body style="background-image: none; background-color: #fff;">

        <header>
            <div class="justify-conten-center">
                <div class="row">
                    <div class="col">
                        <img src="{{ public_path('storage/logo/monster-logo.png') }}"/>
                    </div>
                    <div class="col">
                        <strong>MONSTER GROUP INDONESIA</strong> <br>
                        Surabaya Branch
                        <i class="fa fa-phone-alt"></i> <br>
                        +6231 8785 8782 <br>
                        Jl. Wonorejo Permai Utara V No. 2 <br>
                        Surabaya - East Java <br>
                        Indonesia 60269
                    </div>
                </div>
            </div>
        </header>
        {{-- <hr style="border: 1px solid black;"> --}}


        {{-- <footer>
            Copyright 2021
        </footer> --}}

        <div class="container">
            <div class="header">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center">{{ __('admin::app.quotes.quote') }}</h1>
                    </div>
                </div>
                {{-- @dd( public_path('storage/logo/monster-logo.png') ) --}}
                <div class="image">
                    {{-- <img class="logo" src="{{ Storage::url(core()->getConfigData('sales.orderSettings.quote_slip_design.logo')) }}"/> --}}
                </div>
            </div>

            <div class="quote-summary">
                <div class="row">
                    <span class="label">{{ __('admin::app.quotes.quote-id') }} -</span>
                    <span class="value">#{{ $quote->id }}</span>
                </div>

                <div class="row">
                    <span class="label">{{ __('admin::app.quotes.quote-date') }} -</span>
                    <span class="value">{{ $quote->created_at->format('d-m-Y') }}</span>
                </div>

                <div class="row">
                    <span class="label">{{ __('admin::app.quotes.valid-until') }} -</span>
                    <span class="value">{{ $quote->expired_at->format('d-m-Y') }}</span>
                </div>

                <div class="row">
                    <span class="label">{{ __('admin::app.quotes.sales-person') }} -</span>
                    <span class="value">{{ $quote->user->name }}</span>
                </div>

                <div class="table address">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50%">{{ __('admin::app.quotes.bill-to') }}</th>

                                @if ($quote->shipping_address)
                                    <th>{{ __('admin::app.quotes.ship-to') }}</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @if ($quote->billing_address)
                                    <td>
                                        <p>{{ $quote->billing_address['address'] }}</p>
                                        <p>{{ $quote->billing_address['postcode'] . ' ' .$quote->billing_address['city'] }} </p>
                                        <p>{{ $quote->billing_address['state'] }}</p>
                                        <p>{{ core()->country_name($quote->billing_address['country']) }}</p>
                                    </td>
                                @endif

                                @if ($quote->shipping_address)
                                    <td>
                                        <p>{{ $quote->shipping_address['address'] }}</p>
                                        <p>{{ $quote->shipping_address['postcode'] . ' ' .$quote->shipping_address['city'] }} </p>
                                        <p>{{ $quote->shipping_address['state'] }}</p>
                                        {{-- @dd( $quote->shipping_address['country']  ) --}}
                                        <p>{{ core()->country_name($quote->shipping_address['country']) }}</p>
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table items">
                    <table>
                        <thead>
                            <tr>
                                <th>{{ __('admin::app.quotes.sku') }}</th>

                                <th>{{ __('admin::app.quotes.product-name') }}</th>

                                {{-- <th>{{ __('admin::app.quotes.description') }}</th> --}}

                                <th class="text-center">{{ __('admin::app.quotes.price') }}</th>

                                <th class="text-center">{{ __('admin::app.quotes.quantity') }}</th>

                                <th class="text-center">{{ __('admin::app.quotes.amount') }}</th>

                                <th class="text-center">{{ __('admin::app.quotes.discount') }}</th>

                                <th class="text-center">{{ __('admin::app.quotes.tax') }}</th>

                                <th class="text-center">{{ __('admin::app.quotes.grand-total') }}</th>
                            </tr>
                        </thead>

                        {{-- <tbody>
                            @foreach ($quote->items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>

                                    <td>
                                        {{ $item->name }}
                                    </td>

                                    <td>{{ $quote->description }}</td>

                                    <td>{!! core()->formatBasePrice($item->price, true) !!}</td>

                                    <td class="text-center">{{ $item->quantity }}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->total, true) !!}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->discount_amount, true) !!}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->tax_amount, true) !!}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->total + $item->tax_amount, true) !!}</td>
                                </tr>
                            @endforeach
                        </tbody> --}}
                        <tbody>
                            @foreach ($quote->items as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ number_format($item->price, 2, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->total, 2, ',', '.') }}</td>
                                    <td>{{ number_format($item->discount_amount, 2, ',', '.') }}</td>
                                    <td>{{ number_format($item->tax_amount, 2, ',', '.') }}</td>
                                    <td>{{ number_format($item->total + $item->tax_amount, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table items">
                    <table>
                        <thead>
                            <tr>
                                <th>{{ __('admin::app.quotes.description') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{!! $quote->description !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table items">
                    <table>
                        <thead>
                            <tr>
                                <th>Term And Condition</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{!! $quote->term_and_condition !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <table class="sale-summary">
                    <tr>
                        <td>{{ __('admin::app.quotes.sub-total') }}</td>
                        <td>-</td>
                        <td>{!! core()->formatBasePrice($quote->sub_total, true) !!}</td>
                    </tr>

                    <tr>
                        <td>{{ __('admin::app.quotes.tax') }}</td>
                        <td>-</td>
                        <td>{!! core()->formatBasePrice($quote->tax_amount, true) !!}</td>
                    </tr>

                    <tr>
                        <td>{{ __('admin::app.quotes.discount') }}</td>
                        <td>-</td>
                        <td>{!! core()->formatBasePrice($quote->discount_amount, true) !!}</td>
                    </tr>

                    <tr>
                        <td>{{ __('admin::app.quotes.adjustment') }}</td>
                        <td>-</td>
                        <td>{!! core()->formatBasePrice($quote->adjustment_amount, true) !!}</td>
                    </tr>

                    <tr>
                        <td><strong>{{ __('admin::app.quotes.grand-total') }}</strong></td>
                        <td><strong>-</strong></td>
                        <td><strong>{!! core()->formatBasePrice($quote->grand_total, true) !!}</strong></td>
                    </tr>
                </table>

            </div>

        </div>
    </body>
</html>
