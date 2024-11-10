<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <label for="code">Login Code:</label>
        <input type="text" id="code" name="code" required>
        <button type="submit">Login</button>
    </form>
    @if ($errors->any())
        <div>{{ $errors->first('code') }}</div>
    @endif
</body>
</html>

