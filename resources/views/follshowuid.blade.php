@extends('templates.main_layout')

@section('title','Splatter - Like Twitter, But Splatter!')

@section('main')




  <div class="row">
    <div class="col-sm-12 p-2 text-center splatter_backer">
      <h2 class="daheadfont follset">test</h2>
    </div>
  </div>



  <div class="row">
    <div class="col-sm-12 pt-5 text-center splat_text daheadfont">

       <p>{{$user_get->name}}</p>

       <p class="small">&#64;{{$user_get->username}}</p>

       <div class="small mb-3">

        @php
         $following_link = url('following/' . $user_get->username);
         $followers_link = url('followers/' . $user_get->username);
        @endphp
        <span><a href="{{$following_link}}">Following: <foll id="following_num">{{$user_get->following}}</foll></a></span>
        <span class="ml-4"><a href="{{$followers_link}}">Followers: <foll id="follower_num">{{$user_get->followers}}</foll></a></span>
      </div>



       <p><img class="rounded-circle profile-pic-main" src="{{asset('storage/profile_pics/' . $user_get->profile_image)}}" alt="{{$user_get->username}}"></p>

       <p class="small profile_text">{{$user_get->profile_text}}</p>
    </div>

  </div>






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
