<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>
        Pendaftaran akun {{ $type }} {{ $name . " (" . $identityNumber .")" }} Berhasil <br>
        Silahkan verifikasi akun anda <a href="{{ route('verify', ['code' => $verificationCode]) }}">disini</a>
    </p>
</body>
</html>