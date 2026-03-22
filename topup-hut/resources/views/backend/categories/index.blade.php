@extends('backend.layouts.main')
@section('title', 'Categories')
@section('page_title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Add Category
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Categories</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Products</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td><i class="fas {{ $category->icon ?? 'fa-folder' }}"></i></td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                        <td>
                            @if($category->is_featured)
                            <span class="badge bg-success">Yes</span>
                            @else
                            <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </td>
                        <td>{{ $category->products->count() }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @foreach($category->children as $child)
                    <tr class="table-secondary">
                        <td>{{ $child->id }}</td>
                        <td><i class="fas fa-level-down-alt text-muted"></i></td>
                        <td>{{ $child->name }}</td>
                        <td><code>{{ $child->slug }}</code></td>
                        <td><span class="text-muted">{{ $category->name }}</span></td>
                        <td>-</td>
                        <td>
                            <span class="badge bg-{{ $child->status === 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($child->status) }}
                            </span>
                        </td>
                        <td>{{ $child->products->count() }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $child->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">No categories found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
