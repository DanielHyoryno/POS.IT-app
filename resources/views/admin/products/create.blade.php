@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow-lg">
                <div class="card-header border-bottom py-4">
                    <h4 class="mb-0 fw-bold fs-4">{{ __('New Product') }}</h4>
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

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input name="name" value="{{ old('name') }}" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('SKU (optional)') }}</label>
                                <input name="sku" value="{{ old('sku') }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('Type') }}</label>
                                <select name="type" class="form-select" required>
                                    <option value="simple" @selected(old('type')==='simple' )>{{ __('Simple') }}
                                    </option>
                                    <option value="composite" @selected(old('type')==='composite' )>
                                        {{ __('Composite') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Selling Price') }}</label>
                                <input name="selling_price" type="number" step="0.01" min="0"
                                    value="{{ old('selling_price',0) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Category') }}</label>
                                <select name="category_id" class="form-select">
                                    <option value="">{{ __('none') }}</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id')==$cat->
                                        id)>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Image (optional)') }}</label>

                            <div class="card shadow-sm border">
                                <div class="card-body p-3">

                                    <input type="file" name="image" accept="image/*" class="form-control mb-2">

                                    <div class="text-muted small fst-italic">
                                        {{ __('No image uploaded yet.') }}
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="alert alert-secondary mb-3">
                            <h6 class="alert-heading fw-bold mb-2">{{ __('For simple products:') }}</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">{{ __('Linked Item') }}</label>
                                    <select name="linked_item_id" class="form-select">
                                        <option value="">— {{ __('select item') }} —</option>
                                        @foreach($items as $it)
                                        <option value="{{ $it->id }}" @selected(old('linked_item_id')==$it->id)>
                                            {{ $it->name }} ({{ $it->base_unit }})
                                            {{ $it->is_active ? '' : __('inactive') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small">{{ __('Per Sale Qty (base unit)') }}</label>
                                    <input name="per_sale_qty" type="number" step="0.001" min="0.001"
                                        value="{{ old('per_sale_qty') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="isActiveCheck" @checked(old('is_active', true))>
                            <label class="form-check-label" for="isActiveCheck">
                                {{ __('Active') }}
                            </label>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.index') }}"
                                class="btn btn-secondary fw-bold">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary fw-bold">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection