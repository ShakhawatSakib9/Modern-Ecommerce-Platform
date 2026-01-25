@extends('backend.layouts.app')

@section('title', 'Sub Category Management')
@section('page_title', 'Sub Categories')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
<li class="breadcrumb-item active">Sub Categories</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-list-ul mr-2"></i>Sub Categories</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add Sub Category
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Sub Category Name</th>
                        <th>Parent Category</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $subcategory)
                    <tr class="align-middle">
                        <td class="pl-4 align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle font-weight-bold">{{ $subcategory->name }}</td>
                        <td class="align-middle">
                            <span class="badge badge-info shadow-sm">{{ $subcategory->category->name }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $subcategory->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($subcategory->status) }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.subcategories.edit', $subcategory) }}"
                                    class="btn btn-sm btn-primary shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $subcategory->id }}" title="Delete">
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                            No sub categories found. <a href="{{ route('admin.subcategories.create') }}" class="font-weight-bold">Create one.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($subcategories->hasPages())
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $subcategories->links() }}
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
            if (confirm('Are you sure you want to delete this sub category? This may affect associated products.')) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>
@endpush