{{-- Inserisco una sezione popup da mostrare per confermare la cancellazione di un item --}}

@if (session('alert-message'))
  <div id="popup_message" class="d-none" data-type="{{ session('alert-type') }}" data-message="{{ session('alert-message') }}"></div>
@endif