@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if (session('ok'))
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('ok') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $e) 
                    <li>{{ $e }}</li> 
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Item --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-start gap-4">
                
                {{-- Image --}}
                <div class="flex-shrink-0">
                    @if($item->image_path)
                        <img src="{{ Storage::url($item->image_path) }}" 
                             class="rounded object-fit-cover border border-secondary-subtle" 
                             style="width: 80px; height: 80px;" 
                             alt="{{ $item->name }}">
                    @else
                        <div class="rounded bg-secondary-subtle d-flex align-items-center justify-content-center text-secondary small fw-bold" 
                             style="width: 80px; height: 80px;">
                            IMG
                        </div>
                    @endif
                </div>

                {{-- Info Text --}}
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">{{ $item->name }}</h1>
                    
                    <div class="d-flex flex-wrap gap-3 text-secondary small mb-2">
                        <div>{{ __('Base Unit') }}: <strong class="text-body">{{ $item->base_unit }}</strong></div>
                        <div class="vr opacity-25"></div>
                        <div>{{ __('Current Stock') }}: <strong class="text-body">{{ rtrim(rtrim(number_format($item->current_qty,3,'.',''), '0'), '.') }} {{ $item->base_unit }}</strong></div>
                        <div class="vr opacity-25"></div>
                        <div>{{ __('Threshold') }}: <strong class="text-body">{{ rtrim(rtrim(number_format($item->low_stock_threshold,3,'.',''), '0'), '.') }}</strong></div>
                    </div>

                    {{-- Status Badge --}}
                    <div>
                        <span class="badge {{ $item->is_active ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis' }} border border-opacity-10">
                            {{ $item->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="ms-auto">
                    <form action="{{ route('admin.items.toggle',$item) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-danger">
                            {{ $item->is_active ? __('Deactivate') : __('Activate') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Lots (FEFO) --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4 pb-3">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold">{{ __('Lots (FEFO)') }}</h5>
                    <small class="text-secondary">{{ __('Earliest expiry consumed first.') }}</small>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3 py-2">{{ __('Expiry') }}</th>
                                <th class="text-end py-2">{{ __('Qty') }}</th>
                                <th class="ps-3 py-2">{{ __('Note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->lots()->orderByRaw('expiry_date IS NULL')->orderBy('expiry_date')->get() as $lot)
                                @php $expired = $lot->expiry_date && $lot->expiry_date->lte(now()); @endphp
                                <tr class="{{ $expired ? 'table-danger' : '' }}">
                                    <td class="ps-3">
                                        @if($lot->expiry_date)
                                            <span class="fw-medium">{{ $lot->expiry_date->format('Y-m-d') }}</span>
                                            
                                            @if(!$expired)
                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle ms-2">
                                                    {{ (int) ceil(now()->floatDiffInDays($lot->expiry_date, false)) }} {{ __('d left') }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger text-white ms-2">{{ __('Expired') }}</span>
                                            @endif
                                        @else
                                            <span class="text-secondary fst-italic">{{ __('No expiry') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end font-monospace">
                                        {{ rtrim(rtrim(number_format($lot->qty,3,'.',''), '0'), '.') }} {{ $item->base_unit }}
                                    </td>
                                    <td class="ps-3 text-secondary small">{{ $lot->note ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-secondary py-4">{{ __('No lots available.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Movements --}}
            <div class="card shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold">{{ __('Recent Movements') }}</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($movements as $mv)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="small text-secondary mb-1">
                                    {{ $mv->created_at->format('Y-m-d H:i') }} • 
                                    <span class="fw-medium text-body">{{ __(ucfirst($mv->reason)) }}</span>
                                </div>
                                @if($mv->note) 
                                    <div class="small text-body-secondary">{{ $mv->note }}</div> 
                                @endif
                            </div>
                            <div class="font-monospace fw-bold {{ $mv->change_qty < 0 ? 'text-danger' : 'text-success' }}">
                                {{ $mv->change_qty > 0 ? '+' : '' }}{{ rtrim(rtrim(number_format($mv->change_qty,3,'.',''), '0'), '.') }} {{ $item->base_unit }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Restock Items --}}
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-success"><i class="bi bi-box-seam me-2"></i>{{ __('Restock Item') }}</h6>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.items.restock',$item) }}" method="POST">
                        @csrf
                        
                        <div class="input-group mb-3">
                            <input type="number" name="qty" step="0.001" min="0.001" class="form-control" placeholder="{{ __('Qty') }}" required>
                            <select name="unit" class="form-select" style="max-width: 80px;" required>
                                <option value="g">g</option>
                                <option value="kg">kg</option>
                                <option value="ml">ml</option>
                                <option value="L">L</option>
                                <option value="pcs">pcs</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">{{ __('Expiry Date (optional)') }}</label>
                            <input type="date" name="expiry_date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="note" class="form-control" placeholder="{{ __('Note (optional)') }}">
                        </div>

                        <button class="btn btn-success w-100">{{ __('Add Stock') }}</button>
                    </form>
                </div>
            </div>

            {{-- Adjust Stock --}}
            <div class="card shadow-sm">
                <div class="card-header bg-transparent py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-secondary"><i class="bi bi-sliders me-2"></i>{{ __('Adjust Stock (+/-)') }}</h6>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.items.adjust',$item) }}" method="POST">
                        @csrf
                        
                        <div class="input-group mb-3">
                            <input type="number" name="qty" step="0.001" class="form-control" placeholder="{{ __('+10 or -5') }}" required>
                            <select name="unit" class="form-select" style="max-width: 80px;" required>
                                <option value="g">g</option>
                                <option value="kg">kg</option>
                                <option value="ml">ml</option>
                                <option value="L">L</option>
                                <option value="pcs">pcs</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">{{ __('Expiry (only for +)') }}</label>
                            <input type="date" name="expiry_date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="note" class="form-control" placeholder="{{ __('Reason (optional)') }}">
                        </div>

                        <button class="btn btn-secondary w-100">{{ __('Apply Adjust') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection