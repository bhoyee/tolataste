@extends('admin.master_layout')
@section('title')
<title>{{__('admin.App Section')}} ({{ strtoupper(request('code')) }})</title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.App Section')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.app-section') }}">{{__('admin.App Section')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Translations')}} ({{ strtoupper(request('code')) }})</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.translation.settings.app.update', request('code')) }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
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
