<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Host Login</title>
</head>
<body>
    <h1>AVA Host Login</h1>

    @if($errors->has('login'))
        <p style="color: red;">{{ $errors->first('login') }}</p>
    @endif

    <form action="{{ route('host.login.request') }}" method="POST">
        @csrf
        <label>Username:</label><br>
        <input type="text" name="username" value="{{ old('username') }}"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
