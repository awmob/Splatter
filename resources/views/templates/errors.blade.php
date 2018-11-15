@if (count($errors))
<div class = "errors_pass text-center">

  <ul>

    @foreach ($errors->all() as $error)

    <li class="unstyled">{{ $error }}</li>

    @endforeach

  </ul>

</div>
@endif
