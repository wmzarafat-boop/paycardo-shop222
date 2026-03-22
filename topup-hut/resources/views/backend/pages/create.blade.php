@extends('backend.layouts.main')
@section('title', 'Create Page')
@section('page_title', 'Create Page')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Page</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pages.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Slug *</label>
                        <input type="text" name="slug" class="form-control" required>
                        <small class="text-muted">URL: /page/your-slug</small>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="10"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="status" class="form-check-input" id="status" value="1" checked>
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Page
            </button>
        </form>
    </div>
</div>
@endsection
