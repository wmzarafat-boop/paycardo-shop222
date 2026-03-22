@extends('backend.layouts.main')
@section('title', 'Settings')
@section('page_title', 'Settings')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Site Settings</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.store') }}" method="POST">
            @csrf

            <h6 class="mb-3">General Settings</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Site Tagline</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? '' }}">
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Currency Settings</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Currency Code</label>
                        <input type="text" name="currency" class="form-control" value="{{ $settings['currency'] ?? 'BDT' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control" value="{{ $settings['currency_symbol'] ?? '৳' }}">
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Contact Information</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
            </div>

            <h6 class="mb-3">Social Media</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Facebook</label>
                        <input type="url" name="facebook" class="form-control" value="{{ $settings['facebook'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">YouTube</label>
                        <input type="url" name="youtube" class="form-control" value="{{ $settings['youtube'] ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="url" name="instagram" class="form-control" value="{{ $settings['instagram'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Twitter</label>
                        <input type="url" name="twitter" class="form-control" value="{{ $settings['twitter'] ?? '' }}">
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Payment Numbers</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">bKash Number</label>
                        <input type="text" name="bkash_number" class="form-control" value="{{ $settings['bkash_number'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Rocket Number</label>
                        <input type="text" name="rocket_number" class="form-control" value="{{ $settings['rocket_number'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nagad Number</label>
                        <input type="text" name="nagad_number" class="form-control" value="{{ $settings['nagad_number'] ?? '' }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Settings
            </button>
        </form>
    </div>
</div>
@endsection
