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
}