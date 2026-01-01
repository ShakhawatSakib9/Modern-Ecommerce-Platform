@extends('backend.layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Products</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if(!empty($product->images[0]))
                                <img src="{{ asset('storage/' . $product->images[0]) }}"
                                     class="rounded me-3" width="50" height="50">
                                @endif
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    <small class="text-muted d-block">{{ $product->sku }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category->name }} → {{ $product->subCategory->name }}</td>
                        <td>
                            @if($product->discount_price)
                            <div class="text-danger">${{ $product->discount_price }}</div>
                            <small class="text-muted"><s>${{ $product->regular_price }}</s></small>
                            @else
                            <div>${{ $product->regular_price }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                {{ $product->status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete({{ $product->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $product->id }}"
                                  action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No products found. <a href="{{ route('admin.products.create') }}">Create one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
