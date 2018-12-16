@extends('templates.main_layout')

@section('title','Splatter - Like Twitter, But Splatter!')

@section('main')




  <div class="row">
    <div class="col-sm-12 p-2 text-center splatter_backer">
      <h2 class="daheadfont follset">test</h2>
    </div>
  </div>




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






  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">
      <h3 class="follset"></h3>
      <hr>
      <div id="show_followers"></div>
    </div>
  </div>
</div>



  <script>let followtype="{{$follow_type}}";let url="{{$follow_url}}";let base_url="{{url('')}}"</script>
  <script src="{{asset('js/shared.js')}}"></script>
	<script src="{{asset('js/folls.js')}}"></script>

@endsection
