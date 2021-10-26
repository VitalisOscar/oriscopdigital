@php

$r = request();
$category = $r->get('category');
$media = $r->get('media');
$order = $r->get('order');
$status = $r->get('status');

@endphp

<form method="GET">
    <input type="hidden" name="status" value="{{ $status }}">
    <div class="form-group">
        <label><strong>Category:</strong></label>
        <div class="clearfix">
            <select class="nice-select w-100" name="category">
                <option value="">All</option>
                @foreach(\App\Models\Category::all() as $c)
                <option value="{{ $c->id }}" @if($category == $c->id){{ __('selected') }}@endif >{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label><strong>Sort By:</strong></label>
        <div class="clearfix">
            <select class="nice-select w-100" name="order">
                <option value="recent" @if($order == 'recent'){{ __('selected') }}@endif >Most Recent</option>
                <option value="oldest" @if($order == 'oldest'){{ __('selected') }}@endif >Oldest</option>
            </select>
        </div>
    </div>

    <div class="form-group mb-4">
        <label><strong>Media:</strong></label>

        <div class="custom-control custom-checkbox mb-2">
            <input id="wv" class="custom-control-input" type="checkbox" name="media[]" value="video" @if($media == null || $media == 'video' || (is_array($media) && in_array('video', $media))){{ __('checked') }}@endif >
            <label for="wv" class="custom-control-label">
                <span>With Video</span>
            </label>
        </div>

        <div class="custom-control custom-checkbox">
            <input id="wi" class="custom-control-input" type="checkbox" name="media[]" value="image" @if($media == null || $media == 'image' || (is_array($media) && in_array('image', $media))){{ __('checked') }}@endif >
            <label for="wi" class="custom-control-label">
                <span>With Image</span>
            </label>
        </div>
    </div>

    <div>
        <button class="btn btn-block py-2 shadow-none btn-success">Apply</button>
    </div>
</form>
