<div class="alert alert-danger">
    {{-- Próprio Laravel injeta a variável errors, para validar se possui algum erro --}}
    @if($errors->any())
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
    @endif
</div>
