@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Terms And Conditions')}} ({{ request('code') }})</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Terms And Conditions')}} ({{ strtoupper(request('code')) }})</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.terms-and-condition.index') }}">{{__('admin.Terms And Conditions')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Terms And Conditions')}} ({{ strtoupper(request('code')) }})</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.translation.terms-and-condition.store') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="language" value="{{ request('code') }}">
                            <input type="hidden" name="terms_and_condition_id" value="{{ $termsAndCondition->terms_and_condition_id }}">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Terms And Conditions')}}<span class="text-danger">*</span></label>
                                    <textarea name="terms_and_condition" cols="30" rows="10" class="summernote">{{ old('terms_and_condition', $termsAndCondition->terms_and_condition) }}</textarea>
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
