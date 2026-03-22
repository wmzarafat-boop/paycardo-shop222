@extends('backend.layouts.main')
@section('title', 'Create Product')
@section('page_title', 'Create Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Product</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Short Description</label>
                <textarea name="short_description" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Full Description</label>
                <textarea name="description" class="form-control" rows="5" id="editor"></textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Price *</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Sale Price</label>
                        <input type="number" name="sale_price" class="form-control" step="0.01">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="100">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Has Variants?</label>
                        <select name="has_variants" class="form-select" id="has_variants">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="variants_section" class="d-none">
                <h6>Product Variants</h6>
                <div id="variants_container">
                    <div class="row mb-2 variant-row">
                        <div class="col-md-3">
                            <input type="text" name="variant_names[]" class="form-control" placeholder="Variant Name (e.g., 100 Likes)">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="variant_skus[]" class="form-control" placeholder="SKU">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variant_prices[]" class="form-control" placeholder="Price">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variant_sale_prices[]" class="form-control" placeholder="Sale Price">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variant_stocks[]" class="form-control" placeholder="Stock" value="100">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger remove-variant"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" id="add_variant"><i class="fas fa-plus me-2"></i> Add Variant</button>
            </div>

            <hr>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                    <label class="form-check-label" for="is_featured">Featured Product</label>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_trending" class="form-check-input" id="is_trending">
                    <label class="form-check-label" for="is_trending">Trending Product</label>
                </div>
            </div>

            <h6 class="mt-4">Product Images</h6>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Upload Images (Multiple)</label>
                        <input type="file" name="product_images[]" class="form-control" id="imageInput" multiple accept="image/*">
                        <small class="text-muted">Supported: JPG, PNG, GIF, WebP. Max 2MB each. First image will be primary.</small>
                    </div>
                    <div id="imagePreview" class="row"></div>
                </div>
            </div>

            <h6 class="mt-4">SEO Information</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <input type="text" name="meta_description" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Product
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('has_variants').addEventListener('change', function() {
    document.getElementById('variants_section').classList.toggle('d-none', this.value != '1');
});

document.getElementById('add_variant').addEventListener('click', function() {
    const container = document.getElementById('variants_container');
    const row = document.createElement('div');
    row.className = 'row mb-2 variant-row';
    row.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="variant_names[]" class="form-control" placeholder="Variant Name">
        </div>
        <div class="col-md-2">
            <input type="text" name="variant_skus[]" class="form-control" placeholder="SKU">
        </div>
        <div class="col-md-2">
            <input type="number" name="variant_prices[]" class="form-control" placeholder="Price">
        </div>
        <div class="col-md-2">
            <input type="number" name="variant_sale_prices[]" class="form-control" placeholder="Sale Price">
        </div>
        <div class="col-md-2">
            <input type="number" name="variant_stocks[]" class="form-control" placeholder="Stock" value="100">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger remove-variant"><i class="fas fa-times"></i></button>
        </div>
    `;
    container.appendChild(row);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-variant')) {
        e.target.closest('.variant-row').remove();
    }
});

// Image preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach((file, index) => {
        if (file.size > 2 * 1024 * 1024) {
            alert('File ' + file.name + ' is too large. Max 2MB allowed.');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(event) {
            const col = document.createElement('div');
            col.className = 'col-md-3 col-6 mb-2';
            col.innerHTML = `
                <div class="position-relative">
                    <img src="${event.target.result}" class="img-thumbnail" style="height: 120px; width: 100%; object-fit: cover;">
                    <span class="badge bg-primary position-absolute" style="top: 5px; left: 5px;">${index === 0 ? 'Primary' : 'New'}</span>
                </div>
            `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
