@extends('layouts.app')

@section('header')
<h2 class="fw-bold fs-4 text-dark mb-0">
    {{ __('Profile') }}
</h2>
@endsection

@section('content')
<div class="py-5">
    <div class="container" style="max-width: 800px;">

        {{-- Update Profile Info --}}
        <div class="p-4 mb-4 bg-white shadow rounded">
            <div class="mb-3">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="p-4 mb-4 bg-white shadow rounded">
            <div class="mb-3">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="p-4 bg-white shadow rounded">
            <div class="mb-3">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection