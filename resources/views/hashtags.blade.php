@extends('templates.main_layout')

@section('title','Splatter - Like Twitter, But Splatter!')

@section('main')




  <div class="row">
    <div class="col-sm-12 p-2 text-center splatter_backer">
      <h2 class="daheadfont">#{{$hashtag}}</h2>
    </div>
  </div>




  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">
       @if ($user)
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
       @else
       <p>Hello, friend!</p>
       @endif
    </div>

  </div>


     @if ($user)
    <form method = "POST" action = "{{route('customer.submit.splat')}}">
      {{csrf_field()}}
    <div class="row">


          <div class="col-sm-2 text-center m-1">
          </div>

          <div class="col-sm-2 text-center m-1">
            <input type="submit" class="button" value="Splat!">
          </div>

          <div class="col-sm-6 text-center m-1">
            <input type="text" id="splat" name="splat" class="form_text" maxlength="{{config('constants.splat_limit')}}">
          </div>


           <div class="col-sm-2 text-center m-1">
           </div>



    </div>
    </form>
    @endif





  <div class="row">
    <div class="col-sm-12 p-5 text-center splat_text daheadfont">
      <h3>Latest #{{$hashtag}} Splats</h3>
      <hr>
      <div id="show_splats"></div>
    </div>
  </div>




</div>

	@php
		//set url for js splat loader / scroller
		$url = url('hashtag-splats/' . $hashtag);
	@endphp

  <script>let the_url="{{$url}}";let usertype="public";let base_url="{{url('')}}"</script>
  <script src="{{asset('js/shared.js')}}"></script>
	<script src="{{asset('js/user_splats.js')}}"></script>

  <script src="{{asset('js/text_swappers.js')}}"></script>
  <script>
    let text_id_obj = {
     "splat" : "Splat..."
    };

    add_change_listeners(text_id_obj);
    initialize_text(text_id_obj);
  </script>

@endsection
