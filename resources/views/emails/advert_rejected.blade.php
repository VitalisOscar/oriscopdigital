@extends('emails.base')

@section('message')

<div>
    Your advert, <strong>{{ $advert->description }}</strong> has been declined and cannot be aired because of the following:<br>
    {{ $reason }}
</div>
<br><br>
<div>
    <a href="{{ route('platform.ads.single', $advert->id) }}" style="border: none; background: orangered; color: #fff; padding: .75rem 1rem; border-radius: .3rem">View Advert</a>
</div>
<br><br>
<div>
    You can still upload new content while considering the reason.
</div>

@endsection
