<!-- resources/views/spreadsheet.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Google Spreadsheet Data</title>
</head>
<body>
    <h1>Google Spreadsheet Data</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Details</th>
                <th>Amounts</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($values as $row)
                <tr>
                    <td>{{ $row[0] }}</td>
                    <td>{{ $row[1] }}</td>
                    <td>{{ $row[2] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
