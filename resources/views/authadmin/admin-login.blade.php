@extends('templates.main_layout')

@section('title','Splatter - Like Twitter, But Splatter!')


@section('main')

<div class="container">
  <div class="row">
    <div class="col-sm-12 text-center">
      <h1 class="daheadfont">Splatter.</h1>
    </div>
  </div>

	<div class="row">
    <div class="col-sm-12 p-2 text-center splatter_backer">
      <h2 class="daheadfont">Admin Login</h2>
    </div>
  </div>


   <form method = "POST" action = "{{route('admin.login.submit')}}">
   <div class="row">

           {{csrf_field()}}
         <div class="col-sm-1 text-center m-1">
         </div>

         <div class="col-sm-2 text-center m-1">
           <input type="submit" class="button" value="Log In">
         </div>

         <div class="col-sm-4 text-center m-1">
           <input type="text" name="email" class="form_text">
         </div>

         <div class="col-sm-4 text-center m-1">
           <input type="password" name="password" class="form_text">
          <div>

          <div class="col-sm-1 text-center m-1">
          </div>



   </div>
   </form>


</div>

@endsection
