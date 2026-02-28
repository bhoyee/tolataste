@extends('admin.master_layout')
@section('title')
<title>{{__('admin.About Us')}}</title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.About Us')}}</h1>
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

                                        <li class="nav-item border rounded mb-1 p-2">
                                        <b>{{__('admin.Translations')}}</b> <br>
                                            @forelse ($languages as $language)
                                            <a class="p-1" href="{{ route('admin.translation.about-us.create', [
                                                'code' => $language->code
                                            ]) }}"><i
                                                    class="fa {{ $about_us->translation($language->code)?->first()?->about_us ? 'fa-check' : 'fa-edit' }}"></i>
                                                {{ strtoupper($language->code) }}</a>
                                            @if(!$loop->last)
                                            |
                                            @endif
                                            @empty
                                            <a href="{{ route('admin.translation.about-us.create', [
                                                'code' => app()->getLocale()
                                            ]) }}"><i
                                                    class="fa {{ $about_us->translation(app()->getLocale())->first()?->about_us ? 'fa-check' : 'fa-edit' }}"></i>
                                                {{ strtoupper(app()->getLocale()) }}</a>
                                            @endforelse
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
                                                            action="{{ route('admin.about-us.update', $about_us->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Existing Image')}}</label>
                                                                <div>
                                                                    <img src="{{ asset($about_us->about_us_image) }}"
                                                                        alt="" class="w_300">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.New Image')}}</label>
                                                                <input type="file" name="about_us_image"
                                                                    class="form-control-file">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Short title')}}</label>
                                                                <input type="text" name="about_short_title"
                                                                    class="form-control"
                                                                    value="{{ $about_us->about_us_short_title }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Long title')}}</label>
                                                                <input type="text" name="about_long_title"
                                                                    class="form-control"
                                                                    value="{{ $about_us->about_us_long_title }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.About Us')}}</label>
                                                                <textarea name="about_us" class="summernote" id=""
                                                                    cols="30"
                                                                    rows="10">{{ $about_us->about_us }}</textarea>
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
                                                            action="{{ route('admin.why-choose-us.update', $about_us->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Background Image')}}</label>
                                                                <div>
                                                                    <img src="{{ asset($about_us->why_choose_us_background) }}"
                                                                        alt="" class="why_choose_us_background">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.New Image')}}</label>
                                                                <input type="file" name="why_choose_us_background"
                                                                    class="form-control-file">
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    for="">{{__('admin.Foreground Image One')}}</label>
                                                                <div>
                                                                    <img src="{{ asset($about_us->why_choose_us_foreground_one) }}"
                                                                        alt="" class="w_300">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.New Image')}}</label>
                                                                <input type="file" name="why_choose_us_foreground_one"
                                                                    class="form-control-file">
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    for="">{{__('admin.Foreground Image Two')}}</label>
                                                                <div>
                                                                    <img src="{{ asset($about_us->why_choose_us_foreground_two) }}"
                                                                        alt="" class="w_300">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.New Image')}}</label>
                                                                <input type="file" name="why_choose_us_foreground_two"
                                                                    class="form-control-file">
                                                            </div>





                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Short title')}}</label>
                                                                <input type="text" name="why_choose_us_short_title"
                                                                    class="form-control"
                                                                    value="{{ $about_us->why_choose_us_short_title }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Long title')}}</label>
                                                                <input type="text" name="why_choose_us_long_title"
                                                                    class="form-control"
                                                                    value="{{ $about_us->why_choose_us_long_title }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Description')}}</label>
                                                                <textarea name="why_choose_us_description"
                                                                    class="summernote" id="" cols="30"
                                                                    rows="10">{{ $about_us->why_choose_us_description }}</textarea>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Title One')}}</label>
                                                                        <input type="text" name="title_one"
                                                                            class="form-control"
                                                                            value="{{ $about_us->title_one }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Icon One')}}</label>
                                                                        <input type="text" name="icon_one"
                                                                            class="form-control custom-icon-picker"
                                                                            value="{{ $about_us->icon_one }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Title Two')}}</label>
                                                                        <input type="text" name="title_two"
                                                                            class="form-control"
                                                                            value="{{ $about_us->title_two }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Icon Two')}}</label>
                                                                        <input type="text" name="icon_two"
                                                                            class="form-control custom-icon-picker"
                                                                            value="{{ $about_us->icon_two }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="">{{__('admin.Title Three')}}</label>
                                                                        <input type="text" name="title_three"
                                                                            class="form-control"
                                                                            value="{{ $about_us->title_three }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Icon Three')}}</label>
                                                                        <input type="text" name="icon_three"
                                                                            class="form-control custom-icon-picker"
                                                                            value="{{ $about_us->icon_three }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Title Four')}}</label>
                                                                        <input type="text" name="title_four"
                                                                            class="form-control"
                                                                            value="{{ $about_us->title_four }}"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Icon Four')}}</label>
                                                                        <input type="text" name="icon_four"
                                                                            class="form-control custom-icon-picker"
                                                                            value="{{ $about_us->icon_four }}"
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
                                                        <form action="{{ route('admin.video-update', $about_us->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Video Image')}}</label>
                                                                <div>
                                                                    <img src="{{ asset($about_us->video_background) }}"
                                                                        alt="" class="w_300">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.New Image')}}</label>
                                                                <input type="file" name="video_background"
                                                                    class="form-control-file">
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Existing video')}}</label>
                                                                <div>
                                                                    <iframe
                                                                        src="https://www.youtube.com/embed/{{ $about_us->video_id }}"
                                                                        allowfullscreen></iframe>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Youtube video id')}}</label>
                                                                <input type="text" name="video_id" class="form-control"
                                                                    value="{{ $about_us->video_id }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">{{__('admin.Video title')}}</label>
                                                                <input type="text" name="video_title"
                                                                    class="form-control"
                                                                    value="{{ $about_us->video_title }}">
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
