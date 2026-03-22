@extends('backend.layouts.main')
@section('title', 'Edit Category')
@section('page_title', 'Edit Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Category</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Parent Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- No Parent --</option>
                            @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" name="icon" class="form-control" value="{{ $category->icon }}" placeholder="fa-folder">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ $category->sort_order }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ $category->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured Category</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Update Category
            </button>
        </form>
    </div>
</div>
@endsection
