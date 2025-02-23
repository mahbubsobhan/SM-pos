<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
            padding: 0;
            color: #333;
        }

        h3 {
            color: #444;
            text-transform: uppercase;
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 3px solid #04AA6D;
            display: inline-block;
            padding-bottom: 5px;
        }

        .customers {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .customers thead {
            background: linear-gradient(45deg, #04AA6D, #038C5A);
            color: white;
        }

        .customers th, .customers td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .customers th {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .customers tbody tr:nth-child(even) {
            background: #f2f2f2;
        }

        .customers tbody tr:hover {
            background: #e8ffe8;
            transition: 0.3s ease-in-out;
        }

        .customers tbody tr td {
            font-size: 13px;
        }

        /* Responsive Table */
        @media screen and (max-width: 768px) {
            .customers {
                font-size: 12px;
            }
            .customers th, .customers td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<h3>Summary</h3>

<table class="customers">
    <thead>
        <tr>
            <th>Report</th>
            <th>Date</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Vat</th>
            <th>Payable</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Sales Report</td>
            <td>{{$FormDate}} to {{$ToDate}}</td>
            <td>{{$total}}</td>
            <td>{{$discount}}</td>
            <td>{{$vat}}</td>
            <td>{{$payable}}</td>
        </tr>
    </tbody>
</table>

<h3>Details</h3>

<table class="customers">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Vat</th>
            <th>Payable</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $item)
            <tr>
                <td>{{$item->customer->name}}</td>
                <td>{{$item->customer->mobile}}</td>
                <td>{{$item->customer->email}}</td>
                <td>{{$item->total }}</td>
                <td>{{$item->discount }}</td>
                <td>{{$item->vat }}</td>
                <td>{{$item->payable }}</td>
                <td>{{$item->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
