<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin Login</title>

		</head>

</html>

<body>

<div class="card-header">{{ __('Admin Login') }}</div>

<div class="card-body">
  <form method="POST" action="{{ route('admin.login.submit') }}">
		{{ csrf_field() }}

		<input type="hidden" name="test" value="22">

	<input type="submit">
</div>

</body>

</html>
