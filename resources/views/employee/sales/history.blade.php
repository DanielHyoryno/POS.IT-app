@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h1 class="h4 fw-bold mb-1 text-body">{{ __('Sales History') }}</h1>
            <p class="text-secondary small mb-0">
                {{ __('Transaction report for') }}
                {{-- Gunakan translatedFormat agar hari/bulan jadi bahasa lokal --}}
                <span class="text-body fw-bold">
                    {{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                </span>
            </p>
        </div>

        {{-- Date Filter & Navigation --}}
        <div class="d-flex gap-2">
            <div class="btn-group shadow-sm">
                <a class="btn btn-outline-secondary d-flex align-items-center"
                    href="{{ route('employee.sales.history.index', ['date'=>$prevDate]) }}">
                    <i class="bi bi-chevron-left"></i>
                </a>

                {{-- Form Tanggal --}}
                <form action="{{ route('employee.sales.history.index') }}" method="get" class="d-flex">
                    <input type="date" name="date" value="{{ $date }}"
                        class="form-control rounded-0 text-center border-secondary-subtle" style="width: 140px;"
                        onchange="this.form.submit()" />
                </form>

                <a class="btn btn-outline-secondary d-flex align-items-center"
                    href="{{ route('employee.sales.history.index', ['date'=>$nextDate]) }}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Summary Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div>
                        <div class="text-secondary small">{{ __('Total Orders') }}</div>
                        <div class="h5 fw-bold mb-0 text-body">{{ number_format($orderCount) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div>
                        <div class="text-secondary small">{{ __('Total Revenue') }}</div>
                        <div class="h5 fw-bold mb-0 text-body">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div>
                        <div class="text-secondary small">{{ __('Average / Order') }}</div>
                        <div class="h5 fw-bold mb-0 text-body">Rp {{ number_format($avgOrder,0,',','.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sales Table --}}
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">{{ __('Time') }}</th>
                        <th class="py-3">{{ __('Invoice') }}</th>
                        <th class="py-3">{{ __('Cashier') }}</th>
                        <th class="text-end py-3">{{ __('Total') }}</th>
                        <th class="text-center py-3">{{ __('Status') }}</th>
                        <th class="text-end pe-4 py-3">{{ __('Action') }}</th>
                    </tr>
                </thead>

                <tbody class="table-group-divider">
                    @forelse($sales as $s)
                    <tr>
                        {{-- Time --}}
                        <td class="ps-4 py-3 text-body">
                            {{ \Illuminate\Support\Carbon::parse($s->created_at)->format('H:i') }}
                        </td>

                        {{-- Invoice --}}
                        <td class="py-3 font-monospace fw-medium">
                            {{ $s->invoice_no }}
                        </td>

                        {{-- Cashier --}}
                        <td class="py-3 text-secondary">
                            {{ $s->user->name ?? '—' }}
                        </td>

                        {{-- Total --}}
                        <td class="py-3 text-end fw-bold text-body">
                            Rp {{ number_format($s->total,0,',','.') }}
                        </td>

                        {{-- Status Badge --}}
                        <td class="py-3 text-center">
                            @php
                            $badge = match($s->status){
                                'paid' => 'bg-success-subtle text-success-emphasis border border-success-subtle',
                                'draft'=> 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                                'void' => 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle',
                                default=> 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle'
                            };
                            @endphp
                            <span class="badge {{ $badge }} px-2 py-1 rounded">
                                {{-- Translate status values (Paid, Draft, Void) --}}
                                {{ ucfirst(__($s->status)) }}
                            </span>
                        </td>

                        {{-- Action --}}
                        <td class="pe-4 py-3 text-end">
                            <a class="btn btn-sm btn-outline-secondary"
                                href="{{ route('employee.sales.invoice.show', $s) }}">
                                {{ __('View') }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-secondary">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-receipt display-6 mb-3 opacity-50"></i>
                                <p class="mb-0">{{ __('No sales transactions on this date.') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection