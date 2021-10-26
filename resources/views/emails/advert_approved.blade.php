@extends('emails.base')

@section('message')

<div>
    Your advert, <strong>{{ $advert->description }}</strong> has been approved.<br>
Additionally, a new invoice with a total amount of <strong>{{ $invoice->fmt_total }}</strong> has been generated and is due on <strong>{{ $invoice->fmt_due_date }}</strong>.
@if($user->isPrePay())
Please complete payment before the due date to have your content aired<br>
@endif
Open the advert to view full information as well as print/download the invoice.
</div>

<div>
    <a href="{{ route('platform.ads.single', $advert->id) }}" style="border: none; background: orangered; color: #fff; padding: .75rem 1rem; border-radius: .3rem">View Advert</a>
</div>

@endsection
