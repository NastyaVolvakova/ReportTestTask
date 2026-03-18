<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контроль выполнения процессов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-row {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success-row {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        table {
            margin-top: 20px;
        }
        th {
            text-align: left;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h1>Контроль выполнения процессов</h1>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Дата процесса</th>
            <th>Время запуска</th>
            <th>Время выполнения (сек)</th>
            <th>Идентификатор процесса</th>
            <th>Статус процесса</th>
            <th>Файл</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($processes as $process)
            @php
                $isError = $process->status->ps_name === 'Ошибка';
                $rowClass = $isError ? 'error-row' : 'success-row';
            @endphp

            <tr class="{{ $rowClass }}">
                <td>{{ Carbon\Carbon::parse($process->rp_start_datetime)->format('d.m.Y') }}</td>
                <td>{{ Carbon\Carbon::parse($process->rp_start_datetime)->format('H:i:s') }}</td>
                <td>{{ number_format($process->rp_exec_time, 4) }}</td>
                <td>{{ $process->rp_pid }}</td>
                <td>{{ $process->status->ps_name }}</td>
                <td>
                    @if ($process->rp_file_save_path && !$isError)
                        <a href="{{ route('file.download', ['filePath' => basename($process->rp_file_save_path)]) }}"
                           class="btn btn-sm btn-outline-primary"
                           title="Скачать файл">
                            {{ basename($process->rp_file_save_path) }}
                        </a>
                    @elseif ($process->rp_file_save_path && $isError)
                        {{ basename($process->rp_file_save_path) }} (ошибка)
                    @else
                        —
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Пагинация -->
    <div class="d-flex justify-content-center">
        {{ $processes->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
