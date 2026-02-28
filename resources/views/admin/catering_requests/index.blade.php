@extends('admin.master_layout')

@section('title')
    <title>{{ __('admin.Catering Requests') }}</title>
@endsection

@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Catering Requests') }}</h1>
        </div>

        <div class="card-body table-responsive">
            <table id="cateringTable" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date of Event</th>
                        <th>Service Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $index => $req)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $req->full_name }}</td>
                        <td>{{ $req->email }}</td>
                        <td>{{ $req->phone }}</td>
                        <td>{{ $req->event_date }}</td>
                        <td>{{ $req->catering_type }}</td>
                        <td>
                            <a href="{{ route('admin.catering.show', $req->id) }}" class="btn btn-sm btn-primary mb-1">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#cateringTable').DataTable({
            responsive: true,
            order: [[ 4, 'desc' ]],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search requests..."
            }
        });
    });
</script>
@endsection
