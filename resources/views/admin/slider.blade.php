@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Slider')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Slider')}}</h1>
          </div>
          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.update-slider-image') }}" method="POST" enctype="multipart/form-data">
                          @csrf

                          <div class="form-group">
                            <label for="">{{__('admin.Slider Background')}}</label>
                            <div>
                              <img src="{{ asset($setting->slider_background) }}" alt="" class="w_300">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="">{{__('admin.New Background')}}</label>
                            <input type="file" name="background_image" class="form-control-file">
                          </div>

                          <div class="form-group">
                            <label for="">{{__('admin.Foreground Image')}}</label>
                            <div>
                              <img src="{{ asset($setting->slider_foreground_one) }}" alt="" class="category_image">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="">{{__('admin.New Image')}}</label>
                            <input type="file" name="foreground_image_one" class="form-control-file">
                          </div>

                          <div class="form-group">
                            <label for="">{{__('admin.Foreground Image')}}</label>
                            <div>
                              <img src="{{ asset($setting->slider_foreground_two) }}" alt="" class="category_image">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="">{{__('admin.New Image')}}</label>
                            <input type="file" name="foreground_image_two" class="form-control-file">
                          </div>

                          <button type="submit" class="btn btn-success">{{__('admin.Update')}}</button>
                        </form>
                    </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.slider.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('admin.Image')}}</th>
                                    <th>{{__('admin.Serial')}}</th>
                                    <th>{{__('admin.Offer')}}</th>
                                    <th>{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $index => $slider)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($slider->image) }}" width="100px" alt="">
                                        </td>
                                        <td>{{ $slider->serial }}</td>
                                        <td>{{ $slider->offer_text }}</td>

                                        <td>
                                        <a href="{{ route('admin.slider.edit',$slider->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $slider->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>

                                    </tr>
                                  @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/slider/") }}'+"/"+id)
    }
</script>
@endsection
