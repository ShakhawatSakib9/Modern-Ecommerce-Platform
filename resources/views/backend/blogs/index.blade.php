@extends('backend.layouts.app')

@section('title', 'Blog Management')
@section('page_title', 'Blog Posts')

@section('breadcrumb')
<li class="breadcrumb-item active">Blog Posts</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-newspaper mr-2"></i>Published Articles</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> New Blog Post
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Preview</th>
                        <th>Article Details</th>
                        <th>Category</th>
                        <th class="text-center">Stats</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle text-muted">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            @if($blog->image)
                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"
                                class="rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover; border: 1px solid #eee;">
                            @else
                            <div class="rounded shadow-sm bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 50px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold mb-1">{{ Str::limit($blog->title, 40) }}</div>
                            <small class="text-muted d-block">
                                <i class="far fa-user mr-1"></i> {{ $blog->author ?? 'Admin' }}
                                <span class="mx-1">|</span>
                                <i class="far fa-calendar-alt mr-1"></i> {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Draft' }}
                            </small>
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-info-soft text-info">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="d-flex flex-column align-items-center">
                                <span class="text-xs font-weight-bold text-dark"><i class="far fa-eye mr-1"></i>{{ $blog->views }}</span>
                                <span class="badge badge-{{ $blog->featured ? 'warning' : 'light' }} mt-1" style="font-size: 0.65rem;">
                                    {{ $blog->featured ? 'Featured' : 'Regular' }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input toggle-status"
                                    id="status-{{ $blog->id }}" data-id="{{ $blog->id }}"
                                    {{ $blog->status ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status-{{ $blog->id }}"></label>
                            </div>
                            <small class="text-xs d-block mt-1 font-weight-bold status-label-{{ $blog->id }}">
                                {{ $blog->status ? 'PUBLISHED' : 'DRAFT' }}
                            </small>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('blog.details', $blog->slug) }}"
                                    class="btn btn-sm btn-info shadow-sm" target="_blank" title="View Publicly">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit Content">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $blog->id }}" title="Delete Post">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $blog->id }}"
                                action="{{ route('admin.blogs.destroy', $blog) }}"
                                method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-info-soft {
        background-color: rgba(54, 185, 204, 0.1);
        font-weight: 600;
        padding: 0.4em 0.8em;
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
        // Toggle status
        $('.toggle-status').change(function() {
            var blogId = $(this).data('id');
            var isChecked = $(this).is(':checked');
            var label = $('.status-label-' + blogId);

            $.ajax({
                url: "{{ url('admin/blogs') }}/" + blogId + "/toggle-status",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('Article status updated successfully');
                    label.text(isChecked ? 'PUBLISHED' : 'DRAFT');
                },
                error: function() {
                    toastr.error('Failed to update status');
                    $(this).prop('checked', !isChecked);
                }
            });
        });

        // Delete confirmation
        $('.delete-btn').click(function(e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Delete this article?',
                text: "This action cannot be undone!",
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