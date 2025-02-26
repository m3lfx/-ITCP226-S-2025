<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    
    <form action="{{ route('users.update', $id) }}" method="POST">
        @csrf
        <select name ="role" class="form-select" aria-label="Default select example">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><button type="submit" class="btn btn-primary" value="Submit">Update</button>
    </form>
</body>

</html>
