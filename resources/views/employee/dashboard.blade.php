@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-12 col-md-6 col-lg-5">

        <div class="card shadow-lg border-0 overflow-hidden">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <div class="avatar-placeholder bg-light text-dark rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold fs-3 mb-3 border"
                        style="width: 80px; height: 80px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h2 class="fw-bold mb-1">{{ auth()->user()->name }}</h2>
                    {{-- 1. On Duty --}}
                    <span class="badge bg-success-subtle text-success-emphasis px-3 rounded-pill">
                        {{ __('On Duty') }}
                    </span>
                </div>

                <div class="d-grid gap-3">
                    <a href="{{ route('employee.sales.catalog') }}"
                        class="btn btn-primary btn-lg py-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-cart2 fs-4"></i>
                        {{-- 2. Start New Transaction --}}
                        <span>{{ __('Start New Transaction') }}</span>
                    </a>

                    <a href="{{ route('employee.sales.history.index') }}"
                        class="btn btn-light border btn-lg py-3 rounded-3 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-clock-history fs-4"></i>
                        {{-- 3. View Transaction History --}}
                        <span>{{ __('View Transaction History') }}</span>
                    </a>
                </div>
            </div>
            
            {{-- 4. Logged in since --}}
            <div class="card-footer bg-light p-3 text-center text-muted small border-top">
                {{ __('Logged in since :time', ['time' => now()->format('H:i')]) }}
            </div>
        </div>

    </div>
</div>
@endsection