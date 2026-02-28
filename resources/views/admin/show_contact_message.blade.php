@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Contact Message')}}</title>
@endsection

@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Contact Message')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Contact Message')}}</div>
            </div>
        </div>

        <div class="section-body">
            <a class="btn btn-primary mb-3" href="{{ route('admin.contact-message') }}">
                <i class="fa fa-list"></i> {{__('admin.Contact Message List')}}
            </a>
            
        @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                
                
                <div class="card-header"><h4>Message Details</h4></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr><th>Name</th><td>{{ $contactMessage->name }}</td></tr>
                        <tr><th>Email</th><td>{{ $contactMessage->email }}</td></tr>
                        <tr><th>Phone</th><td>{{ $contactMessage->phone }}</td></tr>
                        <tr><th>Subject</th><td>{{ $contactMessage->subject }}</td></tr>
                        <tr><th>Message</th><td><b>{{ $contactMessage->message }}</b></td></tr>
                    </table>
                </div>
            </div>

            <hr>
            <h5>Previous Replies</h5>
            @forelse ($contactMessage->replies as $reply)
                <div class="alert alert-light border">
                    <strong>Admin:</strong><br>
                    {!! $reply->reply !!}
                    <br><small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }}</small>
                </div>
            @empty
                <p>No previous replies.</p>
            @endforelse


            <hr>
                

            <h5>Send Reply</h5>
            <form id="replyForm" action="{{ route('admin.contact-message.reply', $contactMessage->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea id="reply-editor" name="reply" class="form-control" required></textarea>
                </div>
                <button type="submit" id="replyBtn" class="btn btn-success mt-2">
                    <span id="replyBtnText">Send Reply</span>
                    <span id="replyBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </form>

        </div>
    </section>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('reply-editor');

    document.getElementById('replyForm').addEventListener('submit', function () {
        document.getElementById('replyBtn').disabled = true;
        document.getElementById('replyBtnText').textContent = 'Sending...';
        document.getElementById('replyBtnSpinner').classList.remove('d-none');
    });
</script>


@endsection
