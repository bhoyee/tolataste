@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Create Partner')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Create Partner')}}</h1>
          </div>
          <div class="section-body">
            <a href="{{ route('admin.partner.index') }}" class="btn btn-primary"><i class="fas fa-backward"></i> {{__('admin.Go Back')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.partner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                              <div class="form-group col-12">
                                  <label>{{__('admin.Image')}} <span class="text-danger">*</span></label>
                                  <input type="file" name="image" class="form-control-file">
                              </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Link')}}</label>
                                    <input type="text" name="link" class="form-control">
                                </div>

                                <div class="form-group col-12">
                                  <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                  <select name="status" class="form-control">
                                      <option value="1">{{__('admin.Active')}}</option>
                                      <option value="0">{{__('admin.Inactive')}}</option>
                                  </select>
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
