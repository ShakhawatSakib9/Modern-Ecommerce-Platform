@extends('backend.layouts.app')

@section('title', 'Blog Category Management')
@section('page_title', 'Blog Categories')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-tags mr-2"></i>Blog Categories</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add Category
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th class="text-center">Articles</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle text-muted">{{ $loop->iteration }}</td>
                        <td class="align-middle font-weight-bold">{{ $category->name }}</td>
                        <td class="align-middle text-muted small">{{ $category->slug }}</td>
                        <td class="text-center align-middle">
                            <span class="badge badge-info-soft text-info badge-pill">{{ $category->blogs_count }} Articles</span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input toggle-status"
                                    id="status-{{ $category->id }}" data-id="{{ $category->id }}"
                                    {{ $category->status ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status-{{ $category->id }}"></label>
                            </div>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.blog-categories.edit', $category) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $category->id }}" title="Delete Category">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $category->id }}"
                                action="{{ route('admin.blog-categories.destroy', $category) }}"
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
        padding: 0.4em 0.8rem;
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
            var categoryId = $(this).data('id');
            var isChecked = $(this).is(':checked');

            $.ajax({
                url: "{{ url('admin/blog-categories') }}/" + categoryId + "/toggle-status",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('Category status updated successfully');
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
                title: 'Delete this category?',
                text: "Articles in this category may become uncategorized!",
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