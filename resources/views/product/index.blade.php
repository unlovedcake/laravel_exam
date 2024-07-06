<!DOCTYPE html>
<html>

<head>
    <title>Paint Products</title>
</head>

<body>
    <h1>Paint Products</h1>

    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('product.create')">
            {{ __('Add product') }}
        </x-nav-link>

    </div>
    <form action="{{ route('product.index') }}" method="GET" id="filterForm">
        @csrf
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id" onchange="document.getElementById('filterForm').submit()" required>
                <option value="" disabled selected>Select a category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" data-name=" old('$category->name',$category->name)">{{ $category->name }}</option>
                @endforeach
            </select>
            <input type="hidden" id="category_name" name="category_name">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    @if($products->isEmpty())
    <p>No products found in the 'paint' category.</p>
    @else
    <ul>
        @foreach($products as $product)
        <li>
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p>Price: ${{ $product->price }}</p>
            <p>Category: {{ $product->category->name }}</p>
            @if($product->image)
            <img src="{{ $product->image }}" alt="{{ $product->name }}">
            @endif
        </li>
        @endforeach
    </ul>
    @endif
</body>

<script>
    // document.getElementById('category_id').addEventListener('change', function() {
    //     var selectedCategory = this.options[this.selectedIndex];
    //     var categoryName = selectedCategory.getAttribute('data-name');
    //     document.getElementById('category_name').value = categoryName;

    //     console.log(categoryName);
    // });
</script>

</html>