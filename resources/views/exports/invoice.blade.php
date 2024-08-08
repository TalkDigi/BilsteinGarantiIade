<table>
    <thead>
        <tr>

            <th colspan="6" style="text-align: center; font-size: 20px; font-weight: bold;">
                Bilstein Group
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">
                Örnek Fatura
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">

            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">

            </th>
        </tr>
        <tr>
            <th>Ürün Kodu</th>
            <th>Ürün Adı</th>
            <th>Marka</th>
            <th>Fatura</th>
            <th>Miktar</th>
            <th>Birim Fatura Fiyatı</th>
            <th>Toplam</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lines as $line)
            <tr>
                <td>{{ $line['code'] }}</td>
                <td>{{ $line['desc'] }}</td>
                <td>{{ $brands[$line['code']] }}</td>
                <td>{{$line['invoice']}}</td>
                <td>{{ $line['qty'] }} Adet</td>
                <td>{{ number_format($line['price'], 2, ',', '.') }}₺</td>
                <td>{{ number_format($line['price'] * $line['qty'], 2, ',', '.') }}₺</td>
            </tr>
        @endforeach
        @if(isset($Application->application['accepted_cost']))
            <tr>
                <td>İlave Masraf</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_format($Application->application['accepted_cost'], 2, ',', '.') }}₺</td>
                <td>{{ number_format($Application->application['accepted_cost'], 2, ',', '.') }}₺</td>
            </tr>
        @endif
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">Ara Toplam:</td>
            <td>{{ number_format($total, 2, ',', '.') }}₺</td>
        </tr>
        <tr>
            <td colspan="6">Vergi 20%:</td>
            <td>{{ number_format($tax, 2, ',', '.') }}₺</td>
        </tr>
        <tr>
            <td colspan="6">Toplam:</td>
            <td>{{ number_format($total_with_tax, 2, ',', '.') }}₺</td>
        </tr>
    </tfoot>
</table>
