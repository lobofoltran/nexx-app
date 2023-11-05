<style>
    .text-center {
        text-align: center;
    }

    .ttu {
        text-transform: uppercase;
    }

    .printer-ticket {
        padding:10px;
        /* margin-left: auto;
        margin-right: auto; */
        background: #ffffe0;
        display: table !important;
        width: 100%;
        max-width: 400px;
        font-weight: light;
        line-height: 1.3em;
    }

    .printer-ticket,
    .printer-ticket * {
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 10px;
    }

    .printer-ticket th:nth-child(2),
    .printer-ticket td:nth-child(2) {
        width: 50px;
    }

    .printer-ticket th:nth-child(3),
    .printer-ticket td:nth-child(3) {
        width: 90px;
        text-align: right;
    }

    .printer-ticket th {
        font-weight: inherit;
        padding: 10px 0;
        text-align: center;
        border-bottom: 1px dashed #BCBCBC;
    }

    .printer-ticket tbody tr:last-child td {
        padding-bottom: 10px;
    }

    .printer-ticket tfoot .sup td {
        padding: 10px 0;
        border-top: 1px dashed #BCBCBC;
    }

    .printer-ticket tfoot .sup.p--0 td {
        padding-bottom: 0;
    }

    .printer-ticket .title {
        font-size: 1.5em;
        padding: 15px 0;
    }

    .printer-ticket .top td {
        padding-top: 10px;
    }

    .printer-ticket .last td {
        padding-bottom: 10px;
    }
</style>
<body>
    {{-- <div style="margin-top:20px"> --}}
    <div>
        <table class="printer-ticket">
            <thead>
                <tr>
                    <th class="title" colspan="3">{{ $enterprise->name }}</th>
                </tr>
                <tr>
                    <?php $current = date('Y-m-d H:i:s') ?>
                    <th colspan="3">@dateHour($current)</th>
                </tr>
                <tr>
                    <th colspan="3">
                        Comanda #{{ $card->id }}<br/>
                        @if ($card->groupment)
                            @foreach ($card->groupment as $group)
                                Comanda #{{ $group->card->id }}<br/>
                            @endforeach
                        @endif
                    </th>
                </tr>
                <tr>
                    <th class="ttu" colspan="3">
                        <b>Cupom não fiscal</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($card->orders as $order)
                    @foreach ($order->orderItems as $orderItem)
                        <tr class="top">
                            <td colspan="3">{{ $orderItem->product->name }}</td>
                        </tr>
                        <tr>
                            <td>@money($orderItem->product->value)</td>
                            <td>1.0</td>
                            <td>@money($orderItem->product->value)</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr class="sup ttu p--0">
                    <td colspan="3">
                        <b>Totais</b>
                    </td>
                </tr>
                <tr class="ttu">
                    <td colspan="2">Sub-total</td>
                    <td align="right">@money($card->getConsummationTotal())</td>
                </tr>
                <tr class="ttu">
                    <td colspan="2">Total</td>
                    <td align="right">@money($card->getConsummationTotal())</td>
                </tr>
                <tr class="sup ttu p--0">
                    <td colspan="3">
                        <b>Pagamentos</b>
                    </td>
                </tr>
                @foreach ($card->payments as $payment)
                    <tr class="ttu">
                        <td colspan="2">{{ $payment->paymentMethod->name }}</td>
                        <td align="right">@money($payment->value)</td>
                    </tr>
                @endforeach
                <tr class="ttu">
                    <td colspan="2">Total pago</td>
                    <td align="right">@money($card->getPaidTotal())</td>
                </tr>
                <tr class="ttu">
                    <td colspan="2">Troco</td>
                    <td align="right">@money($card->getTransshipmentTotal())</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">{!! QrCode::generate($card->routeCostumer()) !!}</td>
                </tr>
                <tr class="sup">
                    <td colspan="3" align="center">
                        nexx.lobofoltran.com
                    </td>
                </tr>
            </tfoot>
        </table>
	</div>
</body>
