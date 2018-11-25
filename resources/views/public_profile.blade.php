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
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">

       <p>{{$user_get->name}}</p>

       <p class="small">&#64;{{$user_get->username}}</p>

       <p><img class="rounded-circle profile-pic-main" src="{{asset('storage/profile_pics/' . $user_get->profile_image)}}" alt="{{$user_get->username}}"></p>
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
	<script src="{{asset('js/user_splats.js')}}"></script>
@endif
@endsection
