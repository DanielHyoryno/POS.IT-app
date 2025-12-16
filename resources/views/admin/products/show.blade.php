@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if (session('ok'))
    <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('ok') }}
    </div>
    @endif

    {{-- Product Header --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-start gap-4">

                {{-- Image --}}
                <div class="flex-shrink-0">
                    @if($product->image_path)
                    <img src="{{ Storage::url($product->image_path) }}"
                        class="rounded object-fit-cover border border-secondary-subtle"
                        style="width: 100px; height: 100px;" alt="{{ $product->name }}">
                    @else
                    <div class="rounded bg-secondary-subtle d-flex align-items-center justify-content-center text-secondary small fw-bold"
                        style="width: 100px; height: 100px;">
                        IMG
                    </div>
                    @endif
                </div>

                {{-- Info Text --}}
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">{{ $product->name }}</h1>

                    <div class="d-flex flex-wrap gap-3 text-secondary small mb-3">
                        <div>SKU: <strong class="text-body">{{ $product->sku ?? '-' }}</strong></div>
                        <div class="vr opacity-25"></div>
                        <div class="text-capitalize">Type: <strong class="text-body">{{ $product->type }}</strong></div>
                        <div class="vr opacity-25"></div>
                        <div>Category: <strong class="text-body">{{ $product->category->name ?? 'None' }}</strong></div>
                    </div>

                    <div class="mb-3">
                        <span class="fs-4 fw-bold text-primary">Rp {{ number_format($product->selling_price, 2, ',', '.') }}</span>
                    </div>

                    {{-- Status Badge --}}
                    <div>
                        <span class="badge {{ $product->is_active ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis' }} border border-opacity-10">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="ms-auto d-flex flex-column gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary fw-bold">
                        <i class="bi bi-pencil me-1"></i> Edit Product
                    </a>
                    
                    @if($product->isComposite())
                    <a href="{{ route('admin.products.bom.edit', $product) }}" class="btn btn-sm btn-outline-secondary fw-bold">
                        <i class="bi bi-list-check me-1"></i> Manage BOM
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Detail / BOM --}}
        <div class="col-lg-8">
            
            @if($product->isComposite())
            {{-- Composite BOM Table --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold">Bill of Materials (Recipe)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Component Item</th>
                                <th class="text-end pe-4">Qty Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->bomLines as $line)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ route('admin.items.show', $line->item) }}" class="text-decoration-none fw-medium">
                                        {{ $line->item->name }}
                                    </a>
                                </td>
                                <td class="text-end pe-4 font-monospace">
                                    {{ rtrim(rtrim(number_format($line->qty, 3, '.', ''), '0'), '.') }} 
                                    <span class="text-secondary small">{{ $line->item->base_unit }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-secondary py-4 fst-italic">
                                    No ingredients/components defined yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @else
            {{-- Simple Product Detail --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold">Inventory Link</h5>
                </div>
                <div class="card-body">
                    @if($product->item)
                        <p class="mb-1 text-secondary">Linked to stock item:</p>
                        <div class="d-flex align-items-center p-3 border rounded bg-body-tertiary">
                            <div class="flex-grow-1">
                                <a href="{{ route('admin.items.show', $product->item) }}" class="fw-bold text-decoration-none">
                                    {{ $product->item->name }}
                                </a>
                                <div class="small text-secondary">
                                    Current Stock: {{ $product->item->current_qty }} {{ $product->item->base_unit }}
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="small text-secondary">Deducts per sale:</div>
                                <div class="font-monospace fw-bold">{{ $product->per_sale_qty + 0 }} {{ $product->item->base_unit }}</div>
                            </div>
                        </div>
                    @else
                        <div class="text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i> This product is not linked to any inventory item.
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- Side Panel (Stats maybe?) --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h6 class="fw-bold mb-0 text-secondary">Info</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-secondary">Created At</span>
                        <span class="font-monospace">{{ $product->created_at->format('d M Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-secondary">Last Updated</span>
                        <span class="font-monospace">{{ $product->updated_at->format('d M Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection