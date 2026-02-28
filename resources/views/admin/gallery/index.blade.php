@extends('admin.master_layout')

@section('title')
    <title>Manage Gallery</title>
@endsection

@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manage Gallery</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form id="uploadForm" action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select Image (Max: 2MB)</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <button id="uploadBtn" type="submit" class="btn btn-primary mt-2">
                        <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                        Upload
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Image</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($galleryImages as $image)
                            <tr>
                                <td>
                                    <img src="{{ url('uploads/gallery/' . $image->image_path) }}" alt="Gallery Image" style="max-width: 200px;" class="img-thumbnail">
                                </td>
                                <td>
                                    <form action="{{ route('admin.gallery.delete', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="box-shadow: 0 2px 6px rgba(255, 0, 0, 0.4);">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2">No images found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    // Spinner handling
    document.getElementById('uploadForm').addEventListener('submit', function () {
        document.getElementById('uploadBtn').disabled = true;
        document.getElementById('spinner').classList.remove('d-none');
    });
</script>
@endpush
