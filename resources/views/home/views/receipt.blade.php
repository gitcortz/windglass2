<html>
	<head>
		<script src="/assets/js/jsbarcode.all.min.js"></script>
	</head>
    <body style="margin:0;padding:0;font-family:Arial Narrow;font-size:11px;width:100%;" onload="window.print();/*window.close();*/">
    
    <div style="width:350px; border: 1px solid black; padding-left:10px;">

            <h1>{{ $order->branch->name }}</h1>
            {{ $order->branch->address }}<br/>
            Tel Nos. {{ $order->branch->phone }} <br/>
            Cel. No. {{ $order->branch->mobile }}<br/>
            <br/>
            <font style="font-family:Arial Narrow;font-size:14px;">    
            {{ $order->order_date }}
            </font>
            <br/><br/>
            <table style="margin:0;padding:0;width:100%;font-family:Arial Narrow;font-size:14px;">
                <tr>
                    <td width="30%">Order Slip No.</td>
                    <td colspan=3> {{ $order->id }}</td>
                </tr>
                <tr>
                    <td>Customer:</td>
                    <td colspan=3> {{ $order->customer->name }}</td>
                </tr>
                <tr>
                    <td>Cust No:</td>
                    <td colspan=3>{{ $order->customer->id }}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td colspan=3>{{ $order->customer->address }}</td>
                </tr>
                <tr>
                    <td>Landmark:</td>
                    <td colspan=3></td>
                </tr>
                <tr>
                    <td>Tel No:</td>
                    <td colspan=3>{{ $order->customer->phone}}  / {{ $order->customer->mobile }}</td>
                </tr>
                <tr>
                    <td>Rider:</td>
                    <td colspan=3>{{ $order->rider == null ? "rider" : $order->rider->first_name." ".$order->rider->last_name }}</td>
                </tr>
            </table>
            <br/>
            <br/>
            <table style="margin:0;padding:0;width:100%;font-family:Arial Narrow;font-size:14px;">
                <tr>
                    <td>Product</td>
                    <td>QTY</td>
                    <td>Price</td>
                    <td>Disc</td>
                    <td>Amt</td>
                </tr>
                    @foreach ($order->order_items as $row)
                    <tr>
                        <td>{{ $row["stock"]->product->name }}</td>
                        <td>{{ $row["quantity"] }}</td>
                        <td>{{ number_format($row["unit_price"], 2) }}</td>
                        <td>{{ number_format($row["discount"], 2) }}</td>
                        <td>{{  number_format($row["quantity"] * ($row["unit_price"] - $row["discount"]), 2) }}</td>
                    </tr>
                    @endforeach
            </table>
            <br/>
            <br/>
            <br/>
            <br/>
            <font style="font-family:Arial Narrow;font-size:16px;">
            <b>Amount to Pay:{{ number_format($order->sub_total - $order->discount, 2) }} </b>
            </font>
            <br/>
            <br/>
            <font style="font-family:Arial Narrow;font-size:12px;">
            Received Goods in Good Condition
            </font>
            <br/>
            <svg id="barcode"></svg>
            <script>
                JsBarcode("#barcode", "{{ $order->id }}", {
                    format: "pharmacode",
                    lineColor: "#000",
                    width: 4,
                    height: 40,
                    displayValue: false
                    });
            </script>
            <br/>
            <br/>
            <br/>
            *
            <br/><br/><br/>
            *
    </div>
	</body>
</html>