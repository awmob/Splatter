@extends('templates.main_layout')

@if ($user)
@section('title','Splatter! @' . $user->username)
@else
@section('title','Splatter - Like Twitter, But Splatter!')
@endif

@section('main')




  <div class="row">
    <div class="col-sm-12 p-2 text-center splatter_backer">
      <h2 class="daheadfont">Like Twitter, but Splatter!</h2>
    </div>
  </div>



  @if ($user)
  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">

       <p>Hello, {{$user->name}}! Start Splatting!</p>
       <p class="small">&#64;{{$user->username}}</p>

        <div class="small mb-3">

         @php
          $following_link = url('following');
          $followers_link = url('followers');
         @endphp
         <span><a href="{{$following_link}}">Following: <foll id="following_num">{{$user->following}}</foll></a></span>
         <span class="ml-4"><a href="{{$followers_link}}">Followers: <foll id="follower_num">{{$user->followers}}</foll></a></span>
       </div>


       <p><img class="rounded-circle profile-pic-main" src="{{asset('storage/profile_pics/' . $user->profile_image)}}" alt="{{$user->username}}"></p>

       <p class="small profile_text">{{$user->profile_text}}</p>
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




  @if ($splats_get)
  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">
      <h3>Your Latest Splats</h3>
      <hr>
      <div id="show_splats"></div>
    </div>
  </div>
  @endif





  @else
   <div class="row">
     <div class="col-sm-12 p-5 text-center ">
       <p>Howdy there, pardner. Welcome to Splatter.</p>
        <p>Like Twitter? Sure it is. Like Twitter? Sure you do! Now get Splattering!</p>
        <p>Currently, Splatter is a test site designed to demonstrate Laravel Oauth API functionality and Ethereum Smart Contract Blockchain data storage.</p>
        <p><a href="https://github.com/awmob/Splatter" target="_blank">GITHUB PAGE</a></p>
        <p><b>Tester Credentials:<br>User: d@d.com<br>Pass: 12345678</b></p>
        <p><b>Tester Credentials:<br>User: a@b.com<br>Pass: 12345678</b></p>
        <p><b>Tester Credentials:<br>User: tester@tester.com<br>Pass: 12345678</b></p>
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

@if($user)
  <script>let the_url="{{url('customer-splats')}}";let usertype="user";let base_url="{{url('')}}"</script>
  <script src="{{asset('js/shared.js')}}"></script>
	<script src="{{asset('js/user_splats.js')}}"></script>
@endif
@endsection
