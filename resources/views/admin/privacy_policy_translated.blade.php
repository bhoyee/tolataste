@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Privacy Policy')}} ({{ strtoupper(request('code')) }})</title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Privacy Policy')}} ({{ strtoupper(request('code')) }})</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.privacy-policy.index') }}">{{__('admin.Privacy Policy')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Privacy Policy')}} ({{ strtoupper(request('code')) }})</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.translation.privacy-policy.store') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="language" value="{{ request('code') }}">
                                <input type="hidden" name="terms_and_condition_id"
                                    value="{{ $privacyPolicy->terms_and_condition_id }}">
                                <div class="row">

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Privacy Policy')}}<span class="text-danger">*</span></label>
                                        <textarea name="privacy_policy" cols="30" rows="10"
                                            class="summernote">{{ old('privacy_policy', $privacyPolicy->privacy_policy) }}</textarea>
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
    </section>
</div>

@endsection
