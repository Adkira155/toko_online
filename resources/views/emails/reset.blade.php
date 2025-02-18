<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password Anda</h1>
    <p>Klik tautan di bawah ini untuk mereset kata sandi Anda:</p>
    <a href="{{ url('password/reset', $token) }}">Reset Password</a>
</body>
</html>
