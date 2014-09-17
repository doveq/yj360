@if ($errors->any())
<div id="error_explanation">
    <h2>{{ count($errors->all()) }} prohibited
      this article from being saved:</h2>
    <ul>
    @foreach ($errors->all() as $message)
      <li>{{ $message }}</li>
    @endforeach
    </ul>
  </div>
@endif