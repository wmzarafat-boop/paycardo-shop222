@extends('backend.layouts.main')
@section('title', 'Create Category')
@section('page_title', 'Create Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Category</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Parent Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- No Parent --</option>
                            @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" name="icon" class="form-control" placeholder="fa-folder">
                        <small class="text-muted">e.g., fa-folder, fa-star, fa-gamepad</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                    <label class="form-check-label" for="is_featured">Featured Category</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Category
            </button>
        </form>
    </div>
</div>
@endsection
