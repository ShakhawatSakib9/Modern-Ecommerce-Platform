@extends('backend.layouts.app')

@section('title', 'Product Management')
@section('page_title', 'Products')

@section('breadcrumb')
<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-boxes mr-2"></i>Product Catalog</h3>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm px-3 font-weight-bold hover-lift">
                <i class="fas fa-plus mr-1"></i> Add New Product
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="pl-4" style="width: 50px;">#</th>
                        <th>Product Info</th>
                        <th>Category</th>
                        <th class="text-right">Pricing</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pr-4" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="pl-4 align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <img src="{{ $product->getFirstImageUrl() }}" class="rounded shadow-sm mr-3" width="50" height="50" style="object-fit: cover;">
                                <div>
                                    <div class="font-weight-bold">{{ $product->name }}</div>
                                    <small class="text-muted text-uppercase">{{ $product->sku ?? 'NO SKU' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div>{{ $product->category->name }}</div>
                            <small class="text-muted">{{ $product->subCategory->name ?? '' }}</small>
                        </td>
                        <td class="text-right align-middle">
                            @if($product->is_on_sale)
                            <div class="text-danger font-weight-bold">${{ number_format($product->discount_price, 2) }}</div>
                            <small class="text-muted"><s>${{ number_format($product->regular_price, 2) }}</s></small>
                            @else
                            <div class="font-weight-bold">${{ number_format($product->regular_price, 2) }}</div>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info shadow-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger shadow-sm delete-btn" data-id="{{ $product->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                            No products found. <a href="{{ route('admin.products.create') }}" class="font-weight-bold">Create your first product.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white clearfix">
        <div class="float-right">
            {{ $products->links() }}
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
            if (confirm('Are you sure you want to delete this product?')) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>
@endpush