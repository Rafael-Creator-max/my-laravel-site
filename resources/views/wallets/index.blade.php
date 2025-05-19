@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Wallet Tracker</h1>

    <!-- <form method="GET" class="mb-3">
        <label for="category_id">Filter by category:</label>
        <select name="category_id" onchange="this.form.submit()" class="form-select w-auto d-inline-block mx-2">
            <option value="">-- All Categories --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form> -->
    <div class="mb-3">
    <form method="GET" action="{{ route('wallets.index') }}">
        <label for="category_id">Filter by Category:</label>
        <select name="category_id" id="category_id" onchange="this.form.submit()" class="form-control w-auto d-inline-block">
            <option value="">-- All Categories --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <noscript><button type="submit" class="btn btn-primary">Filter</button></noscript>
    </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Balance</th>
                <th>Currency</th>
                <th>Type</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @forelse($wallets as $wallet)
                <tr>
                    <td>{{ $wallet->name }}</td>
                    <td>{{ $wallet->balance }}</td>
                    <td>{{ $wallet->currency }}</td>
                    <td>{{ $wallet->type }}</td>
                    <td>{{ $wallet->category?->name ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No wallets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
