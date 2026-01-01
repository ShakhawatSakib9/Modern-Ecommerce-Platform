@extends('backend.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Categories</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Category
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="categoriesTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Name</th>
                        <th width="80">Order</th>
                        <th width="100">Status</th>
                        <th width="120">Created</th>
                        <th class="text-end" width="100">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @forelse($categories as $category)
                    <tr data-id="{{ $category->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                     class="rounded me-3" width="40" height="40">
                                @endif
                                <div>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->description)
                                    <small class="text-muted d-block">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $category->order }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $category->status == 'active' ? 'success' : 'secondary' }}">
                                {{ $category->status }}
                            </span>
                        </td>
                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete({{ $category->id }})">
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
                        <td colspan="6" class="text-center py-4 text-muted">
                            No categories found. <a href="{{ route('admin.categories.create') }}">Create one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
#sortable tr {
    cursor: move;
}
#sortable tr:hover {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Drag and drop sorting
$(function() {
    $('#sortable').sortable({
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
                        // Update order numbers in table
                        $('#sortable tr').each(function(index) {
                            $(this).find('.badge.bg-secondary').text(index + 1);
                        });
                        toastr.success('Order updated successfully');
                    }
                }
            });
        }
    });
});
</script>
@endpush
