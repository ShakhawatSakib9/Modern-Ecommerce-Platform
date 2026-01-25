@extends('backend.layouts.app')

@section('title', 'Edit Subcategory')
@section('page_title', 'Edit Subcategory')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.subcategories.index') }}">Subcategories</a></li>
<li class="breadcrumb-item active">{{ $subcategory->name }}</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white glass border-bottom">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit Subcategory: {{ $subcategory->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label font-weight-bold">Parent Category <span class="text-danger">*</span></label>
                    <select class="form-control @error('category_id') is-invalid @enderror"
                        id="category_id" name="category_id" required>
                        <option value="">Select Parent Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label font-weight-bold">Subcategory Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $subcategory->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label font-weight-bold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        id="description" name="description" rows="4">{{ old('description', $subcategory->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label font-weight-bold">Status <span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror"
                        id="status" name="status" required>
                        <option value="active" {{ old('status', $subcategory->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $subcategory->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex justify-content-between border-top pt-4 mt-2">
                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-light shadow-sm px-4">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-5 font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Update Subcategory
                </button>
            </div>
        </form>
    </div>
</div>
@endsection