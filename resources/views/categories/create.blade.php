@extends('layouts.dashboard')

@section('page_title', 'Create Category')

@section('content')
<style>
    .module-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
    }

    .module-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .module-card {
            padding: 16px;
        }

        .module-title {
            font-size: 20px;
        }
    }
</style>

<div class="module-card">
    <h2 class="module-title">Create Category</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories._form', ['buttonText' => 'Save Category'])
    </form>
</div>
@endsection
