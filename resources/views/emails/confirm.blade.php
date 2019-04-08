<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Registration Confirmation Email</title>
</head>
<body>
  <h1>Thank you for your registration in Naughty or Nice！</h1>

  <p>
    	Please clicking the link below to complete registration：
    <a href="{{ route('confirm_email', $user->activation_token) }}">
      {{ route('confirm_email', $user->activation_token) }}
    </a>
  </p>

  <p>
   If this is not your perssonal operation, please ignore this email, Thank you!
  </p>
</body>
</html>