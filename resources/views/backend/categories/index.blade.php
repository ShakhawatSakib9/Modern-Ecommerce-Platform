@extends('backend.layouts.app')

@section('title', 'Category Management')
@section('page_title', 'Categories')

@section('breadcrumb')
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-list-ul mr-2"></i>Categories</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add New Category
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="categoriesTable">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" width="50">#</th>
                        <th>Category Info</th>
                        <th class="text-center" width="100">Display Order</th>
                        <th class="text-center" width="120">Status</th>
                        <th width="150">Created Date</th>
                        <th class="text-center pr-4" width="150">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @forelse($categories as $category)
                    <tr data-id="{{ $category->id }}" class="align-middle">
                        <td class="pl-4 align-middle">
                            <i class="fas fa-grip-vertical text-muted mr-2 handle" style="cursor: move;"></i>
                            {{ $loop->iteration }}
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                    class="rounded shadow-sm mr-3" width="45" height="45" style="object-fit: cover;">
                                @else
                                <div class="rounded shadow-sm mr-3 bg-light d-flex align-items-center justify-content-center" width="45" height="45" style="width: 45px; height: 45px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="font-weight-bold">{{ $category->name }}</div>
                                    @if($category->description)
                                    <small class="text-muted d-block line-clamp-1">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-secondary badge-pill order-badge">{{ $category->order }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $category->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </td>
                        <td class="align-middle text-muted">{{ $category->created_at->format('M d, Y') }}</td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $category->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $category->id }}"
                                action="{{ route('admin.categories.destroy', $category) }}"
                                method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                            No categories found. <a href="{{ route('admin.categories.create') }}" class="font-weight-bold">Create your first category.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $categories->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    #sortable tr.ui-sortable-helper {
        background-color: #f8f9fc;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script>
    $(function() {
        // Delete Confirmation
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this category? This will also affect subcategories and products associated.')) {
                $('#delete-form-' + id).submit();
            }
        });

        // Drag and drop sorting
        $('#sortable').sortable({
            handle: '.handle',
            update: function(event, ui) {
                var order = [];
                $('#sortable tr').each(function(index) {
                    order.push({
                        id: $(this).data('id'),
                        order: index + 1
                    });
                });

                $.ajax({
                    url: '{{ route("admin.categories.update-order") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#sortable tr').each(function(index) {
                                $(this).find('.order-badge').text(index + 1);
                            });
                            toastr.success('Display order updated successfully');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush