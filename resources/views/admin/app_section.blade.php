@extends('admin.master_layout')
@section('title')
<title>{{__('admin.App Section')}}</title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.App Section')}}</h1>
        </div>
        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.update-app-section') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between">
                                        <div>
                                            <div class="form-group">
                                                <label>{{__('admin.Existing Image')}}</label>
                                                <div>
                                                    <img src="{{ asset($app_section->app_image) }}" alt=""
                                                        width="200px">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <b class="text-right">{{__('admin.Translations')}}</b> <br>
                                            @forelse ($languages as $language)
                                            <a href="{{ route('admin.translation.settings.app.create', [
                                          'code' => $language->code
                                      ]) }}"><i class="fa {{ $app_section->translation($language->code)?->first()?->app_title ? 'fa-check' : 'fa-edit' }}"></i>
                                                {{ strtoupper($language->code) }}</a>
                                            @if(!$loop->last)
                                            |
                                            @endif
                                            @empty
                                            <a href="{{ route('admin.translation.settings.app.create', [
                                          'code' => app()->getLocale()
                                      ]) }}"><i class="fa {{ $app_section->translation(app()->getLocale())->first()?->app_title ? 'fa-check' : 'fa-edit' }}"></i>
                                                {{ strtoupper(app()->getLocale()) }}</a>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.New Image')}}</label>
                                        <input type="file" name="image" class="form-control-file">
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Background Image One')}}</label>
                                        <div>
                                            <img src="{{ asset($app_section->app_background_one) }}" alt=""
                                                class="w_300">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.New Image')}}</label>
                                        <input type="file" name="app_background_one" class="form-control-file">
                                    </div>

                                    <div class="form-group col-12 d-none">
                                        <label>{{__('admin.Background Image Two')}}</label>
                                        <div>
                                            <img src="{{ asset($app_section->app_background_two) }}" alt=""
                                                class="w_300">
                                        </div>
                                    </div>

                                    <div class="form-group col-12 d-none">
                                        <label>{{__('admin.New Image')}}</label>
                                        <input type="file" name="app_background_two" class="form-control-file">
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Title')}}</label>
                                        <input type="text" name="app_title" class="form-control"
                                            value="{{ $app_section->app_title }}">
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Description')}}</label>
                                        <textarea name="app_description" id="" class="form-control text-area-5"
                                            cols="30" rows="10">{{ $app_section->app_description }}</textarea>
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Play store link')}}</label>
                                        <input type="text" name="play_store_link" class="form-control"
                                            value="{{ $app_section->play_store_link }}">
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.App store link')}}</label>
                                        <input type="text" name="app_store_link" class="form-control"
                                            value="{{ $app_section->app_store_link }}">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-primary">{{__('admin.Update')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
