@extends('backend.layouts.app')

@section('title', 'Contact Messages')
@section('page_title', 'Inquiry Messages')

@section('breadcrumb')
<li class="breadcrumb-item active">Contact Messages</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-envelope mr-2"></i>Customer Inquiries</h3>
        <div class="card-tools ml-auto"></div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" width="50">#</th>
                        <th>Sender Info</th>
                        <th>Subject</th>
                        <th class="text-center" width="100">Status</th>
                        <th width="150">Received Date</th>
                        <th class="text-center pr-4" width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr class="{{ !$message->is_read ? 'bg-light font-weight-bold' : '' }} align-middle">
                        <td class="pl-4 align-middle">
                            {{ $loop->iteration + ($messages->currentPage() - 1) * $messages->perPage() }}
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $message->name }}</div>
                            <small class="text-muted"><i class="fas fa-at mr-1"></i>{{ $message->email }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="text-truncate" style="max-width: 250px;">{{ $message->subject ?? 'No Subject' }}</div>
                        </td>
                        <td class="text-center align-middle">
                            @if(!$message->is_read)
                            <span class="badge badge-primary shadow-sm"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i> New</span>
                            @else
                            <span class="badge badge-light text-muted">Read</span>
                            @endif
                        </td>
                        <td class="align-middle text-muted">{{ $message->created_at->diffForHumans() }}</td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('admin.contact-messages.show', $message->id) }}"
                                    class="btn btn-sm btn-info" title="View Message">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contact-messages.toggle-read', $message->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-secondary" title="{{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}">
                                        <i class="fas fa-{{ $message->is_read ? 'envelope' : 'envelope-open' }}"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $message->id }}" title="Delete inquiry">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $message->id }}"
                                action="{{ route('admin.contact-messages.destroy', $message->id) }}"
                                method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            No inquiry messages found in your inbox.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($messages->hasPages())
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $messages->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this message?')) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>
@endpush