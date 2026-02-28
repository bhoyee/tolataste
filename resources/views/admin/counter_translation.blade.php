@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Edit Counter')}} ({{ strtoupper(request('code')) }})</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Edit Counter')}} ({{ strtoupper(request('code')) }})</h1>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.counter.index') }}" class="btn btn-primary"><i class="fas fa-backward"></i> {{__('admin.Go Back')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.translation.counter.update', [
                          'code' => request('code'), 'id' => request('id')
                        ]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6 mx-auto">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ $counter->title }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mx-auto">
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
