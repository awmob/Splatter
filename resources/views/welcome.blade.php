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
      <h2 class="daheadfont">Like Twitter, but Splatter!</h2>
    </div>
  </div>


   <div class="row">
     <div class="col-sm-12 p-5 text-center ">
       <p>Howdy there, pardner. Welcome to Splatter.</p>
        <p>Like Twitter? Sure it is. Like Twitter? Sure you do! Now get Splattering!</p>
        <p>Currently, Splatter is a test site designed to demonstrate Laravel Oauth API functionality.</p>
     </div>
   </div>

   <form method = "POST" action = "{{url('customer-login')}}">
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
