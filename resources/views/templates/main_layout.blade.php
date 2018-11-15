<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>


        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">



    </head>
    <body class="pt-5">


<main>

				 @if($flash = session('message'))
				 <div id='flash-message' role="alert">
				 	{{$flash}}
			 	 </div>
				 @endif

				 @include('templates.errors')

         @yield('main')

</main>



</body>
</html>
