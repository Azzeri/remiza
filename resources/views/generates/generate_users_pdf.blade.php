<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 target=_blank/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
        crossorigin="anonymous">
    <style>
        table {
            font-size: 12px;
        }
    </style>
    <title>Generate PDF for Users</title>
</head>

<body>
    <div class="container py-5">
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title font-weight-bold">Tabela Użytkownicy</h4>
            </div>
            <div class="card-body">
                <!-- <a class="btn btn-primary" href=" URL::to('/generates/generate_users_pdf') ">Export to PDF</a> -->
                <table class="table table-bordered mt-5">
                    <thead>
                        <tr>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th>Rola</th>
                            <th>Remiza</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dataUser)
                        <tr>
                            <td>{{ $dataUser->name }}</td>
                            <td>{{ $dataUser->surname }}</td>
                            <td>{{ $dataUser->email }}</td>
                            <td>{{ $dataUser->phone }}</td>
                            <td>{{ $dataUser->privilege }}</td>
                            <td>{{ $dataUser->fire_brigade_unit }}</td>
                        </tr>
                        @empty
                        
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>            
    </div>
    <p>Coś tutaj powinno być ale nie ma</p>
</body>

</html>