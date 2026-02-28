@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Edit Blog Category')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Edit Blog Category')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.blog-category.index') }}">{{__('admin.Blog Category')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Edit Blog Category')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.blog-category.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Blog Category')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.translation.category.store') }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="language" value="{{ request('code') }}">
                            <input type="hidden" name="category_id" value="{{ request('id') }}">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control"  name="name" value="{{ old('name', $category->name) }}">
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
