<h1>Добавить статус задачи</h1>
@if (Auth::check())
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('task_statuses.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Название:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
    </div>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
@endif
