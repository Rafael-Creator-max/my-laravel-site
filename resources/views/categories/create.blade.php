@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Category</h1>

    <form action="{{ route('web.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
         <label for="category_type">Type</label>
         <input type="text" name="category_type" class="form-control" placeholder="e.g. CASH or CRYPTO" required>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color (hex or name)</label>
            <input type="text" name="color" class="form-control" placeholder="#ff6600 or red">
        </div>

        <button type="submit" class="btn btn-success">Create Category</button>
        <a href="{{ route('web.categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
