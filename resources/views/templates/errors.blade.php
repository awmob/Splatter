@if (isset($errors))
  @if (count($errors))
  <div class = "errors_pass text-center">



      @foreach ($errors->all() as $error)

      {{ $error }}<br>

      @endforeach

    <br>

  </div>
  @endif
@endif
