@extends('layout')

@section('content')

<style>
    .product-dashboard {
        max-width: 1250px;
        margin: 0 auto;
        padding: 10px 0 40px;
    }

    /* =========================
       Dashboard Header
    ========================= */

    .dashboard-header {
        background: linear-gradient(
            135deg,
            #111827 0%,
            #1f2937 55%,
            #374151 100%
        );
        border-radius: 20px;
        padding: 30px;
        color: #fff;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        box-shadow: 0 15px 35px rgba(17, 24, 39, 0.15);
    }

    .dashboard-title {
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .dashboard-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .dashboard-header h2 {
        margin: 0 0 5px;
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .dashboard-header p {
        margin: 0;
        color: #d1d5db;
        font-size: 14px;
    }

    .add-product-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 18px;
        background: #fff;
        color: #111827;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .add-product-btn:hover {
        color: #111827;
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0, 0, 0, 0.15);
    }

    /* =========================
       Success Message
    ========================= */

    .success-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 12px;
        padding: 13px 16px;
        margin-bottom: 25px;
        font-size: 13px;
        font-weight: 600;
    }

    .success-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #22c55e;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    /* =========================
       Statistics
    ========================= */

    .stats-title {
        margin-bottom: 14px;
        color: #111827;
        font-size: 16px;
        font-weight: 700;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.05);
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
    }

    .stat-card::after {
        content: "";
        position: absolute;
        right: -25px;
        top: -25px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f3f4f6;
        opacity: 0.8;
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .stat-title {
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        margin: 0;
    }

    .stat-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        position: relative;
        z-index: 3;
    }

    .stat-value {
        color: #111827;
        font-size: 25px;
        font-weight: 800;
        margin-top: 10px;
        position: relative;
        z-index: 2;
        letter-spacing: -0.5px;
    }

    .stat-description {
        color: #9ca3af;
        font-size: 10px;
        margin-top: 5px;
        position: relative;
        z-index: 2;
    }

    /* =========================
       Filter Card
    ========================= */

    .filter-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 23px;
        margin-bottom: 25px;
        box-shadow: 0 7px 22px rgba(15, 23, 42, 0.05);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-header h3 {
        margin: 0 0 4px;
        font-size: 17px;
        color: #111827;
    }

    .filter-header p {
        margin: 0;
        color: #6b7280;
        font-size: 12px;
    }

    .filter-badge {
        background: #f3f4f6;
        color: #4b5563;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
        gap: 13px;
    }

    .filter-field label {
        display: block;
        margin-bottom: 7px;
        color: #374151;
        font-size: 11px;
        font-weight: 700;
    }

    .filter-field input,
    .filter-field select {
        width: 100%;
        height: 42px;
        padding: 0 12px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        background: #fff;
        color: #111827;
        font-size: 12px;
        outline: none;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .filter-field input:focus,
    .filter-field select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.10);
    }

    .featured-filter {
        display: flex;
        align-items: flex-end;
        padding-bottom: 1px;
    }

    .featured-filter label {
        width: 100%;
        min-height: 42px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 12px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        background: #fff;
        color: #374151;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        box-sizing: border-box;
    }

    .featured-filter input {
        width: 16px;
        height: 16px;
        accent-color: #6366f1;
        cursor: pointer;
    }

    .filter-actions {
        display: flex;
        gap: 9px;
        margin-top: 17px;
    }

    .btn-filter {
        border: none;
        border-radius: 9px;
        padding: 10px 17px;
        background: #111827;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-filter:hover {
        background: #1f2937;
        color: #fff;
    }

    .btn-reset {
        border: 1px solid #d1d5db;
        border-radius: 9px;
        padding: 10px 17px;
        background: #fff;
        color: #374151;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-reset:hover {
        background: #f9fafb;
        color: #111827;
    }

    /* =========================
       Table
    ========================= */

    .table-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 7px 22px rgba(15, 23, 42, 0.05);
    }

    .table-header {
        padding: 20px 23px;
        border-bottom: 1px solid #eef0f3;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .table-header h3 {
        margin: 0;
        color: #111827;
        font-size: 17px;
    }

    .table-count {
        color: #6b7280;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 6px 9px;
        font-size: 10px;
        font-weight: 700;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    thead {
        background: #f9fafb;
    }

    th {
        padding: 13px 16px;
        text-align: left;
        color: #6b7280;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 800;
        border-bottom: 1px solid #eef0f3;
    }

    td {
        padding: 15px 16px;
        color: #374151;
        font-size: 12px;
        border-bottom: 1px solid #f0f1f3;
        vertical-align: middle;
    }

    tbody tr {
        transition: background 0.15s ease;
    }

    tbody tr:hover {
        background: #fafafa;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .product-id {
        color: #9ca3af;
        font-size: 11px;
        font-weight: 700;
    }

    .product-name {
        color: #111827;
        font-size: 13px;
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
    }

    .description {
        display: block;
        color: #9ca3af;
        font-size: 10px;
        max-width: 240px;
    }

    .category-badge {
        display: inline-flex;
        padding: 5px 8px;
        border-radius: 7px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 10px;
        font-weight: 700;
    }

    .price {
        color: #111827;
        font-weight: 800;
        white-space: nowrap;
    }

    .stock-number {
        font-weight: 700;
        color: #374151;
    }

    /* =========================
       Status Badges
    ========================= */

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-success {
        background: #ecfdf5;
        color: #166534;
    }

    .badge-success::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #22c55e;
    }

    .badge-warning {
        background: #fffbeb;
        color: #92400e;
    }

    .badge-warning::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f59e0b;
    }

    .badge-danger {
        background: #fef2f2;
        color: #991b1b;
    }

    .badge-danger::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #ef4444;
    }

    .badge-featured {
        background: #fff7ed;
        color: #c2410c;
    }

    /* =========================
       Action Buttons
    ========================= */

    .actions {
        white-space: nowrap;
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 10px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .edit-btn {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .edit-btn:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .delete-btn {
        background: #fef2f2;
        color: #dc2626;
    }

    .delete-btn:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* =========================
       Empty State
    ========================= */

    .empty-state {
        padding: 55px 20px !important;
        text-align: center !important;
        color: #9ca3af !important;
    }

    .empty-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 20px;
    }

    .empty-state strong {
        display: block;
        color: #374151;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .empty-state span {
        font-size: 11px;
    }

    /* =========================
       Pagination
    ========================= */

    .pagination-wrapper {
        padding: 18px 23px;
        border-top: 1px solid #eef0f3;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .pagination-info {
        color: #9ca3af;
        font-size: 10px;
    }

    .pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .pagination nav > div:first-child {
        display: none;
    }

    .pagination nav > div:last-child {
        display: block;
    }

    .pagination nav a,
    .pagination nav span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        margin-left: 4px;
        padding: 0 8px;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        background: #fff;
        color: #4b5563;
        text-decoration: none;
        font-size: 10px;
    }

    .pagination nav a:hover {
        background: #f3f4f6;
        color: #111827;
    }

    .pagination nav span[aria-current="page"] {
        background: #111827;
        border-color: #111827;
        color: #fff;
    }

    /* =========================
       Responsive
    ========================= */

    @media (max-width: 1050px) {

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-field:first-child {
            grid-column: span 2;
        }
    }

    @media (max-width: 700px) {

        .product-dashboard {
            padding: 5px 0 25px;
        }

        .dashboard-header {
            padding: 22px;
            flex-direction: column;
            align-items: flex-start;
        }

        .add-product-btn {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-field:first-child {
            grid-column: span 1;
        }

        .filter-header {
            align-items: flex-start;
        }

        .filter-badge {
            display: none;
        }

        .filter-actions {
            flex-direction: column;
        }

        .btn-filter,
        .btn-reset {
            width: 100%;
            text-align: center;
        }

        .table-header {
            padding: 18px;
        }

        .pagination-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="product-dashboard">


{{-- =========================
     Dashboard Header
========================== --}}

<div class="dashboard-header">

    <div class="dashboard-title">

        <div class="dashboard-icon">
            ▦
        </div>

        <div>

            <h2>
                Product Management
            </h2>

            <p>
                Manage products, inventory, availability and featured items.
            </p>

        </div>

    </div>


    <a
        href="{{ route('products.create') }}"
        class="add-product-btn"
    >
        <span>+</span>
        Add Product
    </a>

</div>


{{-- =========================
     Success Message
========================== --}}

@if(session('success'))

    <div class="success-alert">

        <div class="success-icon">
            ✓
        </div>

        {{ session('success') }}

    </div>

@endif


{{-- =========================
     Statistics
========================== --}}

<div class="stats-title">
    Product Overview
</div>


<div class="stats-grid">

    {{-- Total Products --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                TOTAL PRODUCTS
            </div>

            <div class="stat-icon">
                📦
            </div>

        </div>

        <div class="stat-value">
            {{ $totalProducts }}
        </div>

        <div class="stat-description">
            Products in catalog
        </div>

    </div>


    {{-- Inventory Value --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                INVENTORY VALUE
            </div>

            <div class="stat-icon">
                ₹
            </div>

        </div>

        <div class="stat-value">
            ₹{{ number_format($totalInventoryValue ?? 0) }}
        </div>

        <div class="stat-description">
            Total stock value
        </div>

    </div>


    {{-- Average Price --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                AVERAGE PRICE
            </div>

            <div class="stat-icon">
                ≈
            </div>

        </div>

        <div class="stat-value">
            ₹{{ number_format($averagePrice ?? 0, 2) }}
        </div>

        <div class="stat-description">
            Average product price
        </div>

    </div>


    {{-- Highest Price --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                HIGHEST PRICE
            </div>

            <div class="stat-icon">
                ↑
            </div>

        </div>

        <div class="stat-value">
            ₹{{ number_format($highestPrice ?? 0) }}
        </div>

        <div class="stat-description">
            Most expensive product
        </div>

    </div>


    {{-- Lowest Price --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                LOWEST PRICE
            </div>

            <div class="stat-icon">
                ↓
            </div>

        </div>

        <div class="stat-value">
            ₹{{ number_format($lowestPrice ?? 0) }}
        </div>

        <div class="stat-description">
            Lowest product price
        </div>

    </div>


    {{-- Featured --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                FEATURED PRODUCTS
            </div>

            <div class="stat-icon">
                ★
            </div>

        </div>

        <div class="stat-value">
            {{ $featuredProducts }}
        </div>

        <div class="stat-description">
            Featured catalog items
        </div>

    </div>


    {{-- Active --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                ACTIVE PRODUCTS
            </div>

            <div class="stat-icon">
                ●
            </div>

        </div>

        <div class="stat-value">
            {{ $activeProducts }}
        </div>

        <div class="stat-description">
            Currently available
        </div>

    </div>


    {{-- Inactive --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                INACTIVE PRODUCTS
            </div>

            <div class="stat-icon">
                ○
            </div>

        </div>

        <div class="stat-value">
            {{ $inactiveProducts }}
        </div>

        <div class="stat-description">
            Currently unavailable
        </div>

    </div>


    {{-- Out Of Stock --}}
    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-title">
                OUT OF STOCK
            </div>

            <div class="stat-icon">
                !
            </div>

        </div>

        <div class="stat-value">
            {{ $outOfStockProducts }}
        </div>

        <div class="stat-description">
            Products requiring restock
        </div>

    </div>

</div>


{{-- =========================
     Search & Filters
========================== --}}

<div class="filter-card">

    <div class="filter-header">

        <div>

            <h3>
                Search & Filter Products
            </h3>

            <p>
                Quickly find products using multiple filter options.
            </p>

        </div>

        <span class="filter-badge">
            ADVANCED FILTERS
        </span>

    </div>


    <form
        method="GET"
        action="{{ route('products.index') }}"
    >

        <div class="filter-grid">

            {{-- Search --}}
            <div class="filter-field">

                <label>
                    Search Products
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, description or category..."
                >

            </div>


            {{-- Category --}}
            <div class="filter-field">

                <label>
                    Category
                </label>

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

            </div>


            {{-- Status --}}
            <div class="filter-field">

                <label>
                    Status
                </label>

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

            </div>


            {{-- Minimum Price --}}
            <div class="filter-field">

                <label>
                    Minimum Price
                </label>

                <input
                    type="number"
                    name="min_price"
                    value="{{ request('min_price') }}"
                    min="0"
                    placeholder="₹ Minimum"
                >

            </div>


            {{-- Maximum Price --}}
            <div class="filter-field">

                <label>
                    Maximum Price
                </label>

                <input
                    type="number"
                    name="max_price"
                    value="{{ request('max_price') }}"
                    min="0"
                    placeholder="₹ Maximum"
                >

            </div>


            {{-- Featured --}}
            <div class="featured-filter">

                <label>

                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        {{ request('featured') ? 'checked' : '' }}
                    >

                    Featured Only

                </label>

            </div>

        </div>


        <div class="filter-actions">

            <button
                type="submit"
                class="btn-filter"
            >
                Search & Filter
            </button>


            <a
                href="{{ route('products.index') }}"
                class="btn-reset"
            >
                Reset Filters
            </a>

        </div>

    </form>

</div>


{{-- =========================
     Product Table
========================== --}}

<div class="table-card">

    <div class="table-header">

        <h3>
            Product List
        </h3>


        <span class="table-count">

            Showing
            {{ $products->firstItem() ?? 0 }}
            -
            {{ $products->lastItem() ?? 0 }}
            of
            {{ $products->total() }}

        </span>

    </div>


    <div class="table-wrapper">

        <table>

            <thead>

            <tr>

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
                    Actions
                </th>

            </tr>

            </thead>


            <tbody>

            @forelse($products as $product)

                <tr>

                    {{-- ID --}}
                    <td>

                        <span class="product-id">
                            #{{ $product->id }}
                        </span>

                    </td>


                    {{-- Product --}}
                    <td>

                        <span class="product-name">
                            {{ $product->name }}
                        </span>


                        @if($product->description)

                            <span class="description">

                                {{ \Illuminate\Support\Str::limit(
                                    $product->description,
                                    55
                                ) }}

                            </span>

                        @endif

                    </td>


                    {{-- Category --}}
                    <td>

                        <span class="category-badge">

                            {{ $product->category ?? 'Other' }}

                        </span>

                    </td>


                    {{-- Price --}}
                    <td>

                        <span class="price">
                            ₹{{ number_format($product->price) }}
                        </span>

                    </td>


                    {{-- Stock --}}
                    <td>

                        @if($product->stock > 0)

                            <span class="stock-number">
                                {{ number_format($product->stock) }}
                            </span>

                        @else

                            <span class="badge badge-danger">
                                Out of Stock
                            </span>

                        @endif

                    </td>


                    {{-- Status --}}
                    <td>

                        @if($product->status === 'active')

                            <span class="badge badge-success">
                                Active
                            </span>

                        @else

                            <span class="badge badge-warning">
                                Inactive
                            </span>

                        @endif

                    </td>


                    {{-- Featured --}}
                    <td>

                        @if($product->is_featured)

                            <span class="badge badge-featured">
                                ★ Featured
                            </span>

                        @else

                            <span style="color:#9ca3af;">
                                —
                            </span>

                        @endif

                    </td>


                    {{-- Actions --}}
                    <td class="actions">

                        <div class="action-group">

                            <a
                                href="{{ route(
                                    'products.edit',
                                    $product->id
                                ) }}"
                                class="action-btn edit-btn"
                            >
                                Edit
                            </a>


                            <form
                                action="{{ route(
                                    'products.destroy',
                                    $product->id
                                ) }}"
                                method="POST"
                                style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="action-btn delete-btn"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="8"
                        class="empty-state"
                    >

                        <div class="empty-icon">
                            📦
                        </div>

                        <strong>
                            No products found
                        </strong>

                        <span>
                            Try changing your search or filter criteria.
                        </span>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if($products->hasPages())

        <div class="pagination-wrapper">

            <div class="pagination-info">

                Page
                {{ $products->currentPage() }}
                of
                {{ $products->lastPage() }}

            </div>


            <div class="pagination">

                {{ $products->links() }}

            </div>

        </div>

    @endif

</div>

</div>

@endsection
