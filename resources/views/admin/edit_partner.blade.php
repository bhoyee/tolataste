@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Edit Partner')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Edit Partner')}}</h1>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.partner.index') }}" class="btn btn-primary"><i class="fas fa-backward"></i> {{__('admin.Go Back')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                              <div class="form-group col-12">
                                  <label>{{__('admin.Existing Image')}} </label>
                                  <div class="partner_image">
                                    <img src="{{ asset($partner->image) }}" alt="" >
                                  </div>
                              </div>

                              <div class="form-group col-12">
                                  <label>{{__('admin.Image')}}</label>
                                  <input type="file" name="image" class="form-control-file">
                              </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Link')}}</label>
                                    <input type="text" name="link" class="form-control" value="{{ $partner->link }}">
                                </div>

                                <div class="form-group col-12">
                                  <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                  <select name="status" class="form-control">
                                      <option {{ $partner->status == 1 ? 'selected' : '' }} value="1">{{__('admin.Active')}}</option>
                                      <option {{ $partner->status == 0 ? 'selected' : '' }} value="0">{{__('admin.Inactive')}}</option>
                                  </select>
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
