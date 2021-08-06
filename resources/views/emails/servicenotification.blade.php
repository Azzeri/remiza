<!DOCTYPE html>
<html>

<head>
    <title>Remiza - nadchodzący serwis</title>
</head>

<body>
    <h1>Dzień dobry, jutro należy przeprowadzić następujące serwisy:</h1>
    @foreach ($details['services'] as $service)
        <ul>
            <li>
                {{ $service->item->databaseItems->name }}
            </li>
            <li>
                {{ $service->serviceDatabase->name }}
            </li>
            <li>
                {{ $service->perform_date }}
            </li>
        </ul>
    @endforeach

</body>

</html>
