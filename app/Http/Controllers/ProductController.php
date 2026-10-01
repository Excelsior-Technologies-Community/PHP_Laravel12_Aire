<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display products with:
     * - Search
     * - Category filter
     * - Status filter
     * - Price filters
     * - Featured filter
     * - Low stock filter
     * - Out of stock filter
     * - Sorting
     * - Pagination
     * - Inventory statistics
     */
    public function index(Request $request)
    {
        $query = Product::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {

            $query->where(
                'category',
                $request->category
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Minimum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {

            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Maximum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('max_price')) {

            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Featured Products
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('featured')) {

            $query->where(
                'is_featured',
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Low Stock Filter
        |--------------------------------------------------------------------------
        | Stock from 1 to 5
        */
        if ($request->boolean('low_stock')) {

            $query->whereBetween(
                'stock',
                [1, 5]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Out Of Stock Filter
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('out_of_stock')) {

            $query->where(
                'stock',
                0
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        $allowedSorts = [
            'id',
            'name',
            'price',
            'stock',
            'created_at',
        ];

        $sort = $request->get(
            'sort',
            'created_at'
        );

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $direction = $request->get(
            'direction',
            'desc'
        );

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $products = $query
            ->orderBy($sort, $direction)
            ->paginate(5)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */
        $totalProducts = Product::count();

        $totalInventoryValue = Product::sum(
            DB::raw('price * stock')
        );

        $averagePrice = Product::avg('price');

        $highestPrice = Product::max('price');

        $lowestPrice = Product::min('price');

        $featuredProducts = Product::where(
            'is_featured',
            true
        )->count();

        $activeProducts = Product::where(
            'status',
            'active'
        )->count();

        $inactiveProducts = Product::where(
            'status',
            'inactive'
        )->count();

        $outOfStockProducts = Product::where(
            'stock',
            0
        )->count();

        $lowStockProducts = Product::whereBetween(
            'stock',
            [1, 5]
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Filtered Inventory Summary
        |--------------------------------------------------------------------------
        */
        $filteredQuery = clone $query;

        $filteredProductsCount = $filteredQuery->count();

        $filteredInventoryValue = $filteredQuery->sum(
            DB::raw('price * stock')
        );

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        $categories = Product::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view(
            'products.index',
            compact(
                'products',
                'totalProducts',
                'totalInventoryValue',
                'averagePrice',
                'highestPrice',
                'lowestPrice',
                'featuredProducts',
                'activeProducts',
                'inactiveProducts',
                'outOfStockProducts',
                'lowStockProducts',
                'filteredProductsCount',
                'filteredInventoryValue',
                'categories',
                'sort',
                'direction'
            )
        );
    }

    /**
     * Show create product form.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'price' => [
                'required',
                'integer',
                'min:1',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $validated['is_featured'] =
            $request->boolean('is_featured');

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product Added Successfully'
            );
    }

    /**
     * Show edit product form.
     */
    public function edit(Product $product)
    {
        return view(
            'products.edit',
            compact('product')
        );
    }

    /**
     * Update product.
     */
    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'price' => [
                'required',
                'integer',
                'min:1',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $validated['is_featured'] =
            $request->boolean('is_featured');

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product Updated Successfully'
            );
    }

    /**
     * Delete single product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product Deleted Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | NEW FUNCTIONALITY 5
    | Bulk Delete
    |--------------------------------------------------------------------------
    */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'product_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'product_ids.*' => [
                'integer',
                'exists:products,id',
            ],
        ]);

        $count = Product::whereIn(
            'id',
            $request->product_ids
        )->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                $count . ' product(s) deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | NEW FUNCTIONALITY 6 & 7
    | Bulk Status Update
    |--------------------------------------------------------------------------
    */
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'product_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'product_ids.*' => [
                'integer',
                'exists:products,id',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $count = Product::whereIn(
            'id',
            $request->product_ids
        )->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                $count . ' product(s) updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | NEW FUNCTIONALITY 8
    | Duplicate Product
    |--------------------------------------------------------------------------
    */
    public function duplicate(Product $product)
    {
        $duplicate = $product->replicate();

        $duplicate->name =
            $product->name . ' (Copy)';

        $duplicate->save();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product duplicated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | NEW FUNCTIONALITY 9
    | CSV Export
    |--------------------------------------------------------------------------
    */
    public function export(Request $request)
    {
        $query = Product::query();

        /*
        | Search
        */
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'category',
                        'like',
                        '%' . $search . '%'
                    );

            });
        }

        /*
        | Category
        */
        if ($request->filled('category')) {

            $query->where(
                'category',
                $request->category
            );
        }

        /*
        | Status
        */
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        | Price range
        */
        if ($request->filled('min_price')) {

            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {

            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        /*
        | Featured
        */
        if ($request->boolean('featured')) {

            $query->where(
                'is_featured',
                true
            );
        }

        /*
        | Low stock
        */
        if ($request->boolean('low_stock')) {

            $query->whereBetween(
                'stock',
                [1, 5]
            );
        }

        /*
        | Out of stock
        */
        if ($request->boolean('out_of_stock')) {

            $query->where(
                'stock',
                0
            );
        }

        /*
        | Sorting
        */
        $allowedSorts = [
            'id',
            'name',
            'price',
            'stock',
            'created_at',
        ];

        $sort = $request->get(
            'sort',
            'created_at'
        );

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $direction = $request->get(
            'direction',
            'desc'
        );

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $products = $query
            ->orderBy($sort, $direction)
            ->get();

        $fileName =
            'products-' .
            now()->format('Y-m-d-H-i-s') .
            '.csv';

        return response()->streamDownload(
            function () use ($products) {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                /*
                | CSV Header
                */
                fputcsv($handle, [
                    'ID',
                    'Name',
                    'Price',
                    'Category',
                    'Stock',
                    'Status',
                    'Featured',
                    'Description',
                    'Inventory Value',
                    'Created At',
                ]);

                /*
                | CSV Rows
                */
                foreach ($products as $product) {

                    fputcsv($handle, [
                        $product->id,
                        $product->name,
                        $product->price,
                        $product->category,
                        $product->stock,
                        $product->status,
                        $product->is_featured
                            ? 'Yes'
                            : 'No',
                        $product->description,
                        $product->price * $product->stock,
                        optional(
                            $product->created_at
                        )->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($handle);
            },
            $fileName,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Interactive Dynamic Form Schema Builder & Custom Field Studio
    |--------------------------------------------------------------------------
    */
    public function formStudio(Request $request)
    {
        $products = Product::latest()->take(10)->get();
        $categories = ['Electronics', 'Clothing', 'Grocery', 'Automotive', 'Furniture'];

        $defaultSchemas = [
            'Electronics' => [
                ['key' => 'warranty_months', 'label' => 'Warranty Period (Months)', 'type' => 'number', 'default' => '24'],
                ['key' => 'power_watts', 'label' => 'Power Consumption (W)', 'type' => 'text', 'default' => '65W'],
                ['key' => 'connectivity', 'label' => 'Connectivity Options', 'type' => 'text', 'default' => 'Bluetooth 5.3, Wi-Fi 6'],
            ],
            'Clothing' => [
                ['key' => 'material', 'label' => 'Fabric / Material', 'type' => 'text', 'default' => '100% Organic Cotton'],
                ['key' => 'fit', 'label' => 'Fit Type', 'type' => 'select', 'default' => 'Regular Fit'],
                ['key' => 'care', 'label' => 'Care Instructions', 'type' => 'text', 'default' => 'Machine Wash Cold'],
            ],
            'Grocery' => [
                ['key' => 'expiry_days', 'label' => 'Shelf Life (Days)', 'type' => 'number', 'default' => '180'],
                ['key' => 'organic', 'label' => 'Organic Certified', 'type' => 'select', 'default' => 'Yes'],
                ['key' => 'weight_g', 'label' => 'Net Weight (g)', 'type' => 'number', 'default' => '500'],
            ],
            'Furniture' => [
                ['key' => 'dimensions', 'label' => 'Dimensions (L x W x H)', 'type' => 'text', 'default' => '120 x 60 x 75 cm'],
                ['key' => 'wood_type', 'label' => 'Wood / Material Grade', 'type' => 'text', 'default' => 'Solid Teak Wood'],
            ],
        ];

        return view('products.form_studio', compact('products', 'categories', 'defaultSchemas'));
    }

    public function saveSchema(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'category' => 'required|string',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->name);
        $sku = $request->input('sku') ?: 'SKU-' . strtoupper(\Illuminate\Support\Str::random(6));

        $customFields = $request->input('custom_fields', []);
        if (is_string($customFields)) {
            $customFields = json_decode($customFields, true) ?? [];
        }

        $validationRules = [
            'client_validation' => $request->boolean('client_validation'),
            'auto_slug' => true,
            'custom_error_msg' => 'Please provide valid values for all required fields.',
        ];

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'sku' => $sku,
            'category' => $request->category,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'status' => $request->input('status', 'active'),
            'is_featured' => $request->boolean('is_featured'),
            'description' => $request->input('description', 'Created via Aire Form Studio'),
            'custom_fields' => $customFields,
            'validation_rules' => $validationRules,
        ]);

        return redirect()->route('products.formStudio')->with('success', "Aire Dynamic Form Schema saved for product #{$product->id} ({$product->name}) with auto-generated slug: {$slug}!");
    }

    /*
    |--------------------------------------------------------------------------
    | Multi-File Image Gallery & Product Variant Matrix Generator
    |--------------------------------------------------------------------------
    */
    public function variantMatrix(Request $request)
    {
        $products = Product::latest()->take(10)->get();

        return view('products.variant_matrix', compact('products'));
    }

    public function generateVariants(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'base_price' => 'required|integer|min:1',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',
        ]);

        $name = $request->input('name');
        $basePrice = (int) $request->input('base_price', 100);
        $sizes = $request->input('sizes', ['M', 'L']);
        $colors = $request->input('colors', ['Black', 'Blue']);
        $images = $request->input('images', [
            'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400',
            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
        ]);

        $coverImage = $request->input('cover_image', $images[0] ?? null);

        $variants = [];
        $totalStock = 0;

        foreach ($colors as $color) {
            foreach ($sizes as $size) {
                $varPrice = $basePrice + rand(0, 20);
                $varStock = rand(10, 50);
                $varSku = strtoupper(substr($name, 0, 3)) . '-' . strtoupper(substr($color, 0, 2)) . '-' . $size;

                $variants[] = [
                    'sku' => $varSku,
                    'color' => $color,
                    'size' => $size,
                    'price' => $varPrice,
                    'stock' => $varStock,
                ];

                $totalStock += $varStock;
            }
        }

        $product = Product::create([
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'sku' => 'PRD-' . rand(1000, 9999),
            'category' => $request->input('category', 'Clothing & Apparel'),
            'price' => $basePrice,
            'stock' => $totalStock,
            'status' => 'active',
            'is_featured' => true,
            'description' => 'Product generated with ' . count($variants) . ' dynamic variant combinations and image gallery.',
            'images' => $images,
            'cover_image' => $coverImage,
            'variants' => $variants,
        ]);

        return redirect()->route('products.variantMatrix')->with('success', "Generated " . count($variants) . " product variants and gallery for '{$product->name}' successfully!");
    }
}