<!DOCTYPE html>
<html>
<head>
    <title>Application Approved!</title>
</head>
<body">
    <h2>Hi {{ $application->user->name }},</h2>
    <p>We are thrilled to inform you that your application to adopt <strong>{{ $application->animal->name }}</strong> has been <strong>Approved</strong>!</p>
</body>
</html>