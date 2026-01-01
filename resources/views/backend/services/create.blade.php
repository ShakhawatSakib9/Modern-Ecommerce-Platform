@extends('backend.layouts.app')

@section('title', 'Create Service')
@section('page_title', 'Create Service')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="icon">Icon *</label>
                        <select class="form-control select2 @error('icon') is-invalid @enderror"
                               id="icon" name="icon" required>
                            <option value="">Select Icon</option>
                            @foreach($icons as $icon)
                            <option value="{{ $icon }}" {{ old('icon') == $icon ? 'selected' : '' }}>
                                <i class="{{ $icon }}"></i> {{ $icon }}
                            </option>
                            @endforeach
                        </select>
                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order">Order *</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', $nextOrder) }}" min="1" required>
                                @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Auto-suggested: {{ $nextOrder }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch mt-4">
                                    <input type="checkbox" class="custom-control-input"
                                           id="is_active" name="is_active" value="1" checked>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Service
                </button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        function formatIcon(icon) {
            if (!icon.id) { return icon.text; }
            var $icon = $('<span><i class="' + icon.id + ' mr-2"></i>' + icon.text + '</span>');
            return $icon;
        }

        $('#icon').select2({
            templateResult: formatIcon,
            templateSelection: formatIcon,
            theme: 'bootstrap4'
        });
    });
</script>
@endpush
