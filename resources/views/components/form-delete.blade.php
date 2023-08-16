
<form action="{{ route('supports.destroy', $id ) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Deletar</button>
</form>
