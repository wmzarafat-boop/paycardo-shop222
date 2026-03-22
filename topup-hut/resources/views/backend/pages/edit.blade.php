@extends('backend.layouts.main')
@section('title', 'Edit Page')
@section('page_title', 'Edit Page')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Page</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Slug *</label>
                        <input type="text" name="slug" class="form-control" value="{{ $page->slug }}" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="{{ $page->subtitle }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="10">{{ $page->content }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ $page->meta_title }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2">{{ $page->meta_description }}</textarea>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ $page->status ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Update Page
            </button>
        </form>
    </div>
</div>
@endsection
