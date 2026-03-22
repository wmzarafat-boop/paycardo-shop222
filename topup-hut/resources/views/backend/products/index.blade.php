@extends('backend.layouts.main')
@section('title', 'Products')
@section('page_title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Add Product
    </a>
    <form action="" method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
        <select name="category" class="form-select">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Products</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                            @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ Str::limit($product->name, 30) }}</strong>
                            @if($product->has_variants)
                            <span class="badge bg-info ms-1">Variants</span>
                            @endif
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>
                            @if($product->sale_price)
                            <span class="text-decoration-line-through text-muted">{{ settings('currency_symbol', '৳') }}{{ number_format($product->price, 2) }}</span>
                            <br><span class="text-success fw-bold">{{ settings('currency_symbol', '৳') }}{{ number_format($product->sale_price, 2) }}</span>
                            @else
                            {{ settings('currency_symbol', '৳') }}{{ number_format($product->price, 2) }}
                            @endif
                        </td>
                        <td>
                            @if($product->has_variants)
                            <span class="text-info">Multiple</span>
                            @else
                            {{ $product->stock }}
                            @endif
                        </td>
                        <td>
                            @if($product->is_featured)
                            <span class="badge bg-success">Yes</span>
                            @else
                            <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->status === 'published' ? 'success' : ($product->status === 'draft' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
</div>
@endsection
