<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel File</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Upload Excel File</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('parse.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Choose Excel file</label>
            <input type="file" class="form-control" name="file" id="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
</body>
</html>
