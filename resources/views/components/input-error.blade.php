@props(['messages'])

@if ($messages)
  <div class="text-danger mt-1 small">
    @foreach ((array) $messages as $message)
      <div>{{ $message }}</div>
    @endforeach
  </div>
@endif
