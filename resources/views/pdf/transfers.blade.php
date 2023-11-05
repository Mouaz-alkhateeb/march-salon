<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #A0A0A0;
        }

    </style>
</head>
<body>
    <h1>Transfers</h1>
    <table>
        <thead>
            <tr>
                @foreach ($tableAttributes as $attribute)
                    @if ($attribute != 'attachment' && $attribute != 'created_at' && $attribute != 'updated_at')
                        <th>
                            @if ($attribute == 'user_id')
                               User
                            @elseif ($attribute == 'client_id')
                                client
                            @elseif ($attribute == 'date')
                                Date
                            @elseif ($attribute == 'transfer_amount')
                                Transfer Amount
                            @else
                                {{ $attribute }}
                            @endif
                        </th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($transfers as $transfer)
                <tr>
                    @foreach ($tableAttributes as $attribute)
                        @if ($attribute != 'attachment' && $attribute != 'created_at' && $attribute != 'updated_at')
                            <td>
                                @if ($attribute == 'user_id')
                                    {{ $transfer->user->name }}
                                @elseif ($attribute == 'client_id')
                                    {{ $transfer->client->name }}
                                @else
                                    {{ $transfer->$attribute }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
