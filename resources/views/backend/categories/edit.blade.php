@extends('backend.layouts.app')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
<li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit Category: {{ $category->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label font-weight-bold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label font-weight-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" rows="5">{{ old('description', $category->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Category Image</label>
                        @if($category->image)
                        <div class="mb-3 p-2 bg-light rounded text-center">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                            <div class="mt-2 small text-muted">Current Image</div>
                        </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                            <label class="custom-file-label" for="image">Change image...</label>
                        </div>
                        @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label font-weight-bold">Display Order</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                            id="order" name="order" value="{{ old('order', $category->order) }}" min="0">
                        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text small text-muted italic">Lower number appears first.</div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                            <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between border-top pt-4 mt-2">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light shadow-sm px-4">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-5 font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', e => {
        const fileName = e.target.files[0].name;
        const nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush