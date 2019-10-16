<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('auth.mail.remind.subject.password-reset') }}</h2>

		<div>
			{{ trans('auth.mail.remind.msg.password-reset', ['link' => URL::to('password/reset', array($token))]) }}.<br/>
			{{ trans('auth.mail.remind.msg.expire-in', ['expire' => Config::get('auth.reminder.expire', 60)]) }}.
		</div>
	</body>
</html>
