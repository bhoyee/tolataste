@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Blog')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Edit Blog')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.blog.index') }}">{{__('admin.Blog')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Edit Blog')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Blog')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.translation.blog.store') }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="language" value="{{ request('code') }}">
                            <input type="hidden" name="blog_id" value="{{ request('blog') }}">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="title" class="form-control"  name="title" value="{{ old('title', $blog->title) }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Description')}} <span class="text-danger">*</span></label>
                                    <textarea name="description" id="" cols="30" rows="10" class="summernote">{{ old('description', $blog->description) }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.SEO Title')}}</label>
                                   <input type="text" class="form-control" name="seo_title" value="{{ old('seo_title', $blog->seo_title) }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.SEO Description')}}</label>
                                    <textarea name="seo_description" id="" cols="30" rows="10" class="form-control text-area-5">{{ old('seo_description', $blog->seo_description) }}</textarea>
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
