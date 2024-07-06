<!DOCTYPE html>
<html>

<head>
    <title>Add Category</title>
</head>

<body>
    <h1>Add Category</h1>

    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="/categories" method="POST">
        @csrf
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Add Category</button>
    </form>
</body>

</html>