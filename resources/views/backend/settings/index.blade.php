@extends('backend.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">General Settings</h5>

                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name *</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                               id="site_name" name="site_name" value="{{ old('site_name', $settings->site_name) }}" required>
                        @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="site_email" class="form-label">Site Email *</label>
                        <input type="email" class="form-control @error('site_email') is-invalid @enderror"
                               id="site_email" name="site_email" value="{{ old('site_email', $settings->site_email) }}" required>
                        @error('site_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="site_phone" class="form-label">Site Phone *</label>
                        <input type="text" class="form-control @error('site_phone') is-invalid @enderror"
                               id="site_phone" name="site_phone" value="{{ old('site_phone', $settings->site_phone) }}" required>
                        @error('site_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="site_address" class="form-label">Site Address *</label>
                        <textarea class="form-control @error('site_address') is-invalid @enderror"
                                  id="site_address" name="site_address" rows="2" required>{{ old('site_address', $settings->site_address) }}</textarea>
                        @error('site_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="delivery_charge" class="form-label">Delivery Charge ($) *</label>
                        <input type="number" step="0.01" class="form-control @error('delivery_charge') is-invalid @enderror"
                               id="delivery_charge" name="delivery_charge"
                               value="{{ old('delivery_charge', $settings->delivery_charge) }}" required>
                        @error('delivery_charge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3">Media & Social</h5>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Site Logo</label>
                            @if($settings->logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $settings->logo) }}" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                   id="logo" name="logo" accept="image/*">
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label">Favicon</label>
                            @if($settings->favicon)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $settings->favicon) }}" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('favicon') is-invalid @enderror"
                                   id="favicon" name="favicon" accept="image/*">
                            @error('favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="facebook_url" class="form-label">Facebook URL</label>
                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror"
                               id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}">
                        @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="instagram_url" class="form-label">Instagram URL</label>
                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror"
                               id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}">
                        @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="twitter_url" class="form-label">Twitter URL</label>
                        <input type="url" class="form-control @error('twitter_url') is-invalid @enderror"
                               id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}">
                        @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
