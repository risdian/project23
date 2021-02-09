<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $order->order_number}}</title>
    <style>
        .logo{
            max-height: 100px;
            width: auto;
        }
    </style>
</head>
<body>
    <div>
        <style type="text/css">
            .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
              overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
              font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg .tg-nfig{border-color:#000000;font-size:28px;font-weight:bold;text-align:center;vertical-align:top}
            .tg .tg-y7gf{border-color:inherit;font-size:28px;text-align:center;vertical-align:top}
            .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
            .tg .tg-x61c{border-color:inherit;font-size:28px;font-weight:bold;text-align:center;vertical-align:top}
            .tg .tg-73oq{border-color:#000000;text-align:left;vertical-align:top}
            .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
            .tg .tg-7btt{border-color:inherit;font-weight:bold;text-align:center;vertical-align:top}
            .tg .tg-xam4{border-color:inherit;font-size:100%;font-weight:bold;text-align:left;vertical-align:top}
            </style>
            <table class="tg">
            <thead>
              <tr>
                <th class="tg-y7gf" colspan="4">Al ikhlas gadget</th>
                <th class="tg-y7gf" colspan="4"></th>
                <th class="tg-x61c" colspan="4">{{ $order->delivery_method }}</th>
              </tr>
            </thead>
            <tbody>
              {{-- <tr>
                <td class="tg-nfig" colspan="12">799123456789</td>
              </tr> --}}
              <tr>
                <td class="tg-73oq" colspan="7">SEND DATE: 1/2/2020<br>ORDER NUMBER : {{ $order->order_number }}</td>
                <td class="tg-0pky" colspan="5"><span style="font-weight:bold">{{ $order->city }}</span><br>{{ $order->postcode }}</td>
              </tr>
              <tr>
                <td class="tg-nfig" colspan="12">{{ $tracking }}</td>
              </tr>
              <tr>
                <td class="tg-73oq" style="border:none;  border-left: 1px solid black;"  colspan="1"></td>
                <td class="tg-0pky" colspan="6" style="border:none;  border-left: 1px solid black;" >{{ $branch->name }}</td>
                <td class="tg-0pky" colspan="5" style="border:none;  border-right: 1px solid black;" >{{ $branch->phone_number}}</td>
              </tr>
              <tr>
                <td class="tg-73oq" style="border:none;  border-left: 1px solid black;" colspan="1">From</td>
                <td class="tg-0pky" colspan="11" style="border:none;   border-left: 1px solid black;  border-right: 1px solid black;" >{{ $branch->address }} {{ $branch->postcode }} {{ $branch->city }} {{ $branch->state }} {{ $branch->country }}</td>
              </tr>
              <tr>
                <td class="tg-73oq" style="border:none;  border-left: 1px solid black; border-bottom: 1px solid black;"  colspan="1"></td>
                <td class="tg-0pky" colspan="6" style="border:none;   border-left: 1px solid black;  border-bottom: 1px solid black;" >{{ $branch->city }}, {{ $branch->state }}</td>
                <td class="tg-0pky" colspan="5" style="border:none;  border-bottom: 1px solid black;  border-right: 1px solid black;" >{{ $branch->city }}</td>
              </tr>
              <tr>
                <td class="tg-73oq"  style="border:none;  border-left: 1px solid black;"></td>
                <td class="tg-0pky" colspan="6" style="border:none;   border-left: 1px solid black;" >{{ $order->name }}</td>
                <td class="tg-0pky" colspan="5" style="border:none;  border-right: 1px solid black;" >{{ $order->phone_number }}</td>
              </tr>
              <tr>
                <td class="tg-73oq" style="border:none;  border-left: 1px solid black;">To</td>
                <td class="tg-0pky" colspan="11" style="border:none;   border-left: 1px solid black;  border-right: 1px solid black;" >{{ $order->address }} {{ $order->postcode }} {{ $order->city }} {{ $order->state }} {{ $order->country }}</td>
              </tr>
              <tr>
                <td class="tg-73oq" style="border:none;  border-left: 1px solid black;"></td>
                <td class="tg-0pky" colspan="6" style="border:none;   border-left: 1px solid black;" >{{ $order->city }}, {{ $order->state }}</td>
                <td class="tg-0pky" colspan="5" style="border:none;  border-right: 1px solid black;" >{{ $order->city }}</td>
              </tr>
              {{-- <tr>
                <td class="tg-7btt" colspan="7">No of delivery item</td>
                <td class="tg-0pky" colspan="5" style="border: none; border-top: 1px solid black;  border-right: 1px solid black;">COD 80</td>
              </tr>
              <tr>
                <td class="tg-c3ow" colspan="2">1</td>
                <td class="tg-c3ow" colspan="5">2</td>
                <td class="tg-0pky" colspan="5" style="border: none; border-right: 1px solid black;">PHP</td>
              </tr> --}}
              <tr>
                <td class="tg-0pky" colspan="7">Piece 1<br>weight 200kg<br>good: Box/Pouch</td>
                <td class="tg-0pky" colspan="5">Signature</td>
              </tr>
              <tr>
                <td class="tg-xam4" colspan="12"><span style="font-weight:bold">thank you for shopping at al ikhlas gadget</span><br>please click order received and rate this product<br><br></td>
                {{-- <td class="tg-y7gf" colspan="9"><span style="font-weight:bold">781253</span></td> --}}
              </tr>
            </tbody>
            </table>
  </div>
</body>

</html>
