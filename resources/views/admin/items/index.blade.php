@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold mb-0 text-body">{{ __('Items') }}</h1>

        <div class="d-flex gap-2">
            {{-- Tombol Low Stock --}}
            <a href="{{ route('admin.items.index', ['low' => 1]) }}"
                class="btn btn-outline-warning d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle"></i>
                {{ __('Low Stock') }}
            </a>

            {{-- Tombol New Item --}}
            <a href="{{ route('admin.items.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                {{ __('New Item') }}
            </a>
        </div>
    </div>

    @include('partials.flash')

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">{{ __('Name') }}</th>
                        <th class="py-3">{{ __('Unit') }}</th>
                        <th class="text-end py-3">{{ __('Stock') }}</th>
                        <th class="text-end py-3">{{ __('Threshold') }}</th>
                        <th class="text-center py-3">{{ __('Status') }}</th>
                        <th class="text-end pe-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="table-group-divider">
                    @forelse ($items as $it)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($it->image_path)
                                <img src="{{ Storage::url($it->image_path) }}"
                                    class="rounded object-fit-cover border border-secondary-subtle"
                                    style="width: 36px; height: 36px;" alt="{{ $it->name }}">
                                @else
                                <div class="rounded bg-secondary-subtle d-flex align-items-center justify-content-center text-secondary small fw-bold"
                                    style="width: 36px; height: 36px;">
                                    IMG
                                </div>
                                @endif

                                <a href="{{ route('admin.items.show',$it) }}"
                                    class="text-decoration-none fw-bold text-body">
                                    {{ $it->name }}
                                </a>
                            </div>
                        </td>

                        {{-- Unit --}}
                        <td class="py-3 text-secondary">{{ $it->base_unit }}</td>

                        {{-- Stock --}}
                        <td class="py-3 text-end font-monospace">
                            {{ rtrim(rtrim(number_format($it->current_qty,3,'.',''), '0'), '.') }}
                        </td>

                        {{-- Threshold --}}
                        <td class="py-3 text-end font-monospace text-secondary">
                            {{ rtrim(rtrim(number_format($it->low_stock_threshold,3,'.',''), '0'), '.') }}
                        </td>

                        {{-- Status --}}
                        <td class="py-3 text-center">
                            <span class="badge {{ $it->is_active 
                                ? 'bg-success-subtle text-success-emphasis border border-success-subtle' 
                                : 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle' }}">
                                {{ $it->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="pe-4 py-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.items.edit', $it) }}" class="btn btn-sm btn-outline-primary">
                                    {{ __('Edit') }}
                                </a>

                                <form action="{{ route('admin.items.toggle', $it) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger">
                                        {{ $it->is_active ? __('Deactivate') : __('Activate') }}
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-5 text-center text-secondary">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-box-seam display-6 mb-3 opacity-50"></i>
                                <p class="mb-0">{{ __('No items yet.') }}</p>
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
        {{ $items->withQueryString()->links() }}
    </div>

</div>
@endsection