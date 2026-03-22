@extends('backend.layouts.main')
@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Product</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Short Description</label>
                <textarea name="short_description" class="form-control" rows="2">{{ $product->short_description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Full Description</label>
                <textarea name="description" class="form-control" rows="5">{{ $product->description }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Price *</label>
                        <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Sale Price</label>
                        <input type="number" name="sale_price" class="form-control" step="0.01" value="{{ $product->sale_price }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $product->status == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ $product->status == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Has Variants?</label>
                        <select name="has_variants" class="form-select" id="has_variants">
                            <option value="0" {{ !$product->has_variants ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $product->has_variants ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="variants_section" class="{{ $product->has_variants ? '' : 'd-none' }}">
                <h6>Product Variants</h6>
                <div id="variants_container">
                    @foreach($product->variants as $variant)
                    <div class="row mb-2 variant-row">
                        <div class="col-md-3">
                            <input type="text" name="variant_names[]" class="form-control" value="{{ $variant->name }}" placeholder="Variant Name">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="variant_skus[]" class="form-control" value="{{ $variant->sku }}" placeholder="SKU">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variant_prices[]" class="form-control" value="{{ $variant->price }}" placeholder="Price">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variant_sale_prices[]" class="form-control" value="{{ $variant->sale_price }}" placeholder="Sale Price">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="variant_stocks[]" class="form-control" value="{{ $variant->stock }}" placeholder="Stock">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger remove-variant"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    @endforeach
                    <div class="row mb-2 variant-row d-none" id="variant_template">
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
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" id="add_variant"><i class="fas fa-plus me-2"></i> Add Variant</button>
            </div>

            <hr>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured Product</label>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_trending" class="form-check-input" id="is_trending" {{ $product->is_trending ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_trending">Trending Product</label>
                </div>
            </div>

            <h6 class="mt-4">Product Images</h6>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row" id="current_images">
                        @forelse($product->images as $image)
                        <div class="col-md-3 col-6 mb-3 image-item" data-image-id="{{ $image->id }}">
                            <div class="position-relative">
                                <img src="{{ $image->image }}" alt="Product Image" class="img-thumbnail" style="height: 150px; width: 100%; object-fit: cover;">
                                @if($image->is_primary)
                                <span class="badge bg-success position-absolute" style="top: 5px; left: 5px;">Primary</span>
                                @endif
                                <button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 5px; right: 5px;" onclick="deleteImage({{ $image->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @if(!$image->is_primary)
                            <button type="button" class="btn btn-sm btn-primary w-100 mt-1" onclick="setPrimary({{ $image->id }})">
                                <i class="fas fa-star"></i> Set as Primary
                            </button>
                            @endif
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted py-4">
                            <i class="fas fa-images fs-1 mb-2 d-block"></i>
                            No images uploaded yet
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6>Add New Images</h6>
                    <div class="mb-3">
                        <label class="form-label">Upload Images (Multiple)</label>
                        <input type="file" name="product_images[]" class="form-control" id="imageInput" multiple accept="image/*">
                        <small class="text-muted">Supported: JPG, PNG, GIF, WebP. Max 2MB each.</small>
                    </div>
                    <div id="imagePreview" class="row"></div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i> Upload & Save Images
                        </button>
                    </div>
                </div>
            </div>

            <h6 class="mt-4">SEO Information</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ $product->meta_title }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <input type="text" name="meta_description" class="form-control" value="{{ $product->meta_description }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Update Product
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
    const template = document.getElementById('variant_template');
    const clone = template.cloneNode(true);
    clone.classList.remove('d-none');
    clone.removeAttribute('id');
    document.getElementById('variants_container').appendChild(clone);
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

// Delete image
function deleteImage(imageId) {
    if (!confirm('Are you sure you want to delete this image?')) return;
    
    fetch('/admin/products/images/' + imageId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`.image-item[data-image-id="${imageId}"]`).remove();
            toastr.success('Image deleted successfully');
        } else {
            toastr.error('Failed to delete image');
        }
    });
}

// Set primary image
function setPrimary(imageId) {
    fetch('/admin/products/images/' + imageId + '/primary', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll('.image-item').forEach(item => {
                item.querySelector('.badge')?.remove();
                const badge = document.createElement('span');
                badge.className = 'badge bg-success position-absolute';
                badge.style.cssText = 'top: 5px; left: 5px;';
                badge.textContent = 'Primary';
                item.querySelector('.position-relative').prepend(badge);
            });
            const currentPrimary = document.querySelector(`.image-item[data-image-id="${imageId}"]`);
            toastr.success('Primary image updated');
        }
    });
}
</script>
@endpush
