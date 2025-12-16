@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold fs-4 text-dark">{{ __('Categories') }}</h2>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary fw-bold px-4 rounded-3">
                    <i class="bi bi-plus-lg"></i> {{ __('+New') }}
                </a>
            </div>

            <div class="card shadow-lg border-0">

                <div class="card-body p-0">

                    @if (session('ok'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('ok') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3">{{ __('Name') }}</th>
                                    <th class="text-center py-3">{{ __('Status') }}</th>
                                    <th class="text-center py-3">{{ __('Order') }}</th>
                                    <th class="text-end pe-4 py-3" style="width: 200px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cats as $c)
                                <tr>
                                    <td class="ps-4 fw-medium text-dark py-3">
                                        {{ $c->name }}
                                    </td>

                                    <td class="text-center py-3">
                                        <span
                                            class="badge rounded-3 px-3 py-2 {{ $c->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' }}">
                                            {{ $c->is_active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </td>

                                    <td class="text-center text-muted py-3">
                                        {{ $c->sort_order }}
                                    </td>

                                    <td class="text-end pe-4 py-3">
                                        <div class="d-flex justify-content-end gap-4">
                                            <a href="{{ route('admin.categories.edit',$c) }}"
                                                class="btn btn-sm btn-outline-primary fw-bold">
                                                {{ __('Edit') }}
                                            </a>

                                            <form action="{{ route('admin.categories.destroy',$c) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('{{ __('Delete category :name?', ['name' => $c->name]) }}')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger fw-bold">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-5 text-center text-muted fst-italic">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-folder2-open fs-1 opacity-50 mb-2"></i>
                                            {{ __('No categories found.') }}
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($cats->hasPages())
                <div class="card-footer bg-white py-3 border-top-0">
                    {{ $cats->links() }}
                </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection