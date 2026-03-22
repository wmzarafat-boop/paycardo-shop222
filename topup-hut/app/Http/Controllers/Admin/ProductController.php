<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(20);
        $categories = Category::where('status', 'active')->get();

        return view('backend.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock ?? 0,
            'sku' => $request->sku ?? strtoupper(Str::random(8)),
            'has_variants' => $request->has_variants ?? false,
            'is_featured' => $request->is_featured ?? false,
            'is_trending' => $request->is_trending ?? false,
            'status' => $request->status ?? 'draft',
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        if ($request->has_variants && $request->variant_names) {
            foreach ($request->variant_names as $key => $name) {
                if ($name) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $name,
                        'sku' => $request->variant_skus[$key] ?? strtoupper(Str::random(6)),
                        'price' => $request->variant_prices[$key] ?? $request->price,
                        'sale_price' => $request->variant_sale_prices[$key] ?? null,
                        'stock' => $request->variant_stocks[$key] ?? 100,
                        'status' => true,
                    ]);
                }
            }
        }

        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $key => $image) {
                $filename = 'products/' . time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                Storage::disk('google')->put($filename, file_get_contents($image));
                $imageUrl = 'https://drive.google.com/file/d/' . $this->getGoogleDriveFileId($filename) . '/view';
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageUrl,
                    'is_primary' => $key === 0,
                    'sort_order' => $key,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock ?? 0,
            'sku' => $request->sku,
            'has_variants' => $request->has_variants ?? false,
            'is_featured' => $request->is_featured ?? false,
            'is_trending' => $request->is_trending ?? false,
            'status' => $request->status ?? 'draft',
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        if ($request->has_variants && $request->variant_names) {
            $product->variants()->delete();
            foreach ($request->variant_names as $key => $name) {
                if ($name) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $name,
                        'sku' => $request->variant_skus[$key] ?? strtoupper(Str::random(6)),
                        'price' => $request->variant_prices[$key] ?? $request->price,
                        'sale_price' => $request->variant_sale_prices[$key] ?? null,
                        'stock' => $request->variant_stocks[$key] ?? 100,
                        'status' => true,
                    ]);
                }
            }
        }

        if ($request->hasFile('product_images')) {
            $existingCount = $product->images()->count();
            foreach ($request->file('product_images') as $key => $image) {
                $filename = 'products/' . time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                Storage::disk('google')->put($filename, file_get_contents($image));
                $imageUrl = 'https://drive.google.com/file/d/' . $this->getGoogleDriveFileId($filename) . '/view';
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageUrl,
                    'is_primary' => ($existingCount + $key) === 0,
                    'sort_order' => $existingCount + $key,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            if ($image->image && !str_starts_with($image->image, 'http')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $image->image));
            }
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found']);
        }

        $product = $image->product;
        
        if ($image->image && !str_starts_with($image->image, 'http')) {
            Storage::disk('public')->delete($image->image);
        }
        
        $wasPrimary = $image->is_primary;
        $image->delete();
        
        if ($wasPrimary) {
            $newPrimary = $product->images()->first();
            if ($newPrimary) {
                $newPrimary->update(['is_primary' => true]);
            }
        }
        
        return response()->json(['success' => true, 'message' => 'Image deleted']);
    }

    public function setPrimaryImage($id)
    {
        $image = ProductImage::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found']);
        }
        
        $image->product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        
        return response()->json(['success' => true, 'message' => 'Primary image updated']);
    }

    private function getGoogleDriveFileId($path)
    {
        $client = new \Google\Client();
        $client->setClientId(config('google-drive.client_id'));
        $client->setClientSecret(config('google-drive.client_secret'));
        $client->refreshToken(config('google-drive.refresh_token'));
        
        $service = new \Google\Service\Drive($client);
        $results = $service->files->listFiles([
            'q' => "name='" . basename($path) . "' and '" . config('google-drive.folder_id') . "' in parents",
            'fields' => 'files(id, name)'
        ]);
        
        if (count($results) > 0) {
            return $results[0]['id'];
        }
        return '';
    }
}
