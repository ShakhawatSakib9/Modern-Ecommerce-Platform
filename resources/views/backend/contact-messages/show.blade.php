@extends('backend.layouts.app')

@section('title', 'View Message')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>View Message</h4>
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $message->subject ?? 'No Subject' }}</h5>
                <span class="text-muted">{{ $message->created_at->format('M d, Y H:i') }}</span>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6><strong>From:</strong> {{ $message->name }} ({{ $message->email }})</h6>
                </div>
                <hr>
                <div class="message-content py-3">
                    {!! nl2br(e($message->message)) !!}
                </div>
            </div>
            <div class="card-footer text-end">
                <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?')">
                        <i class="fas fa-trash"></i> Delete Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contact-messages.toggle-read', $message->id) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-{{ $message->is_read ? 'warning' : 'success' }} w-100">
                        <i class="fas fa-{{ $message->is_read ? 'envelope' : 'envelope-open' }}"></i>
                        Mark as {{ $message->is_read ? 'Unread' : 'Read' }}
                    </button>
                </form>

                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-primary w-100">
                    <i class="fas fa-reply"></i> Reply via Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection