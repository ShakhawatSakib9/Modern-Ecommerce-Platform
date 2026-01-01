@extends('backend.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sub_category_id" class="form-label">Sub Category *</label>
                                <select class="form-select @error('sub_category_id') is-invalid @enderror"
                                        id="sub_category_id" name="sub_category_id" required>
                                    <option value="">Select Sub Category</option>
                                    @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ old('sub_category_id', $product->sub_category_id) == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('sub_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                                  id="short_description" name="short_description" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Current Images -->
                    <div class="mb-3">
                        <label class="form-label">Current Images</label>
                        <div class="d-flex flex-wrap gap-2">
                            @if($product->images && count($product->images) > 0)
                                @foreach($product->images as $image)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted">No images</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Upload New Images</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror"
                               id="images" name="images[]" multiple accept="image/*">
                        @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Leave empty to keep existing images</div>
                        <div id="image-preview" class="mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label for="regular_price" class="form-label">Regular Price ($) *</label>
                        <input type="number" step="0.01" class="form-control @error('regular_price') is-invalid @enderror"
                               id="regular_price" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" required>
                        @error('regular_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount_price" class="form-label">Discount Price ($)</label>
                        <input type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror"
                               id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                        @error('discount_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                               id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror"
                               id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Sizes *</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sizes as $size)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]"
                                       value="{{ $size }}" id="size-{{ $size }}"
                                       {{ in_array($size, old('sizes', $product->sizes ?? [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="size-{{ $size }}">{{ $size }}</label>
                            </div>
                            @endforeach
                        </div>
                        @error('sizes')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Colors *</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($colors as $color)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]"
                                       value="{{ $color }}" id="color-{{ $color }}"
                                       {{ in_array($color, old('colors', $product->colors ?? [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="color-{{ $color }}">{{ $color }}</label>
                            </div>
                            @endforeach
                        </div>
                        @error('colors')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1"
                                   {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Mark as Featured (Old System)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trend Section Checkboxes -->
            <div class="row mb-4">
                <div class="col-12">
                    <label class="form-label fw-bold mb-2">Trend Section Placement</label>
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                               id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold d-flex align-items-center" for="is_featured">
                                            <span class="badge bg-primary me-2"><i class="fa fa-star"></i></span>
                                            Featured Product
                                        </label>
                                        <small class="text-muted d-block mt-1">Appears in Featured section on homepage</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_hot_trend"
                                               id="is_hot_trend" value="1" {{ old('is_hot_trend', $product->is_hot_trend) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold d-flex align-items-center" for="is_hot_trend">
                                            <span class="badge bg-danger me-2"><i class="fa fa-fire"></i></span>
                                            Hot Trend
                                        </label>
                                        <small class="text-muted d-block mt-1">Appears in Hot Trend section on homepage</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_best_seller"
                                               id="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold d-flex align-items-center" for="is_best_seller">
                                            <span class="badge bg-warning me-2"><i class="fa fa-trophy"></i></span>
                                            Best Seller
                                        </label>
                                        <small class="text-muted d-block mt-1">Appears in Best Seller section on homepage</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Image preview
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail me-2 mb-2';
            img.style.width = '80px';
            img.style.height = '80px';
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
