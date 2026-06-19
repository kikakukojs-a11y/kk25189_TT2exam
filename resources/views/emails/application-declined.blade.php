<!DOCTYPE html>
<html>
<head>
    <title>Application Rejected</title>
</head>
<body>
    <h2>Hi {{ $application->user->name }},</h2>
    <p>We are sorry to inform you that your application to adopt <strong>{{ $application->animal->name }}</strong> has been <strong>Rejected</strong>.</p>
</body>
</html>