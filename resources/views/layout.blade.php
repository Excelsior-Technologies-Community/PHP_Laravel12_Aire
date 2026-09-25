<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<meta name="csrf-token" content="{{ csrf_token() }}">

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
        font-family: Arial, Helvetica, sans-serif;
        background:
            linear-gradient(
                135deg,
                #eef4ff 0%,
                #f8fafc 45%,
                #f3f4f6 100%
            );
        margin: 0;
        padding: 0;
        color: #1f2937;
        min-height: 100vh;
    }

    /* Main Container */

    .container {
        width: 94%;
        max-width: 1280px;
        margin: 35px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow:
            0 10px 30px rgba(15, 23, 42, 0.08),
            0 2px 8px rgba(15, 23, 42, 0.04);
    }

    /* Typography */

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

    /* Page Header */

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

    /* Buttons */

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
        color: white;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.20);
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-success {
        background: #16a34a;
        color: white;
    }

    .btn-secondary {
        background: #64748b;
        color: white;
    }

    .btn-warning {
        background: #d97706;
        color: white;
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

    /* Statistics */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 25px;
    }

    .stat-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
    }

    .stat-title {
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #111827;
    }

    /* Filter */

    .filter-card {
        padding: 22px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .filter-card h3 {
        margin-bottom: 18px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: #374151;
        margin-bottom: 7px;
    }

    input,
    textarea,
    select {
        width: 100%;
        padding: 11px 12px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        font-size: 14px;
        background: white;
        color: #1f2937;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    input::placeholder,
    textarea::placeholder {
        color: #9ca3af;
    }

    textarea {
        resize: vertical;
        min-height: 110px;
    }

    input:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .featured-filter {
        display: flex;
        align-items: center;
        padding-top: 27px;
    }

    .featured-filter label {
        font-weight: normal;
        margin: 0;
        cursor: pointer;
    }

    .featured-filter input {
        width: auto;
        margin: 0 7px 0 0;
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 5px;
        flex-wrap: wrap;
    }

    /* Table */

    .table-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        background: white;
    }

    .table-header {
        padding: 18px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-header h3 {
        margin: 0;
    }

    .table-header span {
        color: #6b7280;
        font-size: 13px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 13px 12px;
        border-bottom: 1px solid #e5e7eb;
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
    }

    table td {
        font-size: 14px;
        color: #374151;
    }

    table tr:last-child td {
        border-bottom: none;
    }

    table tr:hover {
        background: #f8fafc;
    }

    .description {
        display: block;
        color: #6b7280;
        margin-top: 4px;
        font-size: 12px;
    }

    /* Badges */

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

    /* Empty State */

    .empty-state {
        text-align: center;
        padding: 45px 20px !important;
        color: #6b7280;
    }

    .empty-state strong {
        display: block;
        color: #374151;
        font-size: 16px;
        margin-bottom: 5px;
    }

    /* Forms */

    .form-section {
        margin-top: 20px;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 25px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .radio-group {
        display: flex;
        gap: 25px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .radio-group label {
        font-weight: normal;
        cursor: pointer;
        margin: 0;
    }

    .radio-group input {
        width: auto;
        margin: 0 5px 0 0;
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

    /* Form Grid */

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    /* Action Buttons */

    .action-buttons {
        display: flex;
        gap: 7px;
        align-items: center;
        flex-wrap: wrap;
    }

    .action-buttons form {
        margin: 0;
    }

    /* Pagination */

    .pagination {
        padding: 20px;
        text-align: center;
        background: #ffffff;
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
        border: 1px solid #d1d5db;
        border-radius: 6px;
        text-decoration: none;
        color: #374151;
        background: white;
        font-size: 13px;
    }

    .pagination a:hover {
        background: #f3f4f6;
    }

    /* Navigation */

    .top-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 15px 18px;
        background: #111827;
        border-radius: 10px;
    }

    .brand {
        color: white;
        font-weight: 700;
        text-decoration: none;
        font-size: 17px;
    }

    .brand-subtitle {
        color: #cbd5e1;
        font-size: 12px;
        margin-left: 8px;
    }

    .nav-links {
        display: flex;
        gap: 8px;
    }

    .nav-links a {
        color: #e5e7eb;
        text-decoration: none;
        padding: 7px 11px;
        border-radius: 6px;
        font-size: 13px;
    }

    .nav-links a:hover {
        background: #374151;
        color: white;
    }

    /* Footer */

    .footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
        text-align: center;
        color: #6b7280;
        font-size: 12px;
    }

    /* Responsive */

    @media (max-width: 1000px) {

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
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

    @media (max-width: 750px) {

        .top-navigation {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .nav-links {
            width: 100%;
            flex-wrap: wrap;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .table-card {
            overflow-x: auto;
        }

    }

    @media (max-width: 600px) {

        .stats-grid,
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .container {
            width: 100%;
            margin: 0;
            border-radius: 0;
            padding: 18px;
        }

        h1 {
            font-size: 24px;
        }

        .top-navigation {
            border-radius: 8px;
        }

        .filter-actions,
        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }

        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons .btn {
            width: 100%;
        }

    }

</style>


</head>

<body>

<div class="container">

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

            <a href="{{ route('products.index') }}">
                Products
            </a>

            <a href="{{ route('products.create') }}">
                + Add Product
            </a>

        </div>

    </div>

    @yield('content')

    <div class="footer">

        Laravel 12 + Aire Product Management System

        <br>

        Product Search • Price Filtering • Statistics • Availability Management

    </div>

</div>

</body>

</html>
