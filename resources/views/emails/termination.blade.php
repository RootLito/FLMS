<!DOCTYPE html>
<html>
<head>
    <title>{{ $subjectLine }}</title>
</head>
<body>
    <div style="font-family: sans-serif; padding: 20px;">
        <h2 style="color: #dc2626;">Termination Warning</h2>
        <div>{!! nl2br(e($body)) !!}</div>
    </div>
</body>
</html>