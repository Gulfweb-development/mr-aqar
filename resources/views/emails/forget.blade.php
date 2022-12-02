<!doctype html>
<html lang="en">
<head>
</head>
<body>
<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
    <div style="margin:50px auto;width:70%;padding:20px 0">
        <div style="border-bottom:1px solid #eee">
            <a href="{{ route('Main.index', app()->getLocale()) }}" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">{{ __('PageTitle') }}</a>
        </div>
        <p style="font-size:1.1em">Hi {{ $user->name }},</p>
        <p>This email has been sent with your wish to reset your password. If you have not requested to forget your password, please ignore this email.</p>
        <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">{{ $code }}</h2>
        <p style="font-size:0.9em;">Regards,<br />{{ __('PageTitle') }}</p>
    </div>
</div>
</body>
</html>
