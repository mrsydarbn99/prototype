<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form method="POST" action="/register">
        @csrf
        <label>Name</label>
        <input type="text" name="name" required><br>

        <label>Email</label>
        <input type="text" name="email" required><br>

        <label>Password</label>
        <input type="password" name="password" required><br>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required><br>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="/login">Login here</a></p>
</body>
</html>
