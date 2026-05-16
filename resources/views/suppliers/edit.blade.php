@extends('layouts.dashboard')

@section('page_title', 'Edit Supplier')

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
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .module-card { padding: 16px; }
        .module-title { font-size: 20px; }
    }
</style>

<div class="module-card">
    <h2 class="module-title">Edit Supplier</h2>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('suppliers._form', ['buttonText' => 'Update Supplier'])
    </form>
</div>
@endsection
