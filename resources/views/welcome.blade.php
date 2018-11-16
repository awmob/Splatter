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



  @if ($user)
  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">

       <p>Hello, {{$user->name}}! Start Splatting!</p>
    </div>

  </div>



    <form method = "POST" action = "{{route('customer.submit.splat')}}">
      {{csrf_field()}}
    <div class="row">


          <div class="col-sm-2 text-center m-1">
          </div>

          <div class="col-sm-2 text-center m-1">
            <input type="submit" class="button" value="Splat!">
          </div>

          <div class="col-sm-6 text-center m-1">
            <input type="text" name="splat" class="form_text" maxlength="{{config('constants.splat_limit')}}">
          </div>


           <div class="col-sm-2 text-center m-1">
           </div>



    </div>
    </form>

  </div>


  @if ($splats_get)
  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">
      <h3>Your Latest Splats</h3>
    </div>
  </div>
  @endif





  @else
   <div class="row">
     <div class="col-sm-12 p-5 text-center ">
       <p>Howdy there, pardner. Welcome to Splatter.</p>
        <p>Like Twitter? Sure it is. Like Twitter? Sure you do! Now get Splattering!</p>
        <p>Currently, Splatter is a test site designed to demonstrate Laravel Oauth API functionality.</p>
        <p><b>Tester Credentials:<br>User: a@b.com<br>Pass: 12345678</b></p>
     </div>
   </div>

   <form method = "POST" action = "{{route('customer.login')}}">
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
   @endif


</div>

@endsection
