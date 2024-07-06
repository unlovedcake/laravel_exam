<div class="container mt-5">
    <h1 class="mb-4">Add Product</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/product" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" class="form-control" id="image" name="image">
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="" disabled selected>Select a category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" data-name="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" id="category_name" name="category_name">

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>

<script>
    document.getElementById('category_id').addEventListener('change', function() {
        var selectedCategory = this.options[this.selectedIndex];
        var categoryName = selectedCategory.getAttribute('data-name');
        document.getElementById('category_name').value = categoryName;
    });
</script>