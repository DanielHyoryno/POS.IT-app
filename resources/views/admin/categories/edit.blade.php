@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header border-bottom py-3 bg-white rounded-top-4">
                    <h4 class="mb-0 fw-bold fs-5">{{ __('Edit Category') }}</h4>
                </div>

                <div class="card-body p-4">

                    @if (session('ok'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('ok') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.categories.update',$category) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label ms-2">{{ __('Name') }}</label>
                            <input name="name" type="text" class="form-control rounded-3 px-3"
                                placeholder="{{ __('Category Name') }}" value="{{ old('name', $category->name) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label ms-2">{{ __('Order') }}</label>
                            <input name="sort_order" type="number" class="form-control rounded-3 px-3" placeholder="0"
                                value="{{ old('sort_order', $category->sort_order) }}">
                        </div>

                        <div class="form-check mb-4 ms-2">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="isActiveCheck" @checked(old('is_active', $category->is_active))>
                            <label class="form-check-label" for="isActiveCheck">
                                {{ __('Active') }}
                            </label>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}"
                                class="btn btn-secondary fw-bold rounded-3 px-4">
                                {{ __('Back') }}
                            </a>
                            <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4">
                                {{ __('Update') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection