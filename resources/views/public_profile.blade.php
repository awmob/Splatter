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



  @if ($splats_get)
  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">
      <h3>&#64;{{$user_get->username}}'s Latest Splats</h3>
      <hr>
      <div id="show_splats"></div>
    </div>
  </div>
  @endif


@php
  $js_url = url('user-info-get/' . $user_get->id);
@endphp


</div>

@if($user_get)
  <script>let the_url="{{$js_url}}";let usertype="non_user";let base_url="{{url('')}}"</script>
  <script src="{{asset('js/shared.js')}}"></script>
	<script src="{{asset('js/user_splats.js')}}"></script>
@endif
@endsection
