@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>

    <form action="{{ route('web.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" class="form-select" required>
                <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color (hex or name)</label>
            <input type="text" name="color" class="form-control" value="{{ $category->color }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('web.categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
