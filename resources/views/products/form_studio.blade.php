@extends('layout')

@section('content')

<style>
    .studio-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px 0 40px;
    }

    .studio-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%);
        border-radius: 20px;
        padding: 30px;
        color: #fff;
        margin-bottom: 25px;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.15);
    }

    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
        margin-bottom: 25px;
    }

    .custom-field-row {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 10px;
        transition: all 0.2s;
    }

    .rule-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }
</style>

<div class="studio-container">

    {{-- HEADER --}}
    <div class="studio-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">📝 Interactive Dynamic Form Schema Builder & Custom Field Studio</h2>
            <p class="mb-0 text-slate-300">Category-driven dynamic fields, Aire live validation presets & auto-slug generator</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">
                ← Product Catalog
            </a>
            <a href="{{ route('products.variantMatrix') }}" class="btn btn-primary btn-sm">
                📁 Image Gallery & Matrix →
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- LEFT PANEL: AIRE DYNAMIC FORM BUILDER --}}
        <div class="col-lg-7">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">
                    ⚡ Aire Dynamic Form Builder
                </h5>

                {{-- AIRE FORM OPENING --}}
                {{ Aire::open()
                    ->route('products.saveSchema')
                    ->id('aireStudioForm')
                }}

                <div class="row g-3">
                    {{-- Product Name & Auto-Slug --}}
                    <div class="col-md-7">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" class="form-control" name="name" id="productName" value="Pro Gaming Mechanical Keyboard" required oninput="generateSlug()">
                        <small class="text-muted">Slug: <span class="fw-bold text-primary" id="slugPreview">pro-gaming-mechanical-keyboard</span></small>
                    </div>

                    {{-- Custom SKU --}}
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Custom SKU</label>
                        <input type="text" class="form-control" name="sku" id="productSku" value="SKU-GAM-9921">
                    </div>

                    {{-- Category Selection (Triggers Dynamic Fields) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category Preset</label>
                        <select class="form-select" name="category" id="categorySelect" onchange="loadCategoryFields()">
                            @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price & Stock --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Price ($)</label>
                        <input type="number" class="form-control" name="price" id="productPrice" value="149" min="1" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Initial Stock</label>
                        <input type="number" class="form-control" name="stock" id="productStock" value="35" min="0" required>
                    </div>

                    {{-- DYNAMIC CATEGORY-WISE CUSTOM FIELDS SECTION --}}
                    <div class="col-md-12 mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0 text-primary">
                                🛠️ Category Dynamic Custom Fields (<span id="catNameBadge">Electronics</span>)
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCustomFieldRow()">
                                + Add Custom Field
                            </button>
                        </div>

                        <div id="dynamicFieldsContainer">
                            {{-- Populated dynamically via JS --}}
                        </div>
                    </div>

                    {{-- AIRE VALIDATION & PRESET RULES --}}
                    <div class="col-md-12 mt-3">
                        <div class="bg-light p-3 rounded-3 border">
                            <h6 class="fw-bold mb-2 text-dark"><i class="bi bi-shield-check text-success"></i> Aire Validation Presets & Live Rules</h6>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="client_validation" id="clientValSwitch" checked>
                                <label class="form-check-label fw-semibold" for="clientValSwitch">
                                    Enable Real-time Live Client-side JS Validation Helper
                                </label>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="rule-badge">required</span>
                                <span class="rule-badge">min:2</span>
                                <span class="rule-badge">integer</span>
                                <span class="rule-badge">auto_slug_unique</span>
                                <span class="rule-badge">category_schema_verified</span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="custom_fields" id="customFieldsJson">

                    <div class="col-md-12 mt-4 d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetStudioForm()">
                            🔄 Reset Form Draft
                        </button>

                        <button type="submit" class="btn btn-dark px-4 py-2" onclick="prepareSubmit()">
                            💾 Save Aire Form Schema & Create Product
                        </button>
                    </div>
                </div>

                {{ Aire::close() }}
            </div>
        </div>

        {{-- RIGHT PANEL: LIVE SCHEMA INSPECTOR & RECENT SCHEMAS --}}
        <div class="col-lg-5">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">
                    🔍 Live Schema & JSON Output Inspector
                </h5>

                <pre class="bg-dark text-success p-3 rounded-3 font-monospace small" style="max-height: 280px; overflow-y: auto;" id="jsonInspector">{
  "category": "Electronics",
  "slug": "pro-gaming-mechanical-keyboard",
  "rules": ["required", "min:2", "integer"],
  "custom_fields": {
    "warranty_months": "24",
    "power_watts": "65W"
  }
}</pre>

                <h6 class="fw-bold mt-4 mb-3 text-dark">
                    📋 Recent Dynamic Schema Products
                </h6>

                <div class="list-group list-group-flush">
                    @forelse($products as $p)
                    <div class="list-group-item px-0 py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-dark">{{ $p->name }}</span>
                                <small class="text-muted d-block">Category: {{ $p->category ?? 'General' }} | Slug: {{ $p->slug ?? 'n/a' }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">${{ number_format($p->price) }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-muted small py-2">No schema products created yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    const defaultSchemas = @json($defaultSchemas);

    function generateSlug() {
        const name = document.getElementById('productName').value;
        const slug = name.toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        document.getElementById('slugPreview').innerText = slug || 'n/a';
        updateJsonInspector();
    }

    function loadCategoryFields() {
        const cat = document.getElementById('categorySelect').value;
        document.getElementById('catNameBadge').innerText = cat;

        const container = document.getElementById('dynamicFieldsContainer');
        container.innerHTML = '';

        const fields = defaultSchemas[cat] || [
            { key: 'custom_spec', label: 'Specification', type: 'text', default: 'Standard' }
        ];

        fields.forEach(f => {
            addCustomFieldRow(f.key, f.label, f.default);
        });

        updateJsonInspector();
    }

    function addCustomFieldRow(key = '', label = '', val = '') {
        const container = document.getElementById('dynamicFieldsContainer');
        const rowId = 'field_row_' + Date.now() + '_' + Math.floor(Math.random()*1000);

        const html = `
            <div class="custom-field-row" id="${rowId}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-sm field-key" placeholder="Field Label (e.g. Warranty)" value="${label}" oninput="updateJsonInspector()">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-sm field-val" placeholder="Value (e.g. 24 Months)" value="${val}" oninput="updateJsonInspector()">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('${rowId}').remove(); updateJsonInspector();">
                            &times;
                        </button>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        updateJsonInspector();
    }

    function updateJsonInspector() {
        const cat = document.getElementById('categorySelect').value;
        const slug = document.getElementById('slugPreview').innerText;
        const name = document.getElementById('productName').value;

        const customData = {};
        document.querySelectorAll('.custom-field-row').forEach(row => {
            const key = row.querySelector('.field-key').value || 'custom_key';
            const val = row.querySelector('.field-val').value || '';
            if (key) customData[key] = val;
        });

        const output = {
            product_name: name,
            category: cat,
            slug: slug,
            validation_preset: "Aire Real-time Validation Active",
            custom_fields: customData
        };

        document.getElementById('jsonInspector').innerText = JSON.stringify(output, null, 2);
    }

    function prepareSubmit() {
        const customData = {};
        document.querySelectorAll('.custom-field-row').forEach(row => {
            const key = row.querySelector('.field-key').value;
            const val = row.querySelector('.field-val').value;
            if (key) customData[key] = val;
        });

        document.getElementById('customFieldsJson').value = JSON.stringify(customData);
    }

    function resetStudioForm() {
        document.getElementById('aireStudioForm').reset();
        loadCategoryFields();
        generateSlug();
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCategoryFields();
        generateSlug();
    });
</script>

@endsection
