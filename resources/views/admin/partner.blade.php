@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Partner')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Partner')}}</h1>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.update-partner-image') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                            <label for="">{{__('admin.Partner Background')}}</label>
                            <div>
                              <img src="{{ asset($setting->partner_background) }}" alt="" class="w_300">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="">{{__('admin.New Background')}}</label>
                            <input type="file" name="background_image" class="form-control-file">
                          </div>

                          <button type="submit" class="btn btn-success">{{__('admin.Update')}}</button>
                        </form>

                    </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.partner.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('admin.SN')}}</th>
                                    <th>{{__('admin.Image')}}</th>
                                    <th>{{__('admin.Status')}}</th>
                                    <th>{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($partners as $index => $partner)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>
                                          <a target="_blank" href="{{ $partner->link }}" class="partner_image">
                                            <img src="{{ asset($partner->image) }}" alt="" >
                                          </a>
                                        </td>
                                        <td>
                                          @if ($partner->status == 1)
                                          <span class="badge badge-success">{{__('admin.Active')}}</span>
                                          @else
                                          <span class="badge badge-danger">{{__('admin.Inactive')}}</span>
                                          @endif
                                        </td>
                                        <td>
                                          <a href="{{ route('admin.partner.edit',$partner->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                          <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $partner->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        $("#deleteForm").attr("action",'{{ url("admin/partner/") }}'+"/"+id)
    }
</script>
@endsection
