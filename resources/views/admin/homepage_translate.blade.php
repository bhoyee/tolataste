@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Homepage')}} {{__('admin.Translations')}} ({{ strtoupper(request('code')) }})</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Homepage')}} ({{ strtoupper(request('code')) }})</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.homepage') }}">{{__('admin.Homepage')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Homepage')}} ({{ strtoupper(request('code')) }})</div>
            </div>
          </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.translation.homepage.update', request('code')) }}" method="post">
                                @csrf
                                @method('PUT')
                                <h5>{{__('admin.Today Special')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">{{__('admin.Short Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->today_special_short_title }}" name="today_special_short_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Long Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->today_special_long_title }}" name="today_special_long_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Description')}}</label>
                                            <textarea name="today_special_description" class="form-control text-area-3" id="" cols="30" rows="10">{{ $homepage->today_special_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h5>{{__('admin.Menu Section')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">{{__('admin.Short Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->menu_short_title }}" name="menu_short_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Long Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->menu_long_title }}" name="menu_long_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Description')}}</label>
                                            <textarea name="menu_description" class="form-control text-area-3" id="" cols="30" rows="10">{{ $homepage->menu_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h5>{{__('admin.Our Chef')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">{{__('admin.Short Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->chef_short_title }}" name="chef_short_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Long Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->chef_long_title }}" name="chef_long_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Description')}}</label>
                                            <textarea name="chef_description" class="form-control text-area-3" id="" cols="30" rows="10">{{ $homepage->chef_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h5>{{__('admin.Testimonial')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12">

                                        <div class="form-group">
                                            <label for="">{{__('admin.Short Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->testimonial_short_title }}" name="testimonial_short_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Long Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->testimonial_long_title }}" name="testimonial_long_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Description')}}</label>
                                            <textarea name="testimonial_description" class="form-control text-area-3" id="" cols="30" rows="10">{{ $homepage->testimonial_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h5>{{__('admin.Blog')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">{{__('admin.Short Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->blog_short_title }}" name="blog_short_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Long Title')}}</label>
                                            <input type="text" class="form-control" value="{{ $homepage->blog_long_title }}" name="blog_long_title">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Description')}}</label>
                                            <textarea name="blog_description" class="form-control text-area-3" id="" cols="30" rows="10">{{ $homepage->blog_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{__('admin.Update')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
      </div>

@endsection
