<?php $client = $invoice->advert->user; ?>

{{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
<link href="{{ asset('css/argon-design-system.min.css') }}" rel="stylesheet">
<link href= "{{ asset('css/main.css') }}" rel="stylesheet">

<style>
    @media print{

        body{
            background: #fff !important;
        }

        .actions, .sidebar, .header{
            display: none !important;
        }

        .main-content{
            margin-left: 0;
        }

        .invoice{
            box-shadow: none !important;
            margin: 1cm !important;
        }

        @page { size: auto;  margin: 0mm }

        .heading-title{
            display: none;
        }

        .table{
            border-color: #111 !important;
        }

        .table td{
            border: 1px solid #111 !important;
            border-collapse: collapse;
        }
    }
</style>

<div class="bg-white p-4 shadow-sm invoice">

    <table class="mb-4">

        <tr>
            <td>
                <div class="mr-4">
                    <img src="{{ asset('img/logo.png') }}" style="height: 110px">
                </div>
            </td>

            <td>
                <div>
                    <h3 class="font-weight-500" style="line-height: 1.2">
                        <strong style="color: #111">Oriscop Solutions</strong>
                    </h3>
                    <div>Imara Daima, Mombasa road, Nairobi</div>
                    <div><strong>Email:&nbsp;</strong>info@oriscop.com</div>
                    <div><strong>Tel:&nbsp;</strong>0710 338 211</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="mb-5">
        <h5>BILLED TO</h5>

        <table>
            <tr>
                <td>
                    <div>
                        <table>
                            <tr>
                                <td class="pr-5"><strong>Client Name:</strong></td>
                                <td>{{ $client->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $client->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{{ $client->operator_phone }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="mb-2">
        <div class="">

            <div>
                <h3 class="font-weight-500" style="line-height: 1.2">Proforma Invoice</h3>

                <table style="width: 100%">
                    <tr>
                        <td style="width: 33.33%; vertical-align: top">
                            <h5 class="mb-0">Invoice Number</h5>
                            <div>{{ '# '.$invoice->number }}</div>
                        </td>

                        <td style="width: 33.33%; vertical-align: top">
                            <h5 class="mb-0">Date Generated</h5>
                            <div><strong>{{ $invoice->fmt_date }}</strong></div>
                        </td>

                        <td style="width: 33.33%; vertical-align: top">
                            <h5 class="mb-0">Invoice Status</h5>
                            <div>
                                <strong>
                                @if($invoice->isPaid())
                                <span class="text-success">PAID</span> - {{ $invoice->payment->method }}
                                @elseif($invoice->isUnpaid())
                                <span class="text-danger">UNPAID</span>
                                @else
                                <span class="text-primary">PAYMENT UNDERWAY</span>
                                @endif
                                </strong>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="my-4 d-inline-block px-5 bg-success sep" style="height: 5px; background: #373737; border-radius: 0 3px 3px 0"></div>

            <div>
                <h4 class="font-weight-500">Booking Information</h4>
                <div>
                    {{ $invoice->advert->description }}
                </div>
            </div>

            <div class="mt-4 table-responsive">

                <table class="table table-sm">
                    <tr style="border-bottom: 1px solid #111">
                        <th class="border text-center">#</th>
                        <th class="border">Screen</th>
                        <th class="border">Package</th>
                        <th class="border">Dates</th>
                        <th class="border border-dark">Price (Total)</th>
                    </tr>

                    <?php $i = 1; ?>

                    @foreach($invoice->advert->bookings as $booking)
                    <tr style="border-bottom: 1px solid #111">
                        <td class="text-center">{{ $i }}</td>
                        <td class="">{{ $booking->screen->name }}</td>
                        <td class="">{{ $booking->package->summary }}</td>
                        <td class="text-center">{{ $booking->total_dates }}</td>
                        <td>{{ $booking->fmt_price }}</td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </table>

            </div>

        </div>
    </div>
    <table style="width:100%">
        <tr>
            <td style="width:100%"></td>
            <td class="text-right w-auto">


                <table style="font-size: 1.15em" class="text-right">
                    <tr>
                        <th class="pr-4">Sub&nbsp;Total:</th>
                        <td class="text-left"><span>{!! $invoice->fmt_sub_total !!}</span></td>
                    </tr>

                    <tr>
                        <th class="pr-4">{!! str_replace(" ", "&nbsp;", $invoice->fmt_tax_rate) !!}:</th>
                        <td class="text-left"><span>{!! str_replace(" ", "&nbsp;", $invoice->fmt_tax) !!}</span></td>
                    </tr>

                    <tr>
                        <th class="pr-4">Total:</th>
                        <td class="text-left"><span>{!! str_replace(" ", "&nbsp;", $invoice->fmt_total) !!}</span></td>
                    </tr>

                    <tr>
                        <th class="pr-4">Due&nbsp;Date:</th>
                        <td class="text-left"><span>{!! str_replace(" ", "&nbsp;", $invoice->fmt_due_date) !!}</span></td>
                    </tr>
                </table>


            </td>
        </tr>
    </table>

</div>
