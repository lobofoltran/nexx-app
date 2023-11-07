<body>
    <table>
        <tr>
            <td align="center">Comanda #{{ $card->id }}</td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td align="center">{!! QrCode::generate($card->routeCostumer()) !!}</td>
        </tr>
        <tr>
            <td align="center">Visualize sua comanda escaneando o QR Code e realize pedidos.</td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td align="center">nexx.lobofoltran.com</td>
        </tr>
    </table>
</body>
