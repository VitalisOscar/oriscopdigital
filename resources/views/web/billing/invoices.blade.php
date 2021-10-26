@extends('web.layouts.user_area')

@section('title', 'Your Invoices')

@section('section_heading', 'Your Invoices')

@section('content')

<style>
    .input-group-alternative{
        box-shadow: none;
        border: 1px solid #ccc;
    }
</style>

<div class="row">

    <div class="col-lg-8 pr-lg-4">

        <div class="d-lg-none mb-3">
            <div class="">
                <button type="button" data-toggle="modal" data-target="#filters-sm" class="btn btn-outline-success shadow-none py-2 mb-3"><i class="fa fa-filter mr-1"></i>Filter Results</button>
            </div>
            <div class="modal fade" id="filters-sm">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content p-0">
                        <div class="modal-body p-0">
                            @include('web.billing._invoice_filter_form')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-md-none">

            @foreach($result->items as $invoice)
            <div class="col-sm-6">
                <a href="{{ route('platform.invoices.single', $invoice->number) }}" class="text-body d-flex align-items-center mb-3 p-3 border rounded bg-white d-flex">
                    <img style="height: 35px" src="{{ asset('img/icons/invoice.svg') }}" alt="">

                    <div class="ml-3">
                        <h6><strong>#{{ $invoice->number }}</strong></h6>

                        <div>
                            <div class="mb-1">
                                <strong>
                                    {{ $invoice->fmt_total }} -
                                    @if($invoice->isPaid())
                                    <span class="text-success">Paid</span>
                                    @elseif($invoice->isPending())
                                    <span class="text-info">Underway</span>
                                    @else
                                    <span class="text-danger">Unpaid</span>
                                    @endif
                                </strong>
                            </div>

                            <div>
                                <small>
                                    <i class="fa fa-calendar mr-1"></i>
                                    {{ $invoice->time }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <span class="ml-auto mr-1 float-right">
                        <i class="fa fa-chevron-right text-muted"></i>
                    </span>
                </a>
            </div>
            @endforeach

            <div class="col-12">
                <div class="d-flex align-items-center">
                    <a @if($result->hasPreviousPage()) href="{{ $result->prevPageUrl() }}" @endif class="mr-auto btn btn-link px-2 py-1"><i class="mr-1 fa fa-angle-double-left"></i> Prev</a>
                    <span>Page {{ $result->page }} of {{ $result->max_pages }}</span>
                    <a @if($result->hasNextPage()) href="{{ $result->nextPageUrl() }}" @endif class="ml-auto btn btn-link px-2 py-1">Next<i class="ml-1 fa fa-angle-double-right"></i></a>
                </div>
            </div>
        </div>

        <div class="table-responsive rounded bg-white border d-none d-md-block">
            <table class="table border-0 mb-0">
                <tr class="bg-lighter">
                    <th>Invoice No</th>
                    <th>Created</th>
                    <th>Amount (KSh)</th>
                    <th>Status</th>
                    <th></th>
                </tr>

                @if($result->isEmpty())
                <tr>
                    <td colspan="5">
                        No invoices found. All your invoices will be listed here
                    </td>
                </tr>
                @else

                @foreach($result->items as $invoice)
                <tr>
                    <td class="text-center">
                        <a href="{{ route('platform.invoices.single', $invoice->number) }}">{{ $invoice->number }}</a>
                    </td>
                    <td>{{ $invoice->fmt_date }}</td>
                    <td>{{ $invoice->fmt_total }}</td>
                    <td>
                        @if($invoice->isPaid())
                        <span class="text-success">Paid</span>
                        @elseif($invoice->isPending())
                        <span class="text-primary">Payment Underway</span>
                        @else
                        <span class="text-danger">Unpaid</span>
                        @endif
                    </td>
                    <th>
                        <a href="{{ route('platform.invoices.single', $invoice->number) }}" class="btn btn-dark btn-sm">View</a>
                    </th>
                </tr>
                @endforeach

                <tr>
                    <td colspan="5">
                        <div class="d-flex align-items-center">
                            <a @if($result->hasPreviousPage()) href="{{ $result->prevPageUrl() }}" @endif class="mr-auto btn btn-link px-2 py-1"><i class="mr-1 fa fa-angle-double-left"></i> Prev</a>
                            <span>Page {{ $result->page }} of {{ $result->max_pages }}</span>
                            <a @if($result->hasNextPage()) href="{{ $result->nextPageUrl() }}" @endif class="ml-auto btn btn-link px-2 py-1">Next<i class="ml-1 fa fa-angle-double-right"></i></a>
                        </div>
                    </td>
                </tr>
                @endif
            </table>
        </div>

    </div>

    <div class="col-sm-5 col-lg-4 d-none d-lg-block">

        @include('web.billing._invoice_filter_form')

    </div>

</div>

@endsection
