@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Advertisement')}} ({{ strtoupper(request('code')) }})</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Advertisement')}} ({{ strtoupper(request('code')) }})</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.advertisement') }}">{{__('admin.Advertisement')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Advertisement')}} ({{ strtoupper(request('code')) }})</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.advertisement') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Advertisement')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.translation.advertisement.update', ['code' => request('code'), 'id' => request('id')]) }}" method="POST">
                          @csrf
                          @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="title" class="form-control"  name="title" value="{{ old('title', $banner->title) }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>{{__('admin.Description')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="description" class="form-control"  name="description" value="{{ old('description', $banner->description) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Save')}}</button>
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
