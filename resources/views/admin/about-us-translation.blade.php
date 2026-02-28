@extends('admin.master_layout')
@section('title')
<title>{{__('admin.About Us Translation')}}</title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.About Us Translation')}} ({{ strtoupper(request('code')) }})</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.about-us.index') }}">{{__('admin.About Us')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.About Us Translation')}} ({{ strtoupper(request('code')) }})</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link active" id="paypal-tab" data-toggle="tab"
                                                href="#paypalTab" role="tab" aria-controls="paypalTab"
                                                aria-selected="true">{{__('admin.About Us')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="stripe-tab" data-toggle="tab" href="#stripeTab"
                                                role="tab" aria-controls="stripeTab"
                                                aria-selected="true">{{__('admin.Why Choose Us')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="video-tab" data-toggle="tab" href="#videoTab"
                                                role="tab" aria-controls="videoTab"
                                                aria-selected="true">{{__('admin.Video')}}</a>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-12 col-sm-12 col-md-9">
                                    <div class="border rounded">
                                        <div class="tab-content no-padding" id="settingsContent">

                                            <div class="tab-pane fade show active" id="paypalTab" role="tabpanel"
                                                aria-labelledby="paypal-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form
                                                            action="{{ route('admin.translation.about-us.store') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="language" value="{{ request('code') }}">
                                                            <input type="hidden" name="about_us_id" value="{{ $about_us->about_us_id }}">
                                                            <input type="hidden" name="update_type" value="aboutUs">
                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Short title')}}</label>
                                                                <input type="text" name="about_us_short_title"
                                                                    class="form-control"
                                                                    value="{{ old('about_us_short_title', $about_us->about_us_short_title) }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Long title')}}</label>
                                                                <input type="text" name="about_us_long_title"
                                                                    class="form-control"
                                                                    value="{{ old('about_us_long_title', $about_us->about_us_long_title) }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.About Us')}}</label>
                                                                <textarea name="about_us" class="summernote" id=""
                                                                    cols="30"
                                                                    rows="10">{{ old('about_us', $about_us->about_us) }}</textarea>
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-primary">{{__('admin.Update')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="stripeTab" role="tabpanel"
                                                aria-labelledby="stripe-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form
                                                            action="{{ route('admin.translation.about-us.store') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="language" value="{{ request('code') }}">
                                                            <input type="hidden" name="about_us_id" value="{{ $about_us->about_us_id }}">
                                                            <input type="hidden" name="update_type" value="whyChooseUs">

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Short title')}}</label>
                                                                <input type="text" name="why_choose_us_short_title"
                                                                    class="form-control"
                                                                    value="{{ old('why_choose_us_short_title', $about_us->why_choose_us_short_title) }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Long title')}}</label>
                                                                <input type="text" name="why_choose_us_long_title"
                                                                    class="form-control"
                                                                    value="{{ old('why_choose_us_long_title', $about_us->why_choose_us_long_title) }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Description')}}</label>
                                                                <textarea name="why_choose_us_description"
                                                                    class="summernote" id="" cols="30"
                                                                    rows="10">{{ old('why_choose_us_description', $about_us->why_choose_us_description) }}</textarea>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Title One')}}</label>
                                                                        <input type="text" name="title_one"
                                                                            class="form-control"
                                                                            value="{{ old('title_one', $about_us->title_one) }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Title Two')}}</label>
                                                                        <input type="text" name="title_two"
                                                                            class="form-control"
                                                                            value="{{ old('title_two', $about_us->title_two) }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="">{{__('admin.Title Three')}}</label>
                                                                        <input type="text" name="title_three"
                                                                            class="form-control"
                                                                            value="{{ old('title_three', $about_us->title_three) }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Title Four')}}</label>
                                                                        <input type="text" name="title_four"
                                                                            class="form-control"
                                                                            value="{{ old('title_four', $about_us->title_four) }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-primary">{{__('admin.Update')}}</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="videoTab" role="tabpanel"
                                                aria-labelledby="video-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('admin.translation.about-us.store') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="language" value="{{ request('code') }}">
                                                            <input type="hidden" name="about_us_id" value="{{ $about_us->about_us_id }}">
                                                            <input type="hidden" name="update_type" value="video">
                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Video title')}}</label>
                                                                <input type="text" name="video_title"
                                                                    class="form-control"
                                                                    value="{{ old('video_title', $about_us->video_title) }}">
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-primary">{{__('admin.Update')}}</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection
