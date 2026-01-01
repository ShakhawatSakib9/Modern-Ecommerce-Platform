@extends('backend.layouts.app')

@section('title', 'Sub Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Sub Categories</h4>
    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Sub Category
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $subcategory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>
                            <span class="badge bg-{{ $subcategory->status == 'active' ? 'success' : 'secondary' }}">
                                {{ $subcategory->status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.subcategories.edit', $subcategory) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete({{ $subcategory->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $subcategory->id }}"
                                  action="{{ route('admin.subcategories.destroy', $subcategory) }}"
                                  method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            No sub categories found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subcategories->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $subcategories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this sub category?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
