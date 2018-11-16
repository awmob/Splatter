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
      <h2 class="daheadfont">Admin Home</h2>
    </div>
  </div>


  <div class="row">
    <div class="col-sm-12 p-2 text-center">
      Great to see you again, {{$user->name}}
    </div>
  </div>


</div>

@endsection
