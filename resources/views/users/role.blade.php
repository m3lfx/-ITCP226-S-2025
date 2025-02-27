<form action="{{ route('users.update', $row->id) }}" method="POST">
    @csrf
    <select name ="role" class="form-select" aria-label="Default select example">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><button type="submit" class="btn btn-primary" value="Submit">Update</button>
</form>
