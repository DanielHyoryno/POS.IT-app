@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow-lg mb-4">
                <div class="card-header border-bottom py-4">
                    <h4 class="mb-0 fw-bold fs-4">{{ __('Edit Product') }}</h4>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (session('ok'))
                    <div class="alert alert-success">{{ session('ok') }}</div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.update',$product) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input name="name" value="{{ old('name',$product->name) }}" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('SKU (optional)') }}</label>
                                <input name="sku" value="{{ old('sku',$product->sku) }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('Type') }}</label>
                                <select name="type" class="form-select" required>
                                    <option value="simple" @selected(old('type',$product->
                                        type)==='simple')>{{ __('Simple') }}</option>
                                    <option value="composite" @selected(old('type',$product->
                                        type)==='composite')>{{ __('Composite') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Selling Price') }}</label>
                                <input name="selling_price" type="number" step="0.01" min="0"
                                    value="{{ old('selling_price',$product->selling_price) }}" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Category') }}</label>
                                <select name="category_id" class="form-select">
                                    <option value="">{{ __('none') }}</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id',$product->
                                        category_id)==$cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Image (optional)') }}</label>

                            <div class="card shadow-sm border border-2 border-dashed-secondary">
                                <div class="card-body p-3">
                                    <input type="file" name="image" accept="image/*" class="form-control mb-3">

                                    @if($product->image_path)
                                    <div class="p-2 border rounded d-inline-block bg-body-tertiary">
                                        <div class="small text-muted mb-1 text-center">{{ __('Current Image') }}</div>
                                        <img src="{{ Storage::url($product->image_path) }}" class="img-fluid rounded"
                                            style="height: 100px; width: 100px; object-fit: cover;"
                                            alt="{{ $product->name }}">
                                    </div>
                                    @else
                                    <div class="text-muted small fst-italic">
                                        {{ __('No image uploaded yet.') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($product->isSimple())
                        <div class="alert alert-dark mb-3">
                            <h6 class="alert-heading fw-bold mb-2">{{ __('Linked Item & per sale qty (base unit)') }}
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <select name="linked_item_id" class="form-select">
                                        <option value="">{{ __('select item') }}</option>
                                        @foreach($items as $it)
                                        <option value="{{ $it->id }}" @selected(old('linked_item_id',$product->
                                            linked_item_id)==$it->id)>
                                            {{ $it->name }} ({{ $it->base_unit }})
                                            {{ $it->is_active ? '' : __('inactive') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input name="per_sale_qty" type="number" step="0.001" min="0.001"
                                        value="{{ old('per_sale_qty',$product->per_sale_qty) }}" class="form-control"
                                        placeholder="Qty">
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="alert alert-warning mb-3">
                            <div class="fw-bold">
                                {{ __('Estimated Cost: Rp :cost', ['cost' => number_format($estimatedCost,2,',','.')]) }}
                            </div>
                            <div class="small">
                                {{ __('Margin (est.): Rp :margin', ['margin' => number_format($product->selling_price - $estimatedCost,2,',','.')]) }}
                            </div>
                            @if($product->selling_price < $estimatedCost) <div class="text-danger fw-bold mt-1 small">
                                <i class="bi bi-exclamation-triangle"></i>
                                {{ __('Warning: Selling price is below estimated cost.') }}
                        </div>
                        @endif
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActiveCheck"
                        @checked(old('is_active',$product->is_active))>
                    <label class="form-check-label" for="isActiveCheck">
                        {{ __('Active') }}
                    </label>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.show',$product) }}" class="btn btn-secondary fw-bold">
                        {{ __('Back') }}
                    </a>
                    <button type="submit" class="btn btn-primary fw-bold">
                        {{ __('Update') }}
                    </button>
                </div>
                </form>
            </div>
        </div>
            @if($product->isComposite())
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold mb-2">{{ __('BOM Lines') }}</h2>
                <table class="min-w-full">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-2">{{ __('Item') }}</th>
                            <th class="text-right p-2">{{ __('Qty') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($product->bomLines as $line)
                        <tr class="border-t">
                            <td class="p-2">{{ $line->item->name }} ({{ $line->item->base_unit }})</td>
                            <td class="p-2 text-right">{{ rtrim(rtrim(number_format($line->qty,3,'.',''), '0'), '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="p-3 text-center text-gray-500">{{ __('No BOM lines.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            @endif

    </div>
</div>
</div>
@endsection