@extends('backend.layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <!-- Will be populated by AJAX -->
                                </select>
                                @error('sub_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="images" class="form-label">Product Images *</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror"
                               id="images" name="images[]" multiple accept="image/*" required>
                        @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Select 1-5 images</div>
                        <div id="image-preview" class="mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label for="regular_price" class="form-label">Regular Price ($) *</label>
                        <input type="number" step="0.01" class="form-control @error('regular_price') is-invalid @enderror"
                               id="regular_price" name="regular_price" value="{{ old('regular_price') }}" required>
                        @error('regular_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount_price" class="form-label">Discount Price ($)</label>
                        <input type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror"
                               id="discount_price" name="discount_price" value="{{ old('discount_price') }}">
                        @error('discount_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                               id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                        @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                       {{ in_array($size, old('sizes', [])) ? 'checked' : '' }}>
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
                                       {{ in_array($color, old('colors', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="color-{{ $color }}">{{ $color }}</label>
                            </div>
                            @endforeach
                        </div>
                        @error('colors')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Category change event
document.getElementById('category_id').addEventListener('change', function() {
    const categoryId = this.value;
    const subCategorySelect = document.getElementById('sub_category_id');

    if (!categoryId) {
        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
        return;
    }

    fetch(`/admin/subcategories-by-category/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            let options = '<option value="">Select Sub Category</option>';
            data.forEach(sub => {
                options += `<option value="${sub.id}">${sub.name}</option>`;
            });
            subCategorySelect.innerHTML = options;
        });
});

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
