@extends('layout')

@section('content')

<style>
    .product-edit-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 10px 0 40px;
    }

    /* Header */
    .edit-header {
        background: linear-gradient(135deg, #111827 0%, #1f2937 55%, #374151 100%);
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

    .header-content {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .header-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .edit-header h2 {
        margin: 0 0 5px;
        font-size: 27px;
        font-weight: 700;
        letter-spacing: -0.4px;
    }

    .edit-header p {
        margin: 0;
        color: #d1d5db;
        font-size: 14px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 17px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.18);
        color: #fff;
        transform: translateY(-1px);
    }

    /* Main layout */
    .edit-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 300px;
        gap: 25px;
        align-items: start;
    }

    /* Form card */
    .form-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .form-card-header {
        padding: 22px 25px;
        border-bottom: 1px solid #eef0f3;
        background: #fafafa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .form-card-header h3 {
        margin: 0 0 4px;
        font-size: 18px;
        color: #111827;
        font-weight: 700;
    }

    .form-card-header p {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
    }

    .product-id {
        padding: 7px 11px;
        background: #f3f4f6;
        border-radius: 8px;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .form-body {
        padding: 28px 25px;
    }

    /* Form sections */
    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f1f3;
        color: #111827;
        font-size: 15px;
        font-weight: 700;
    }

    .section-number {
        width: 27px;
        height: 27px;
        border-radius: 8px;
        background: #111827;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .field {
        margin-bottom: 20px;
    }

    .field:last-child {
        margin-bottom: 0;
    }

    .field-label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
    }

    .required-mark {
        color: #dc2626;
        margin-left: 2px;
    }

    /* Inputs */
    .form-section input:not([type="radio"]):not([type="checkbox"]),
    .form-section select,
    .form-section textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 11px 13px;
        font-size: 14px;
        color: #111827;
        background: #fff;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-section input:not([type="radio"]):not([type="checkbox"]):focus,
    .form-section select:focus,
    .form-section textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.10);
    }

    .form-section textarea {
        min-height: 125px;
        resize: vertical;
    }

    /* Status */
    .status-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .status-option {
        position: relative;
        margin: 0;
    }

    .status-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .status-card {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 11px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .status-card:hover {
        border-color: #c7d2fe;
        background: #f9fafb;
    }

    .status-option input:checked + .status-card {
        border-color: #6366f1;
        background: #eef2ff;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.08);
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-dot.active {
        background: #22c55e;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
    }

    .status-dot.inactive {
        background: #9ca3af;
        box-shadow: 0 0 0 4px rgba(156, 163, 175, 0.12);
    }

    .status-text strong {
        display: block;
        font-size: 13px;
        color: #111827;
        margin-bottom: 2px;
    }

    .status-text small {
        color: #6b7280;
        font-size: 11px;
    }

    /* Featured */
    .featured-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 11px;
        background: #fafafa;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .featured-box:hover {
        border-color: #c7d2fe;
        background: #f9fafb;
    }

    .featured-box input[type="checkbox"] {
        width: 19px;
        height: 19px;
        accent-color: #6366f1;
        cursor: pointer;
        flex-shrink: 0;
    }

    .featured-content strong {
        display: block;
        font-size: 13px;
        color: #111827;
        margin-bottom: 2px;
    }

    .featured-content span {
        font-size: 11px;
        color: #6b7280;
    }

    /* Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding: 20px 25px;
        background: #fafafa;
        border-top: 1px solid #eef0f3;
    }

    .btn-update {
        border: none;
        border-radius: 10px;
        padding: 11px 20px;
        background: #111827;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-update:hover {
        background: #1f2937;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(17, 24, 39, 0.18);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 18px;
        border-radius: 10px;
        background: #fff;
        color: #374151;
        border: 1px solid #d1d5db;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-cancel:hover {
        background: #f9fafb;
        color: #111827;
    }

    /* Sidebar */
    .info-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        margin-bottom: 18px;
    }

    .info-card:last-child {
        margin-bottom: 0;
    }

    .info-card h4 {
        margin: 0 0 18px;
        color: #111827;
        font-size: 15px;
        font-weight: 700;
    }

    .info-item {
        display: flex;
        gap: 11px;
        margin-bottom: 17px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        width: 31px;
        height: 31px;
        border-radius: 9px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }

    .info-item strong {
        display: block;
        color: #374151;
        font-size: 12px;
        margin-bottom: 3px;
    }

    .info-item span {
        color: #6b7280;
        font-size: 11px;
        line-height: 1.4;
    }

    /* Current status */
    .current-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        background: #f3f4f6;
        color: #374151;
    }

    .current-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #9ca3af;
    }

    .current-status.active {
        background: #ecfdf5;
        color: #166534;
    }

    .current-status.active .current-status-dot {
        background: #22c55e;
    }

    .current-status.inactive {
        background: #f3f4f6;
        color: #4b5563;
    }

    /* Validation */
    .validation-alert {
        margin: 25px 25px 0;
        padding: 15px 18px;
        border: 1px solid #fecaca;
        background: #fef2f2;
        border-radius: 11px;
        color: #991b1b;
        font-size: 13px;
    }

    .validation-alert strong {
        display: block;
        margin-bottom: 8px;
    }

    .validation-alert ul {
        margin: 0;
        padding-left: 20px;
    }

    /* Responsive */
    @media (max-width: 900px) {

        .edit-grid {
            grid-template-columns: 1fr;
        }

        .info-sidebar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info-card {
            margin-bottom: 0;
        }
    }

    @media (max-width: 650px) {

        .product-edit-page {
            padding: 5px 0 25px;
        }

        .edit-header {
            padding: 22px;
            flex-direction: column;
            align-items: flex-start;
        }

        .back-button {
            width: 100%;
            justify-content: center;
        }

        .field-row,
        .status-options,
        .info-sidebar {
            grid-template-columns: 1fr;
        }

        .form-body {
            padding: 22px 18px;
        }

        .form-card-header {
            padding: 20px;
            align-items: flex-start;
            flex-direction: column;
        }

        .form-actions {
            padding: 18px;
            flex-direction: column-reverse;
        }

        .btn-update,
        .btn-cancel {
            width: 100%;
            text-align: center;
        }

        .validation-alert {
            margin: 20px 18px 0;
        }
    }
</style>

<div class="product-edit-page">


{{-- Page Header --}}
<div class="edit-header">

    <div class="header-content">

        <div class="header-icon">
            ✎
        </div>

        <div>

            <h2>
                Edit Product
            </h2>

            <p>
                Update and manage your product information.
            </p>

        </div>

    </div>


    <a
        href="{{ route('products.index') }}"
        class="back-button"
    >
        ← Back to Products
    </a>

</div>


{{-- Main Grid --}}
<div class="edit-grid">

    {{-- Form Card --}}
    <div class="form-card">

        <div class="form-card-header">

            <div>

                <h3>
                    Product Information
                </h3>

                <p>
                    Modify the details of this product below.
                </p>

            </div>


            <div class="product-id">
                PRODUCT #{{ $product->id }}
            </div>

        </div>


        {{ Aire::open()
            ->route('products.update', $product->id)
            ->method('PUT')
            ->rules([
                'name' => 'required|min:2|max:255',
                'price' => 'required|integer|min:1',
                'category' => 'required',
                'stock' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive',
                'description' => 'nullable|max:2000',
            ])
        }}


        @if($errors->any())

            <div class="validation-alert">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <div class="form-body">

            {{-- Basic Information --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        1
                    </span>

                    Basic Information

                </div>


                <div class="field">

                    <label class="field-label">

                        Product Name

                        <span class="required-mark">
                            *
                        </span>

                    </label>


                    {{ Aire::input('name')
                        ->value(old('name', $product->name))
                        ->required()
                    }}

                </div>


                <div class="field-row">

                    <div class="field">

                        <label class="field-label">

                            Price

                            <span class="required-mark">
                                *
                            </span>

                        </label>


                        {{ Aire::number('price')
                            ->min(1)
                            ->value(old('price', $product->price))
                            ->required()
                        }}

                    </div>


                    <div class="field">

                        <label class="field-label">

                            Category

                            <span class="required-mark">
                                *
                            </span>

                        </label>


                        {{ Aire::select(
                            [
                                '' => 'Select Category',
                                'Electronics' => 'Electronics',
                                'Clothing' => 'Clothing',
                                'Books' => 'Books',
                                'Home & Kitchen' => 'Home & Kitchen',
                                'Sports' => 'Sports',
                                'Other' => 'Other',
                            ],
                            'category',
                            'Category'
                        )
                            ->value(old('category', $product->category))
                            ->required()
                        }}

                    </div>

                </div>

            </div>


            {{-- Inventory --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        2
                    </span>

                    Inventory & Availability

                </div>


                <div class="field">

                    <label class="field-label">

                        Stock Quantity

                        <span class="required-mark">
                            *
                        </span>

                    </label>


                    {{ Aire::number('stock')
                        ->min(0)
                        ->value(old('stock', $product->stock))
                        ->required()
                    }}

                </div>


                <div class="field">

                    <label class="field-label">

                        Product Status

                        <span class="required-mark">
                            *
                        </span>

                    </label>


                    <div class="status-options">

                        {{-- Active --}}
                        <label class="status-option">

                            <input
                                type="radio"
                                name="status"
                                value="active"
                                {{ old('status', $product->status) === 'active' ? 'checked' : '' }}
                            >

                            <div class="status-card">

                                <span class="status-dot active"></span>

                                <div class="status-text">

                                    <strong>
                                        Active
                                    </strong>

                                    <small>
                                        Available in catalog
                                    </small>

                                </div>

                            </div>

                        </label>


                        {{-- Inactive --}}
                        <label class="status-option">

                            <input
                                type="radio"
                                name="status"
                                value="inactive"
                                {{ old('status', $product->status) === 'inactive' ? 'checked' : '' }}
                            >

                            <div class="status-card">

                                <span class="status-dot inactive"></span>

                                <div class="status-text">

                                    <strong>
                                        Inactive
                                    </strong>

                                    <small>
                                        Hidden from catalog
                                    </small>

                                </div>

                            </div>

                        </label>

                    </div>

                </div>


                {{-- Featured --}}
                <div class="field">

                    <label class="field-label">
                        Featured Product
                    </label>


                    <label class="featured-box">

                        <input
                            type="checkbox"
                            name="is_featured"
                            value="1"
                            {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                        >


                        <div class="featured-content">

                            <strong>
                                Mark this product as featured
                            </strong>

                            <span>
                                Featured products can be highlighted on your catalog.
                            </span>

                        </div>

                    </label>

                </div>

            </div>


            {{-- Description --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="section-number">
                        3
                    </span>

                    Product Description

                </div>


                <div class="field">

                    <label class="field-label">
                        Description
                    </label>


                    {{ Aire::textarea('description')
                        ->value(old('description', $product->description))
                        ->placeholder('Write a short description about this product...')
                        ->rows(5)
                    }}

                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="form-actions">

            <a
                href="{{ route('products.index') }}"
                class="btn-cancel"
            >
                Cancel
            </a>


            {{ Aire::submit('Update Product')
                ->addClass('btn-update')
            }}

        </div>


        {{ Aire::close() }}

    </div>


    {{-- Sidebar --}}
    <div class="info-sidebar">

        {{-- Current Product --}}
        <div class="info-card">

            <h4>
                Current Product
            </h4>


            <div class="info-item">

                <div class="info-icon">
                    #
                </div>

                <div>

                    <strong>
                        Product ID
                    </strong>

                    <span>
                        #{{ $product->id }}
                    </span>

                </div>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    $
                </div>

                <div>

                    <strong>
                        Current Price
                    </strong>

                    <span>
                        ₹{{ number_format($product->price) }}
                    </span>

                </div>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    📦
                </div>

                <div>

                    <strong>
                        Current Stock
                    </strong>

                    <span>
                        {{ number_format($product->stock ?? 0) }} units
                    </span>

                </div>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    ●
                </div>

                <div>

                    <strong>
                        Current Status
                    </strong>

                    <span>

                        <span class="current-status {{ $product->status }}">

                            <span class="current-status-dot"></span>

                            {{ ucfirst($product->status ?? 'active') }}

                        </span>

                    </span>

                </div>

            </div>

        </div>


        {{-- Update Tips --}}
        <div class="info-card">

            <h4>
                Update Tips
            </h4>


            <div class="info-item">

                <div class="info-icon">
                    ✓
                </div>

                <div>

                    <strong>
                        Keep Information Accurate
                    </strong>

                    <span>
                        Make sure price, category and stock reflect the latest information.
                    </span>

                </div>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    ●
                </div>

                <div>

                    <strong>
                        Product Status
                    </strong>

                    <span>
                        Use Active when the product should remain available in the catalog.
                    </span>

                </div>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    ★
                </div>

                <div>

                    <strong>
                        Featured Product
                    </strong>

                    <span>
                        Enable featured status when you want to highlight this product.
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

@endsection
