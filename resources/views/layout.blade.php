<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Laravel 12 Aire Product Management')
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #1f2937;

            background:
                linear-gradient(
                    135deg,
                    #eef4ff 0%,
                    #f8fafc 45%,
                    #f3f4f6 100%
                );
        }

        /* ========================================
           MAIN CONTAINER
        ======================================== */

        .container {
            width: 94%;
            max-width: 1320px;

            margin: 30px auto;

            padding: 30px;

            background: #ffffff;

            border-radius: 18px;

            box-shadow:
                0 15px 40px rgba(15, 23, 42, 0.08),
                0 3px 10px rgba(15, 23, 42, 0.04);
        }

        /* ========================================
           TYPOGRAPHY
        ======================================== */

        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            color: #111827;
        }

        h1 {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 18px;
        }

        p {
            line-height: 1.6;
        }

        /* ========================================
           NAVIGATION
        ======================================== */

        .top-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;

            margin-bottom: 28px;
            padding: 16px 20px;

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #1e293b
                );

            border-radius: 12px;

            box-shadow:
                0 6px 18px rgba(15, 23, 42, 0.15);
        }

        .brand {
            color: #ffffff;
            text-decoration: none;

            font-size: 18px;
            font-weight: 800;
        }

        .brand-subtitle {
            color: #cbd5e1;

            font-size: 12px;
            font-weight: 500;

            margin-left: 8px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a {
            color: #e5e7eb;

            text-decoration: none;

            padding: 9px 13px;

            border-radius: 7px;

            font-size: 13px;
            font-weight: 600;

            transition:
                background 0.2s ease,
                color 0.2s ease;
        }

        .nav-links a:hover {
            background: #374151;
            color: #ffffff;
        }

        .nav-links a.active {
            background: #2563eb;
            color: #ffffff;
        }

        /* ========================================
           PAGE HEADER
        ======================================== */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;

            margin-bottom: 25px;
            padding-bottom: 20px;

            border-bottom: 1px solid #e5e7eb;
        }

        .page-header h2 {
            margin-bottom: 5px;
        }

        .page-header p {
            color: #6b7280;
            margin: 0;
        }

        /* ========================================
           BUTTONS
        ======================================== */

        .btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 10px 16px;

            border: none;
            border-radius: 8px;

            cursor: pointer;

            text-decoration: none;

            font-size: 14px;
            font-weight: 600;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;
        }

        .btn:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;

            box-shadow:
                0 4px 10px rgba(37, 99, 235, 0.20);
        }

        .btn-success {
            background: #16a34a;
            color: #ffffff;
        }

        .btn-danger {
            background: #dc2626;
            color: #ffffff;
        }

        .btn-warning {
            background: #d97706;
            color: #ffffff;
        }

        .btn-secondary {
            background: #64748b;
            color: #ffffff;
        }

        .btn-light {
            background: #f1f5f9;
            color: #334155;

            border: 1px solid #e2e8f0;
        }

        .btn-sm {
            padding: 7px 11px;

            font-size: 12px;

            border-radius: 6px;
        }

        /* ========================================
           STATISTICS
        ======================================== */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 16px;

            margin-bottom: 25px;
        }

        .stat-card {
            position: relative;

            padding: 20px;

            background: #ffffff;

            border:
                1px solid #e5e7eb;

            border-radius: 12px;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(15, 23, 42, 0.08);
        }

        .stat-title {
            margin-bottom: 8px;

            color: #6b7280;

            font-size: 12px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.4px;
        }

        .stat-value {
            color: #111827;

            font-size: 26px;
            font-weight: 800;
        }

        .stat-description {
            margin-top: 6px;

            color: #64748b;

            font-size: 12px;
        }

        .stat-card.primary {
            border-left: 4px solid #2563eb;
        }

        .stat-card.success {
            border-left: 4px solid #16a34a;
        }

        .stat-card.warning {
            border-left: 4px solid #d97706;
        }

        .stat-card.danger {
            border-left: 4px solid #dc2626;
        }

        /* ========================================
           FILTER CARD
        ======================================== */

        .filter-card {
            padding: 22px;

            margin-bottom: 25px;

            background: #f8fafc;

            border:
                1px solid #e2e8f0;

            border-radius: 12px;
        }

        .filter-card h3 {
            margin-bottom: 18px;
        }

        .filter-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 15px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            color: #374151;

            font-size: 14px;
            font-weight: 600;
        }

        input,
        textarea,
        select {
            width: 100%;

            padding: 11px 12px;

            margin-top: 5px;
            margin-bottom: 15px;

            background: #ffffff;

            color: #1f2937;

            border:
                1px solid #d1d5db;

            border-radius: 7px;

            font-size: 14px;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        input::placeholder,
        textarea::placeholder {
            color: #9ca3af;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;

            border-color: #2563eb;

            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, 0.10);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        /* ========================================
           QUICK FILTERS
        ======================================== */

        .quick-filters {
            display: flex;

            flex-wrap: wrap;

            gap: 10px;

            margin-top: 5px;
            margin-bottom: 15px;
        }

        .quick-filter {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 8px 12px;

            background: #ffffff;

            color: #475569;

            border:
                1px solid #cbd5e1;

            border-radius: 20px;

            font-size: 13px;
            font-weight: 600;

            cursor: pointer;
        }

        .quick-filter:hover {
            background: #f1f5f9;
        }

        .quick-filter input {
            width: auto;

            margin: 0;
        }

        .featured-filter {
            display: flex;

            align-items: center;

            padding-top: 27px;
        }

        .featured-filter label {
            margin: 0;

            font-weight: normal;

            cursor: pointer;
        }

        .featured-filter input {
            width: auto;

            margin:
                0 7px 0 0;
        }

        .filter-actions {
            display: flex;

            flex-wrap: wrap;

            gap: 10px;

            margin-top: 8px;
        }

        /* ========================================
           SORTING
        ======================================== */

        .sort-card {
            padding: 18px 20px;

            margin-bottom: 20px;

            background: #ffffff;

            border:
                1px solid #e5e7eb;

            border-radius: 12px;
        }

        .sort-card h3 {
            margin-bottom: 14px;
        }

        .sort-grid {
            display: grid;

            grid-template-columns:
                2fr 1fr auto;

            gap: 12px;

            align-items: end;
        }

        /* ========================================
           BULK ACTION BAR
        ======================================== */

        .bulk-action-bar {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 15px;

            padding: 14px 16px;

            margin-bottom: 15px;

            background: #eff6ff;

            border:
                1px solid #bfdbfe;

            border-radius: 10px;
        }

        .bulk-left {
            display: flex;

            align-items: center;

            gap: 10px;

            flex-wrap: wrap;
        }

        .bulk-right {
            display: flex;

            gap: 8px;

            flex-wrap: wrap;
        }

        .selected-count {
            color: #1d4ed8;

            font-size: 13px;
            font-weight: 700;
        }

        .bulk-action-bar.disabled {
            opacity: 0.65;
        }

        /* ========================================
           INVENTORY SUMMARY
        ======================================== */

        .inventory-summary {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 15px;

            margin-bottom: 20px;
        }

        .summary-card {
            padding: 18px;

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #ffffff
                );

            border:
                1px solid #e2e8f0;

            border-radius: 10px;
        }

        .summary-title {
            color: #64748b;

            font-size: 12px;
            font-weight: 700;

            text-transform: uppercase;

            margin-bottom: 6px;
        }

        .summary-value {
            color: #111827;

            font-size: 22px;
            font-weight: 800;
        }

        /* ========================================
           TABLE
        ======================================== */

        .table-card {
            overflow: hidden;

            background: #ffffff;

            border:
                1px solid #e5e7eb;

            border-radius: 12px;
        }

        .table-header {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 15px;

            padding: 18px 20px;

            background: #f8fafc;

            border-bottom:
                1px solid #e5e7eb;
        }

        .table-header h3 {
            margin: 0;
        }

        .table-header span {
            color: #6b7280;

            font-size: 13px;
        }

        .table-responsive {
            width: 100%;

            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 13px 12px;

            border-bottom:
                1px solid #e5e7eb;

            text-align: left;

            vertical-align: middle;
        }

        table th {
            background: #f8fafc;

            color: #475569;

            font-size: 12px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.3px;

            white-space: nowrap;
        }

        table td {
            color: #374151;

            font-size: 14px;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table tbody tr {
            transition:
                background 0.15s ease;
        }

        table tbody tr:hover {
            background: #f8fafc;
        }

        table tbody tr.selected {
            background: #eff6ff;
        }

        .product-name {
            color: #111827;

            font-weight: 700;
        }

        .description {
            display: block;

            margin-top: 4px;

            color: #6b7280;

            font-size: 12px;
        }

        .checkbox-cell {
            width: 45px;

            text-align: center;
        }

        .checkbox-cell input {
            width: 17px;
            height: 17px;

            margin: 0;

            cursor: pointer;
        }

        /* ========================================
           BADGES
        ======================================== */

        .badge {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-featured {
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        /* ========================================
           STOCK STATUS
        ======================================== */

        .stock-normal {
            color: #166534;

            font-weight: 700;
        }

        .stock-low {
            color: #b45309;

            font-weight: 800;
        }

        .stock-out {
            color: #b91c1c;

            font-weight: 800;
        }

        /* ========================================
           ACTION BUTTONS
        ======================================== */

        .action-buttons {
            display: flex;

            align-items: center;

            gap: 7px;

            flex-wrap: wrap;
        }

        .action-buttons form {
            margin: 0;
        }

        /* ========================================
           ALERTS
        ======================================== */

        .alert {
            padding: 13px 16px;

            margin-bottom: 20px;

            border-radius: 8px;

            font-size: 14px;
            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;

            color: #166534;

            border:
                1px solid #bbf7d0;
        }

        .alert-danger {
            background: #fee2e2;

            color: #991b1b;

            border:
                1px solid #fecaca;
        }

        .alert-warning {
            background: #fef3c7;

            color: #92400e;

            border:
                1px solid #fde68a;
        }

        .alert-info {
            background: #dbeafe;

            color: #1e40af;

            border:
                1px solid #bfdbfe;
        }

        /* ========================================
           EMPTY STATE
        ======================================== */

        .empty-state {
            padding: 50px 20px !important;

            color: #6b7280;

            text-align: center;
        }

        .empty-state strong {
            display: block;

            margin-bottom: 6px;

            color: #374151;

            font-size: 17px;
        }

        /* ========================================
           FORMS
        ======================================== */

        .form-section {
            margin-top: 20px;
        }

        .form-card {
            padding: 25px;

            background: #ffffff;

            border:
                1px solid #e5e7eb;

            border-radius: 12px;
        }

        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 20px;
        }

        .form-group-full {
            grid-column: 1 / -1;
        }

        .form-actions {
            display: flex;

            flex-wrap: wrap;

            gap: 10px;

            margin-top: 20px;
        }

        .radio-group {
            display: flex;

            flex-wrap: wrap;

            gap: 25px;

            margin-bottom: 15px;
        }

        .radio-group label {
            margin: 0;

            font-weight: normal;

            cursor: pointer;
        }

        .radio-group input {
            width: auto;

            margin:
                0 5px 0 0;
        }

        .checkbox-group {
            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 15px;
        }

        .checkbox-group label {
            margin: 0;

            font-weight: normal;

            cursor: pointer;
        }

        .checkbox-group input {
            width: auto;

            margin: 0;
        }

        /* ========================================
           PAGINATION
        ======================================== */

        .pagination {
            padding: 20px;

            background: #ffffff;

            text-align: center;
        }

        .pagination nav {
            display: inline-block;
        }

        .pagination svg {
            width: 18px;
            height: 18px;

            vertical-align: middle;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-width: 36px;
            height: 36px;

            padding: 7px 11px;

            margin: 2px;

            background: #ffffff;

            color: #374151;

            border:
                1px solid #d1d5db;

            border-radius: 6px;

            text-decoration: none;

            font-size: 13px;
        }

        .pagination a:hover {
            background: #f3f4f6;
        }

        .pagination .active span {
            background: #2563eb;

            color: #ffffff;

            border-color: #2563eb;
        }

        /* ========================================
           FOOTER
        ======================================== */

        .footer {
            margin-top: 30px;

            padding-top: 20px;

            border-top:
                1px solid #e5e7eb;

            color: #6b7280;

            font-size: 12px;

            text-align: center;

            line-height: 1.7;
        }

        /* ========================================
           RESPONSIVE - 1100px
        ======================================== */

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns:
                    repeat(3, 1fr);
            }

            .filter-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

        }

        /* ========================================
           RESPONSIVE - 850px
        ======================================== */

        @media (max-width: 850px) {

            .stats-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .sort-grid {
                grid-template-columns: 1fr;
            }

            .inventory-summary {
                grid-template-columns: 1fr;
            }

            .bulk-action-bar {
                flex-direction: column;

                align-items: flex-start;
            }

            .bulk-right {
                width: 100%;
            }

            .bulk-right .btn {
                flex: 1;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group-full {
                grid-column: auto;
            }

            .container {
                width: 96%;

                padding: 22px;
            }

        }

        /* ========================================
           RESPONSIVE - 650px
        ======================================== */

        @media (max-width: 650px) {

            .top-navigation {
                flex-direction: column;

                align-items: flex-start;

                gap: 12px;
            }

            .nav-links {
                width: 100%;

                flex-wrap: wrap;
            }

            .nav-links a {
                flex: 1;

                text-align: center;
            }

            .page-header {
                flex-direction: column;

                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .container {
                width: 100%;

                margin: 0;

                padding: 18px;

                border-radius: 0;
            }

            h1 {
                font-size: 24px;
            }

            .filter-actions,
            .form-actions {
                flex-direction: column;

                align-items: stretch;
            }

            .filter-actions .btn,
            .form-actions .btn {
                width: 100%;
            }

            .bulk-right {
                flex-direction: column;
            }

            .bulk-right .btn {
                width: 100%;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

<div class="container">

    {{-- =========================================
         TOP NAVIGATION
    ========================================== --}}

    <div class="top-navigation">

        <a
            href="{{ route('products.index') }}"
            class="brand"
        >
            Laravel 12 Aire

            <span class="brand-subtitle">
                Product Management
            </span>
        </a>

        <div class="nav-links">

            <a
                href="{{ route('products.index') }}"
                class="{{ request()->routeIs('products.index') ? 'active' : '' }}"
            >
                Products
            </a>

            <a
                href="{{ route('products.create') }}"
                class="{{ request()->routeIs('products.create') ? 'active' : '' }}"
            >
                + Add Product
            </a>

        </div>

    </div>


    {{-- =========================================
         SUCCESS MESSAGE
    ========================================== --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- =========================================
         ERROR MESSAGE
    ========================================== --}}

    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    {{-- =========================================
         VALIDATION ERRORS
    ========================================== --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please fix the following errors:
            </strong>

            <ul style="margin-bottom:0;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================
         PAGE CONTENT
    ========================================== --}}

    @yield('content')


    {{-- =========================================
         FOOTER
    ========================================== --}}

    <div class="footer">

        Laravel 12 + Aire Product Management System

        <br>

        Product Search • Price Filtering • Sorting • Inventory Management

        <br>

        Bulk Actions • Product Cloning • CSV Export • Inventory Summary

    </div>

</div>

@stack('scripts')

</body>

</html>
