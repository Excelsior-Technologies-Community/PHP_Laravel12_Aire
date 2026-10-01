@extends('layout')

@section('content')

<style>
    .matrix-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px 0 40px;
    }

    .matrix-header {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4338ca 100%);
        border-radius: 20px;
        padding: 30px;
        color: #fff;
        margin-bottom: 25px;
        box-shadow: 0 15px 35px rgba(30, 27, 75, 0.15);
    }

    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
        margin-bottom: 25px;
    }

    .gallery-preview-box {
        border: 2px dashed #94a3b8;
        border-radius: 14px;
        background: #f8fafc;
        padding: 20px;
        text-align: center;
        transition: all 0.2s;
    }

    .gallery-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .gallery-thumbnail.active-cover {
        border-color: #4338ca;
        box-shadow: 0 0 10px rgba(67, 56, 202, 0.4);
    }

    .variant-table td, .variant-table th {
        vertical-align: middle;
    }
</style>

<div class="matrix-container">

    {{-- HEADER --}}
    <div class="matrix-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">📁 Multi-File Image Gallery & Product Variant Matrix Studio</h2>
            <p class="mb-0 text-indigo-200">Drag-and-drop gallery manager, cover image selector & automatic SKU variant generator</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('products.formStudio') }}" class="btn btn-outline-light btn-sm">
                ← Form Studio
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">
                Product Catalog →
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

        {{-- LEFT PANEL: IMAGE GALLERY STUDIO & VARIANT CONFIG --}}
        <div class="col-lg-7">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">
                    🖼️ Aire Multi-File Image Gallery Studio
                </h5>

                {{ Aire::open()
                    ->route('products.generateVariants')
                    ->id('variantMatrixForm')
                }}

                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label fw-semibold">Base Product Name</label>
                        <input type="text" class="form-control" name="name" id="baseName" value="Ultra Comfort Hoodie Sweater" required>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Base Price ($)</label>
                        <input type="number" class="form-control" name="base_price" id="basePrice" value="89" min="1" required oninput="recalculateVariants()">
                    </div>

                    {{-- DRAG & DROP IMAGE GALLERY SIMULATOR --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Multi-Image Gallery & Cover Selector</label>

                        <div class="gallery-preview-box mb-3">
                            <div class="d-flex justify-content-center gap-3 flex-wrap" id="galleryThumbnails">
                                {{-- Loaded via JS --}}
                            </div>
                            <small class="text-muted mt-2 d-block">Click any thumbnail image to set it as the <strong>Main Cover Image</strong>.</small>
                        </div>
                    </div>

                    {{-- VARIANT ATTRIBUTE SELECTORS --}}
                    <div class="col-md-12 mt-3">
                        <h6 class="fw-bold border-bottom pb-2 text-indigo-900">
                            ⚙️ Product Variant Options (Sizes & Colors)
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Available Sizes</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="S" checked onchange="recalculateVariants()">
                                <label class="form-check-label">S</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="M" checked onchange="recalculateVariants()">
                                <label class="form-check-label">M</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="L" checked onchange="recalculateVariants()">
                                <label class="form-check-label">L</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="XL" onchange="recalculateVariants()">
                                <label class="form-check-label">XL</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Available Colors</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="Black" checked onchange="recalculateVariants()">
                                <label class="form-check-label">Black</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="Navy Blue" checked onchange="recalculateVariants()">
                                <label class="form-check-label">Navy Blue</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="Heather Grey" onchange="recalculateVariants()">
                                <label class="form-check-label">Grey</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="cover_image" id="selectedCoverInput">

                    <div class="col-md-12 mt-4 text-end">
                        <button type="submit" class="btn btn-indigo text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-3 shadow">
                            ✨ Generate Product & Variant Stock Matrix
                        </button>
                    </div>
                </div>

                {{ Aire::close() }}
            </div>
        </div>

        {{-- RIGHT PANEL: TABULAR VARIANT MATRIX PREVIEW --}}
        <div class="col-lg-5">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">
                    📊 Tabular Variant & Stock Price Matrix
                </h5>

                <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-sm variant-table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SKU</th>
                                <th>Variant</th>
                                <th>Price</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody id="variantMatrixBody">
                            {{-- Populated dynamically via JS --}}
                        </tbody>
                    </table>
                </div>

                <div class="bg-light p-3 rounded-3 mt-3 border">
                    <div class="d-flex justify-content-between small">
                        <span>Total Variant SKUs:</span>
                        <strong id="totalVariantsCount">4 Variants</strong>
                    </div>
                    <div class="d-flex justify-content-between small mt-1">
                        <span>Total Inventory Stock:</span>
                        <strong class="text-success" id="totalStockSum">140 Units</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    const sampleImages = [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400',
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
    ];

    let selectedCover = sampleImages[0];

    function renderGallery() {
        const box = document.getElementById('galleryThumbnails');
        box.innerHTML = '';

        sampleImages.forEach((url, idx) => {
            const isCover = url === selectedCover;
            const img = document.createElement('img');
            img.src = url;
            img.className = 'gallery-thumbnail ' + (isCover ? 'active-cover' : '');
            img.title = isCover ? 'Main Cover Image' : 'Click to set as Cover';
            img.onclick = () => {
                selectedCover = url;
                document.getElementById('selectedCoverInput').value = url;
                renderGallery();
            };

            box.appendChild(img);
        });

        document.getElementById('selectedCoverInput').value = selectedCover;
    }

    function recalculateVariants() {
        const name = document.getElementById('baseName').value || 'Product';
        const basePrice = parseInt(document.getElementById('basePrice').value) || 89;

        const sizes = Array.from(document.querySelectorAll('input[name="sizes[]"]:checked')).map(el => el.value);
        const colors = Array.from(document.querySelectorAll('input[name="colors[]"]:checked')).map(el => el.value);

        const tbody = document.getElementById('variantMatrixBody');
        tbody.innerHTML = '';

        let count = 0;
        let totalStock = 0;

        colors.forEach(c => {
            sizes.forEach(s => {
                count++;
                const sku = name.substring(0, 3).toUpperCase() + '-' + c.substring(0, 2).toUpperCase() + '-' + s;
                const price = basePrice + (s === 'XL' ? 10 : 0);
                const stock = 25 + (count * 5);
                totalStock += stock;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="font-monospace small">${sku}</td>
                    <td><span class="badge bg-secondary">${c} / ${s}</span></td>
                    <td class="fw-bold text-success">$${price}</td>
                    <td><span class="badge bg-primary">${stock}</span></td>
                `;
                tbody.appendChild(tr);
            });
        });

        document.getElementById('totalVariantsCount').innerText = count + ' Variants';
        document.getElementById('totalStockSum').innerText = totalStock + ' Units';
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderGallery();
        recalculateVariants();
    });
</script>

@endsection
