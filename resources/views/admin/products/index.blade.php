@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold mb-0 text-body">{{ __('Products') }}</h1>
        
        <a href="{{ route('admin.products.create') }}"
           class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i>
            {{ __('New Product') }}
        </a>
    </div>

    {{-- Filter Section (Disesuaikan dengan gaya Bootstrap) --}}
    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-12 col-md-4">
                <input name="search" value="{{ request('search') }}" 
                       class="form-control"
                       placeholder="{{ __('Search name/SKU') }}">
            </div>
            <div class="col-6 col-md-3">
                <select name="type" class="form-select">
                    <option value="">{{ __('All Types') }}</option>
                    <option value="simple" @selected(request('type')==='simple' )>{{ __('Simple') }}</option>
                    <option value="composite" @selected(request('type')==='composite' )>{{ __('Composite') }}</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select">
                    <option value="">{{ __('Any Status') }}</option>
                    <option value="active" @selected(request('status')==='active' )>{{ __('Active') }}</option>
                    <option value="inactive" @selected(request('status')==='inactive' )>{{ __('Inactive') }}</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-secondary w-100">Filter</button>
            </div>
        </div>
    </form>

    {{-- Flash Messages (Menggunakan style Bootstrap Alert) --}}
    @if (session('ok'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">{{ __('Product') }}</th>
                        <th class="py-3">{{ __('Type / Category') }}</th>
                        <th class="text-end py-3">{{ __('Price') }}</th>
                        <th class="text-center py-3">{{ __('Status') }}</th>
                        <th class="text-end pe-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="table-group-divider">
                    @forelse($products as $p)
                    <tr>
                        {{-- Product Name & Image --}}
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($p->image_path)
                                    <img src="{{ Storage::url($p->image_path) }}" 
                                         class="rounded object-fit-cover border border-secondary-subtle"
                                         style="width: 36px; height: 36px;"
                                         alt="{{ $p->name }}">
                                @else
                                    <div class="rounded bg-secondary-subtle d-flex align-items-center justify-content-center text-secondary small fw-bold"
                                         style="width: 36px; height: 36px;">
                                        IMG
                                    </div>
                                @endif
                                
                                <div>
                                    <a href="{{ route('admin.products.show',$p) }}" 
                                       class="text-decoration-none fw-bold text-body d-block">
                                        {{ $p->name }}
                                    </a>
                                    @if($p->sku) 
                                        <div class="small text-secondary">SKU: {{ $p->sku }}</div> 
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Type / Category --}}
                        <td class="py-3">
                            <div class="text-capitalize">{{ $p->type }}</div>
                            @if($p->category)
                                <div class="small text-secondary">{{ $p->category->name }}</div>
                            @endif
                        </td>

                        {{-- Price --}}
                        <td class="py-3 text-end font-monospace">
                            Rp {{ number_format($p->selling_price, 2, ',', '.') }}
                        </td>

                        {{-- Status --}}
                        <td class="py-3 text-center">
                            <span class="badge {{ $p->is_active 
                                ? 'bg-success-subtle text-success-emphasis border border-success-subtle' 
                                : 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle' }}">
                                {{ $p->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="pe-4 py-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                @if($p->isComposite())
                                    <a href="{{ route('admin.products.bom.edit', $p) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        {{ __('BOM') }}
                                    </a>
                                @endif

                                <a href="{{ route('admin.products.edit', $p) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    {{ __('Edit') }}
                                </a>

                                <form action="{{ route('admin.products.toggle', $p) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger">
                                        {{ $p->is_active ? __('Deactivate') : __('Activate') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-5 text-center text-secondary">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-box-seam display-6 mb-3 opacity-50"></i>
                                <p class="mb-0">{{ __('No products yet.') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection