@extends('web.layouts.user_area')

@section('title', $invoice != null ? 'View Invoice':'Invoice not found')

@section('section_heading', 'View Invoice')

@section('content')

@if($invoice == null)

<div class="mb-3">
    The invoice <strong>{{ '#'.$number }}</strong> does not exist in the system
</div>

<a href="{{ route('platform.invoices.all') }}" class="btn btn-primary btn-rounded">View All Invoices</a>

@else


<div class="row">
    <div class="col-12 d-sm-none actions mb-4">
        <div>
            <a target="_blank" href="{{ route('platform.invoices.as_file', $invoice->number) }}" class="btn btn-default shadow-none mb-3 btn-block"><i class="fa fa-download mr-1"></i>Download/Print</a>
            @if($invoice->isUnpaid() && !$invoice->hasPendingPayment())
            <form action="{{ route('platform.invoices.pay', $invoice->number) }}" method="get" class="d-block mb-3">
                <button class="btn btn-primary shadow-none btn-block"><i class="fa fa-credit-card mr-1"></i>Pay Online</button>
            </form>
            {{-- <button class="btn btn-primary shadow-none btn-block" data-toggle="modal" data-target="#payment_instructions"><i class="fa fa-credit-card mr-1"></i>Payment</button> --}}
            @endif
            <a href="{{ route('platform.ads.single', $invoice->advert->id) }}" class="btn btn-outline-primary shadow-none btn-block"><i class="fa fa-bullhorn mr-1"></i>View Advert</a>

        </div>
        @if($invoice->hasPendingPayment())
        <div>
            <p class="lead mb-0">
                Payment is underway for this invoice. We will notify you once Pesapal confirms the payment status
            </p>
        </div>
        @endif
    </div>

    <div class="col-md-9 mb-3">
        @include('docs.invoice')
    </div>


    <div class="col-md-3 actions d-none d-sm-block">
        <div>
            <h4 class="font-weight-600">Actions</h4>
            <a target="_blank" href="{{ route('platform.invoices.as_file', $invoice->number) }}" class="btn btn-default shadow-none mb-3 btn-block"><i class="fa fa-print mr-1"></i>Download/Print</a>
            @if($invoice->isUnpaid() && !$invoice->hasPendingPayment())
            <form action="{{ route('platform.invoices.pay', $invoice->number) }}" method="get" class="d-block mb-3">
                <button class="btn btn-primary shadow-none btn-block"><i class="fa fa-credit-card mr-1"></i>Pay Online</button>
            </form>
            {{-- <button class="btn btn-primary shadow-none btn-block" data-toggle="modal" data-target="#payment_instructions"><i class="fa fa-credit-card mr-1"></i>Payment</button> --}}
            @endif
            <a href="{{ route('platform.ads.single', $invoice->advert->id) }}" class="btn btn-outline-primary shadow-none btn-block"><i class="fa fa-bullhorn mr-1"></i>View Advert</a>
        </div>

        @if($invoice->hasPendingPayment())
        <div>
            <p class="lead mb-0">
                Payment is underway for this invoice. We will notify you once Pesapal confirms the payment status
            </p>
        </div>
        @endif
    </div>

    <style>
        @media print{
            .logo-sm{
                display: none !important;
            }

            .actions{
                display: none;
            }

            .invoice{
                box-shadow: none !important;
                margin: 1cm !important;
            }

            @page { size: auto;  margin: 0mm; }

            .heading-title{
                display: none;
            }

            .table{
                border-color: #111 !important;
            }

            .table *{
                border-color: #111 !important;
            }
        }
    </style>

</div>


@endif
@endsection
