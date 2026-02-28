@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Footer')}} ({{ strtoupper(request('code')) }})</title>
@endsection
@section('admin-content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Footer')}} ({{ strtoupper(request('code')) }})</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                        href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Footer')}} ({{ strtoupper(request('code')) }})</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.translation.footer.update', [
                                'code' => request('code'), 'id' => $footerTranslated->footer_id,
                            ]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>{{__('admin.About Us')}} <span class="text-danger">*</span></label>
                                        <textarea name="about_us" id="" cols="30" rows="10"
                                            class="form-control text-area-5">{{ $footerTranslated->about_us }}</textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>{{__('admin.Address')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ $footerTranslated->address }}">
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Copyright')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="copyright" class="form-control"
                                            value="{{ $footerTranslated->copyright }}">
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
