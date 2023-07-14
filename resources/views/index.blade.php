<h1>Статусы задач</h1>
@if (Auth::check())
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Действия</th>
    </tr>
    @foreach ($taskStatuses as $taskStatus)
        <tr>
            <td>{{ $taskStatus->id }}</td>
            <td>{{ $taskStatus->name }}</td>
            <td>
                <form action="{{ route('task_statuses.destroy', $taskStatus->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a class="btn btn-primary" href="{{ route('task_statuses.edit', $taskStatus->id) }}">Редактировать</a>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endif
