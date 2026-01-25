@extends('backend.layouts.app')

@section('title', 'Comment Management')
@section('page_title', 'Blog Comments')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
<li class="breadcrumb-item active">Comments</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h3 class="card-title text-primary"><i class="fas fa-comments mr-2"></i>User Comments</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Commenter</th>
                        <th>Article</th>
                        <th>Comment Snippet</th>
                        <th class="text-center">Approval</th>
                        <th>Date</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle text-muted">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $comment->name }}</div>
                            <small class="text-muted"><i class="far fa-envelope mr-1"></i>{{ $comment->email }}</small>
                        </td>
                        <td class="align-middle">
                            @if($comment->blog)
                            <a href="{{ route('blog.details', $comment->blog->slug) }}" target="_blank" class="text-primary font-weight-bold">
                                {{ Str::limit($comment->blog->title, 25) }}
                            </a>
                            @else
                            <span class="badge badge-danger">Post Deleted</span>
                            @endif
                        </td>
                        <td class="align-middle text-muted small">
                            {{ Str::limit($comment->comment, 40) }}
                        </td>
                        <td class="text-center align-middle">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input toggle-approval"
                                    id="approval-{{ $comment->id }}" data-id="{{ $comment->id }}"
                                    {{ $comment->approved ? 'checked' : '' }}>
                                <label class="custom-control-label" for="approval-{{ $comment->id }}"></label>
                            </div>
                            <small class="text-xs d-block mt-1 font-weight-bold status-label-{{ $comment->id }}">
                                {{ $comment->approved ? 'APPROVED' : 'PENDING' }}
                            </small>
                        </td>
                        <td class="align-middle text-muted">{{ $comment->created_at->format('M d, Y') }}</td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-info shadow-sm view-comment"
                                    data-comment="{{ $comment->comment }}"
                                    data-name="{{ $comment->name }}"
                                    data-email="{{ $comment->email }}"
                                    data-date="{{ $comment->created_at->format('M d, Y h:i A') }}"
                                    title="Read Full Comment">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $comment->id }}" title="Delete Comment">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $comment->id }}"
                                action="{{ route('admin.blog-comments.destroy', $comment) }}"
                                method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-comment-slash fa-3x mb-3 d-block"></i>
                            No comments found yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($comments->hasPages())
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $comments->links() }}
        </div>
    </div>
    @endif
</div>

<!-- View Comment Modal -->
<div class="modal fade" id="viewCommentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-comment-alt mr-2"></i>Comment Content</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light p-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary-soft mr-3">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold" id="modal-name"></div>
                                <small class="text-muted" id="modal-email"></small>
                            </div>
                            <div class="ml-auto text-muted small" id="modal-date"></div>
                        </div>
                        <hr>
                        <p class="mb-0 text-dark italic" style="font-style: italic;" id="modal-comment"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-primary-soft {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }

    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .custom-switch .custom-control-label::before {
        height: 1.25rem;
        width: 2.25rem;
        border-radius: 1rem;
    }

    .custom-switch .custom-control-label::after {
        width: calc(1.25rem - 4px);
        height: calc(1.25rem - 4px);
        border-radius: 50%;
    }

    .custom-switch .custom-control-input:checked~.custom-control-label::after {
        transform: translateX(1rem);
    }
</style>
@endpush

@push('scripts')
<script>
    $(function() {
        // Toggle comment approval
        $('.toggle-approval').change(function() {
            var commentId = $(this).data('id');
            var isChecked = $(this).is(':checked');
            var label = $('.status-label-' + commentId);

            $.ajax({
                url: "{{ url('admin/blog-comments') }}/" + commentId + "/toggle-approval",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('Approval status updated');
                    label.text(isChecked ? 'APPROVED' : 'PENDING');
                },
                error: function() {
                    toastr.error('Failed to update status');
                    $(this).prop('checked', !isChecked);
                }
            });
        });

        // View full comment
        $('.view-comment').click(function() {
            $('#modal-name').text($(this).data('name'));
            $('#modal-email').text($(this).data('email'));
            $('#modal-date').text($(this).data('date'));
            $('#modal-comment').text($(this).data('comment'));
            $('#viewCommentModal').modal('show');
        });

        // Delete confirmation
        $('.delete-btn').click(function(e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Discard this comment?',
                text: "This removal is permanent.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + id).submit();
                }
            });
        });
    });
</script>
@endpush