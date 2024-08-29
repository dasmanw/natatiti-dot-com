<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <style>
        .btn.focus,
        .btn:focus {
            outline: 0;
            box-shadow: none !important;
        }

        .invoice-title h2,
        .invoice-title h3 {
            display: inline-block;
        }

        .table>tbody>tr>.no-line {
            border-top: none;
        }

        .table>thead>tr>.no-line {
            border-bottom: none;
        }

        .table>tbody>tr>.thick-line {
            border-top: 2px solid;
        }

        .flex-td {
            vertical-align: middle !important;
            text-align: center;
        }

        @media print {

            /* Custom print styles go here */
            body * {
                visibility: hidden;
            }

            .container,
            .container * {
                visibility: visible;
            }

            .th .td {
                font-size: 9px;
            }

            .filter-btn {
                display: none;
            }
        }
    </style>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
</head>

<body style="background-color: #fff;">
    <div class="container-fluid text-center">
        <button style="margin-top: 20px;" class="btn btn-info" onclick="window.print()">Print Preview</button>
    </div>
    <div class="container">
        <div class="d-flex" style="text-align: center; align-items: center; justify-content: center;margin-top: 20px;">
            <div class="col-l2" style="display: flex;justify-content: center;">
                <img style="width: 20%; height: auto;"
                    src="{{ asset('assets/img/logo/logo_rectangle_transparent.png') }}" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div style="display: flex; justify-content: end;">
                    <h3 style="margin: 0px;">( رقم الفاتورة )</h3>
                </div>
                <div class="invoice-title">
                    <h2>Invoice</h2>
                    <h3 class="pull-right">Order # {{ $reservation->code }}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>Salesman name: </strong>{{ $reservation->salesman->name }}<br>
                            <strong>Reserved For: </strong>{{ $reservation->name }}<br>
                            <strong>City: </strong>{{ $reservation->city->name ?? 'N/A' }}<br>
                            <strong>Address: </strong>{{ $reservation->address }}<br>
                            <strong>Phone #: </strong>{{ $reservation->phone_number }}<br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <span>( تركيب )</span><strong> Reserved From:</strong><br>
                            {{ Carbon\Carbon::parse($reservation->pickup_date_time)->format('h:i A') }}<br>
                            {{ Carbon\Carbon::parse($reservation->pickup_date_time)->format('M d, Y') }}<br>
                        </address>
                        <address>
                            <span>( شيل )</span><strong> Reserved To:</strong><br>
                            {{ Carbon\Carbon::parse($reservation->dropoff_date_time)->format('h:i A') }}<br>
                            {{ Carbon\Carbon::parse($reservation->dropoff_date_time)->format('M d, Y') }}<br>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <address>
                            <strong>Comments: </strong>{{ $reservation->comments ?? 'N/A' }}
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>Payment Method: </strong>{{ $reservation->payment_method }}<br>
                            <strong>Email: </strong>{{ $reservation->email ?? 'N/A' }}
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <span>( تاريخ الطلب )</span><strong> Order Date:</strong><br>
                            {{ Carbon\Carbon::parse($reservation->created_at)->format('M d, Y') }}<br><br>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Product Image</strong></td>
                                        <td class="text-center"><strong>Product</strong></td>
                                        <td class="text-center"><strong>Size</strong><br><strong>(length X wide X
                                                height)</strong></td>
                                        <td class="text-center"><strong>Product Code</strong></td>
                                        <td class="text-center"><strong>Unit Price</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservation->reservation_details as $reservation_detail)
                                        <tr>
                                            <td><img src="{{ $reservation_detail->product->getMedia('images')->first()?->getUrl() ?? $reservation_detail->product->image_link }}"
                                                    alt="" style="height: 100px; width: 130px;"></td>
                                            <td class="flex-td">
                                                <p>{{ $reservation_detail->product->name }}</p>
                                            </td>
                                            <td class="flex-td">
                                                <p>{{ $reservation_detail->product->length . ' X ' . $reservation_detail->product->width . ' X ' . $reservation_detail->product->height }}
                                                </p>
                                            </td>
                                            <td class="flex-td">
                                                <p>{{ $reservation_detail->product->code }}</p>
                                            </td>
                                            <td class="flex-td">
                                                <p>{{ array_key_exists(
                                                    strtolower(str_replace(' ', '_', $reservation_detail->price_type)),
                                                    json_decode($reservation_detail->product->prices, true),
                                                )
                                                    ? sprintf(
                                                            '%.3f',
                                                            json_decode($reservation_detail->product->prices, true)[
                                                                strtolower(str_replace(' ', '_', $reservation_detail->price_type))
                                                            ],
                                                        ) . ' KD'
                                                    : 'N/A' }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                        <td class="thick-line text-right">{{ $reservation->sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Discount</strong></td>
                                        <td class="no-line text-right">{{ $reservation->total_discount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Total</strong></td>
                                        <td class="no-line text-right">{{ $reservation->grand_total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
