@extends('layout')

@section('content')

<style>

    .products-page {
        max-width: 1250px;
        margin: 0 auto;
        padding: 10px 0 40px;
    }

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    .products-header {
        background: linear-gradient(
            135deg,
            #111827,
            #1f2937,
            #374151
        );

        border-radius: 20px;
        padding: 28px;
        color: #fff;

        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 20px;

        margin-bottom: 22px;

        box-shadow:
            0 15px 35px rgba(17,24,39,.15);
    }

    .products-header h2 {
        margin: 0 0 6px;
        font-size: 28px;
        font-weight: 700;
        color: #ffffff !important;
    }

    .products-header p {
        margin: 0;
        color: #cbd5e1 !important;
        font-size: 14px;
    }

    .add-product-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 11px 18px;

        border-radius: 10px;

        background: #fff;
        color: #111827;

        text-decoration: none;

        font-size: 14px;
        font-weight: 700;
    }

    /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

    .success-message {
        padding: 14px 18px;
        margin-bottom: 20px;

        border-radius: 10px;

        background: #ecfdf5;
        border: 1px solid #a7f3d0;

        color: #166534;

        font-size: 14px;
        font-weight: 600;
    }

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    .stats-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 15px;

        margin-bottom: 22px;
    }

    .stat-card {
        background: #fff;

        border: 1px solid #cbd5e1;

        border-radius: 15px;

        padding: 19px;

        box-shadow:
            0 7px 20px rgba(15,23,42,.05);
    }

    .stat-label {
        color: #334155 !important;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .stat-value {
        color: #0f172a !important;
        font-size: 24px;
        font-weight: 800;
    }

    .stat-small {
        color: #64748b !important;
        font-size: 12px;
        font-weight: 500;
        margin-top: 4px;
    }

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    .filter-card {
        background: #fff;

        border: 1px solid #e5e7eb;

        border-radius: 17px;

        padding: 22px;

        margin-bottom: 22px;

        box-shadow:
            0 7px 20px rgba(15,23,42,.05);
    }

    .filter-title {
        font-size: 16px;
        font-weight: 700;

        color: #111827;

        margin-bottom: 17px;
    }

    .filter-grid {
        display: grid;

        grid-template-columns:
            2fr 1fr 1fr 1fr 1fr;

        gap: 12px;
    }

    .filter-grid input,
    .filter-grid select {
        width: 100%;

        padding: 10px 12px;

        border:
            1px solid #d1d5db;

        border-radius: 9px;

        box-sizing: border-box;

        background: #fff;

        font-size: 13px;
    }

    .filter-grid input:focus,
    .filter-grid select:focus {
        outline: none;

        border-color: #6366f1;

        box-shadow:
            0 0 0 3px
            rgba(99,102,241,.10);
    }

    .filter-checkboxes {
        display: flex;

        flex-wrap: wrap;

        gap: 16px;

        margin-top: 15px;
    }

    .filter-checkbox {
        display: flex;

        align-items: center;

        gap: 7px;

        font-size: 13px;

        color: #374151;
    }

    .filter-checkbox input {
        accent-color: #6366f1;
    }

    .filter-actions {
        display: flex;

        gap: 9px;

        flex-wrap: wrap;

        margin-top: 18px;
    }

    .btn {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 10px 15px;

        border-radius: 9px;

        text-decoration: none;

        border: none;

        cursor: pointer;

        font-size: 13px;

        font-weight: 700;
    }

    .btn-search {
        background: #111827;
        color: #fff;
    }

    .btn-reset {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-export {
        background: #166534;
        color: #fff;
    }

    /*
    |--------------------------------------------------------------------------
    | Filtered Summary
    |--------------------------------------------------------------------------
    */

    .filtered-summary {
        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 15px;

        margin-bottom: 22px;
    }

    .summary-card {
        background: #f9fafb;

        border: 1px solid #e5e7eb;

        border-radius: 13px;

        padding: 16px;
    }

    .summary-card span {
        display: block;

        color: #6b7280;

        font-size: 12px;

        margin-bottom: 5px;
    }

    .summary-card strong {
        color: #111827;

        font-size: 19px;
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Actions
    |--------------------------------------------------------------------------
    */

    .bulk-bar {
        background: #f9fafb;

        border:
            1px solid #e5e7eb;

        border-radius: 12px;

        padding: 13px;

        margin-bottom: 15px;

        display: flex;

        align-items: center;

        gap: 10px;

        flex-wrap: wrap;
    }

    .bulk-bar select {
        padding: 8px 10px;

        border:
            1px solid #d1d5db;

        border-radius: 8px;
    }

    .bulk-delete {
        background: #dc2626;
        color: #fff;
    }

    .bulk-status {
        background: #4f46e5;
        color: #fff;
    }

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    .table-card {
        background: #fff;

        border:
            1px solid #e5e7eb;

        border-radius: 17px;

        overflow: hidden;

        box-shadow:
            0 7px 20px rgba(15,23,42,.05);
    }

    .products-table {
        width: 100%;

        border-collapse: collapse;
    }

    .products-table th {
        padding: 14px;

        background: #f9fafb;

        color: #6b7280;

        font-size: 11px;

        text-transform: uppercase;

        letter-spacing: .4px;

        text-align: left;

        border-bottom:
            1px solid #e5e7eb;
    }

    .products-table td {
        padding: 14px;

        color: #374151;

        font-size: 13px;

        border-bottom:
            1px solid #f0f1f3;

        vertical-align: middle;
    }

    .products-table tr:last-child td {
        border-bottom: none;
    }

    .product-name {
        color: #111827;

        font-weight: 700;
    }

    .product-category {
        display: inline-flex;

        padding: 5px 8px;

        border-radius: 7px;

        background: #f3f4f6;

        font-size: 11px;

        font-weight: 600;
    }

    .status {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 5px 8px;

        border-radius: 7px;

        font-size: 11px;

        font-weight: 700;
    }

    .status.active {
        background: #ecfdf5;
        color: #166534;
    }

    .status.inactive {
        background: #f3f4f6;
        color: #4b5563;
    }

    .stock-low {
        color: #d97706;
        font-weight: 700;
    }

    .stock-out {
        color: #dc2626;
        font-weight: 700;
    }

    .featured {
        color: #ca8a04;
        font-weight: 700;
    }

    /*
    |--------------------------------------------------------------------------
    | Action Buttons
    |--------------------------------------------------------------------------
    */

    .action-group {
        display: flex;

        gap: 6px;

        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;

        padding: 6px 9px;

        border-radius: 7px;

        text-decoration: none;

        border: none;

        cursor: pointer;

        font-size: 11px;

        font-weight: 700;
    }

    .edit-btn {
        background: #eef2ff;
        color: #4338ca;
    }

    .duplicate-btn {
        background: #ecfeff;
        color: #0e7490;
    }

    .delete-btn {
        background: #fef2f2;
        color: #dc2626;
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    .pagination-wrapper {
        padding: 20px;

        display: flex;

        justify-content: center;
    }

    .pagination-wrapper nav {
        display: flex;
        gap: 5px;
    }

    .pagination-wrapper a,
    .pagination-wrapper span {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-width: 34px;
        height: 34px;

        padding: 0 9px;

        border-radius: 7px;

        text-decoration: none;

        font-size: 12px;

        border:
            1px solid #e5e7eb;

        color: #374151;

        background: #fff;
    }

    .pagination-wrapper .active span {
        background: #111827;
        color: #fff;
        border-color: #111827;
    }

    /*
    |--------------------------------------------------------------------------
    | Empty
    |--------------------------------------------------------------------------
    */

    .empty-state {
        padding: 50px 20px;

        text-align: center;

        color: #6b7280;
    }

    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1000px) {

        .stats-grid {
            grid-template-columns:
                repeat(2, 1fr);
        }

        .filter-grid {
            grid-template-columns:
                repeat(2, 1fr);
        }

        .products-table {
            min-width: 1000px;
        }

        .table-card {
            overflow-x: auto;
        }
    }

    @media (max-width: 650px) {

        .products-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .add-product-btn {
            width: 100%;
        }

        .stats-grid,
        .filtered-summary,
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }

</style>


<div class="products-page">

    {{-- Header --}}
    <div class="products-header">

        <div>

            <h2>
                Product Management
            </h2>

            <p>
                Manage products, inventory, status and pricing.
            </p>

        </div>

        <div class="d-flex gap-2 flex-wrap">

            <a
                href="{{ route('products.formStudio') }}"
                class="add-product-btn"
                style="background: #e0e7ff; color: #3730a3;"
            >
                📝 Form Studio
            </a>

            <a
                href="{{ route('products.variantMatrix') }}"
                class="add-product-btn"
                style="background: #fae8ff; color: #86198f;"
            >
                📁 Image & Matrix Studio
            </a>

            <a
                href="{{ route('products.create') }}"
                class="add-product-btn"
            >
                + Add Product
            </a>

        </div>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    {{-- Statistics --}}
    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-label">
                Total Products
            </div>

            <div class="stat-value">
                {{ number_format($totalProducts) }}
            </div>

            <div class="stat-small">
                All products
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Inventory Value
            </div>

            <div class="stat-value">
                ₹{{ number_format($totalInventoryValue) }}
            </div>

            <div class="stat-small">
                Price × stock
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Average Price
            </div>

            <div class="stat-value">
                ₹{{ number_format($averagePrice ?? 0) }}
            </div>

            <div class="stat-small">
                Average product price
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Featured Products
            </div>

            <div class="stat-value">
                {{ number_format($featuredProducts) }}
            </div>

            <div class="stat-small">
                Featured catalog items
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Active Products
            </div>

            <div class="stat-value">
                {{ number_format($activeProducts) }}
            </div>

            <div class="stat-small">
                Currently active
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Inactive Products
            </div>

            <div class="stat-value">
                {{ number_format($inactiveProducts) }}
            </div>

            <div class="stat-small">
                Currently inactive
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Low Stock
            </div>

            <div class="stat-value">
                {{ number_format($lowStockProducts) }}
            </div>

            <div class="stat-small">
                1–5 units remaining
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Out Of Stock
            </div>

            <div class="stat-value">
                {{ number_format($outOfStockProducts) }}
            </div>

            <div class="stat-small">
                Zero inventory
            </div>

        </div>

    </div>


    {{-- Filters --}}
    <div class="filter-card">

        <div class="filter-title">
            Search & Advanced Filters
        </div>


        <form
            method="GET"
            action="{{ route('products.index') }}"
        >

            <div class="filter-grid">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, category or description..."
                >


                <select name="category">

                    <option value="">
                        All Categories
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category }}"
                            {{ request('category') == $category ? 'selected' : '' }}
                        >
                            {{ $category }}
                        </option>

                    @endforeach

                </select>


                <select name="status">

                    <option value="">
                        All Status
                    </option>

                    <option
                        value="active"
                        {{ request('status') == 'active' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        {{ request('status') == 'inactive' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>


                <input
                    type="number"
                    name="min_price"
                    value="{{ request('min_price') }}"
                    min="0"
                    placeholder="Min price"
                >


                <input
                    type="number"
                    name="max_price"
                    value="{{ request('max_price') }}"
                    min="0"
                    placeholder="Max price"
                >

            </div>


            <div class="filter-checkboxes">

                <label class="filter-checkbox">

                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        {{ request('featured') ? 'checked' : '' }}
                    >

                    Featured only

                </label>


                <label class="filter-checkbox">

                    <input
                        type="checkbox"
                        name="low_stock"
                        value="1"
                        {{ request('low_stock') ? 'checked' : '' }}
                    >

                    Low stock

                </label>


                <label class="filter-checkbox">

                    <input
                        type="checkbox"
                        name="out_of_stock"
                        value="1"
                        {{ request('out_of_stock') ? 'checked' : '' }}
                    >

                    Out of stock

                </label>

            </div>


            <div
                class="filter-actions"
            >

                <button
                    type="submit"
                    class="btn btn-search"
                >
                    Apply Filters
                </button>


                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-reset"
                >
                    Reset
                </a>


                <a
                    href="{{ route('products.export', request()->query()) }}"
                    class="btn btn-export"
                >
                    Export CSV
                </a>

            </div>

        </form>

    </div>


    {{-- Sorting --}}
    <div class="filter-card">

        <div class="filter-title">
            Sort Products
        </div>


        <form
            method="GET"
            action="{{ route('products.index') }}"
        >

            @foreach(request()->except(['sort', 'direction', 'page']) as $key => $value)

                @if(is_array($value))

                    @foreach($value as $item)

                        <input
                            type="hidden"
                            name="{{ $key }}[]"
                            value="{{ $item }}"
                        >

                    @endforeach

                @else

                    <input
                        type="hidden"
                        name="{{ $key }}"
                        value="{{ $value }}"
                    >

                @endif

            @endforeach


            <div class="filter-grid">

                <select name="sort">

                    <option
                        value="created_at"
                        {{ $sort == 'created_at' ? 'selected' : '' }}
                    >
                        Date
                    </option>

                    <option
                        value="name"
                        {{ $sort == 'name' ? 'selected' : '' }}
                    >
                        Product Name
                    </option>

                    <option
                        value="price"
                        {{ $sort == 'price' ? 'selected' : '' }}
                    >
                        Price
                    </option>

                    <option
                        value="stock"
                        {{ $sort == 'stock' ? 'selected' : '' }}
                    >
                        Stock
                    </option>

                    <option
                        value="id"
                        {{ $sort == 'id' ? 'selected' : '' }}
                    >
                        Product ID
                    </option>

                </select>


                <select name="direction">

                    <option
                        value="desc"
                        {{ $direction == 'desc' ? 'selected' : '' }}
                    >
                        Descending
                    </option>

                    <option
                        value="asc"
                        {{ $direction == 'asc' ? 'selected' : '' }}
                    >
                        Ascending
                    </option>

                </select>


                <button
                    type="submit"
                    class="btn btn-search"
                >
                    Apply Sorting
                </button>

            </div>

        </form>

    </div>


    {{-- Filtered Summary --}}
    <div class="filtered-summary">

        <div class="summary-card">

            <span>
                Filtered Products
            </span>

            <strong>
                {{ number_format($filteredProductsCount) }}
            </strong>

        </div>


        <div class="summary-card">

            <span>
                Filtered Inventory Value
            </span>

            <strong>
                ₹{{ number_format($filteredInventoryValue) }}
            </strong>

        </div>

    </div>


    {{-- Bulk Actions --}}
    <form
        id="bulkForm"
        method="POST"
    >

        @csrf


        <div class="bulk-bar">

            <strong>
                Bulk Actions:
            </strong>


            <button
                type="button"
                class="btn bulk-status"
                onclick="submitBulkStatus('active')"
            >
                Activate Selected
            </button>


            <button
                type="button"
                class="btn bulk-status"
                onclick="submitBulkStatus('inactive')"
            >
                Deactivate Selected
            </button>


            <button
                type="button"
                class="btn bulk-delete"
                onclick="submitBulkDelete()"
            >
                Delete Selected
            </button>

        </div>


        {{-- Product Table --}}
        <div class="table-card">

            @if($products->count())

                <table class="products-table">

                    <thead>

                        <tr>

                            <th>
                                <input
                                    type="checkbox"
                                    id="selectAll"
                                >
                            </th>

                            <th>
                                ID
                            </th>

                            <th>
                                Product
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Stock
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Featured
                            </th>

                            <th>
                                Inventory Value
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($products as $product)

                            <tr>

                                <td>

                                    <input
                                        type="checkbox"
                                        name="product_ids[]"
                                        value="{{ $product->id }}"
                                        class="product-checkbox"
                                    >

                                </td>


                                <td>
                                    #{{ $product->id }}
                                </td>


                                <td>

                                    <div class="product-name">
                                        {{ $product->name }}
                                    </div>

                                    @if($product->description)

                                        <small>
                                            {{ \Illuminate\Support\Str::limit(
                                                $product->description,
                                                45
                                            ) }}
                                        </small>

                                    @endif

                                </td>


                                <td>

                                    <span class="product-category">
                                        {{ $product->category }}
                                    </span>

                                </td>


                                <td>

                                    ₹{{ number_format($product->price) }}

                                </td>


                                <td>

                                    @if($product->stock == 0)

                                        <span class="stock-out">
                                            Out of Stock
                                        </span>

                                    @elseif($product->stock <= 5)

                                        <span class="stock-low">
                                            {{ $product->stock }}
                                            Low
                                        </span>

                                    @else

                                        {{ number_format($product->stock) }}

                                    @endif

                                </td>


                                <td>

                                    <span
                                        class="status {{ $product->status }}"
                                    >

                                        ●

                                        {{ ucfirst($product->status) }}

                                    </span>

                                </td>


                                <td>

                                    @if($product->is_featured)

                                        <span class="featured">
                                            ★ Featured
                                        </span>

                                    @else

                                        <span>
                                            —
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    ₹{{ number_format(
                                        $product->price *
                                        $product->stock
                                    ) }}

                                </td>


                                <td>

                                    <div class="action-group">

                                        <a
                                            href="{{ route(
                                                'products.edit',
                                                $product
                                            ) }}"
                                            class="action-btn edit-btn"
                                        >
                                            Edit
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'products.duplicate',
                                                $product
                                            ) }}"
                                            style="display:inline"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="action-btn duplicate-btn"
                                                onclick="return confirm(
                                                    'Duplicate this product?'
                                                )"
                                            >
                                                Duplicate
                                            </button>

                                        </form>


                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'products.destroy',
                                                $product
                                            ) }}"
                                            style="display:inline"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete-btn"
                                                onclick="return confirm(
                                                    'Are you sure you want to delete this product?'
                                                )"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>


                {{-- Numeric Pagination --}}
                <div class="pagination-wrapper">

                    {{ $products->onEachSide(1)->links('pagination::simple-tailwind') }}

                </div>

            @else

                <div class="empty-state">

                    <h3>
                        No Products Found
                    </h3>

                    <p>
                        Try changing your search or filters.
                    </p>

                </div>

            @endif

        </div>

    </form>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | Select All
    |--------------------------------------------------------------------------
    */

    const selectAll =
        document.getElementById('selectAll');

    if (selectAll) {

        selectAll.addEventListener(
            'change',
            function () {

                document
                    .querySelectorAll('.product-checkbox')
                    .forEach(function (checkbox) {

                        checkbox.checked =
                            selectAll.checked;

                    });

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    function submitBulkDelete()
    {
        const selected =
            document.querySelectorAll(
                '.product-checkbox:checked'
            );

        if (selected.length === 0) {

            alert(
                'Please select at least one product.'
            );

            return;
        }

        if (!confirm(
            'Are you sure you want to delete the selected products?'
        )) {

            return;
        }

        const form =
            document.getElementById('bulkForm');

        form.action =
            "{{ route('products.bulkDestroy') }}";

        form.submit();
    }


    /*
    |--------------------------------------------------------------------------
    | Bulk Status
    |--------------------------------------------------------------------------
    */

    function submitBulkStatus(status)
    {
        const selected =
            document.querySelectorAll(
                '.product-checkbox:checked'
            );

        if (selected.length === 0) {

            alert(
                'Please select at least one product.'
            );

            return;
        }

        const form =
            document.getElementById('bulkForm');

        form.action =
            "{{ route('products.bulkStatus') }}";


        const statusInput =
            document.createElement('input');

        statusInput.type = 'hidden';

        statusInput.name = 'status';

        statusInput.value = status;

        form.appendChild(statusInput);

        form.submit();
    }

</script>

@endsection
