<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            background: #fff;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
            font-weight: bold;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #f7f7f7;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
            font-size: 20px;
        }

        .print-btn {
            margin-bottom: 20px;
            text-align: right;
        }

        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        @media print {
            .print-btn {
                display: none;
            }

            body {
                padding: 0;
            }

            .invoice-box {
                border: none;
                box-shadow: none;
                width: 100%;
                max-width: none;
            }
        }
    </style>
</head>

<body>
    <div class="print-btn">
        <a href="javascript:window.print()" class="btn">Print Invoice</a>
        <a href="{{ route('admin.orders.index') }}" class="btn" style="background: #6c757d;">Back to Orders</a>
    </div>

    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                @php $settings = \App\Models\Backend\Setting::first(); @endphp
                                @if($settings && $settings->logo)
                                <img src="{{ asset('storage/' . $settings->logo) }}" style="max-height: 60px;">
                                @else
                                {{ $settings->site_name ?? config('app.name') }}
                                @endif
                            </td>
                            <td>
                                Invoice #: {{ $order->order_number }}<br>
                                Created: {{ $order->created_at->format('M d, Y') }}<br>
                                Status: {{ ucfirst($order->status) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>{{ $settings->site_name ?? config('app.name') }}</strong><br>
                                {!! nl2br(e($settings->site_address ?? '')) !!}<br>
                                {{ $settings->site_email ?? '' }}<br>
                                {{ $settings->site_phone ?? '' }}
                            </td>
                            <td>
                                <strong>Bill To:</strong><br>
                                {{ $order->customer_name }}<br>
                                {{ $order->customer_email }}<br>
                                {{ $order->customer_phone }}<br>
                                {{ $order->customer_address }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td style="text-align: center;">Price</td>
                <td style="text-align: center;">Qty</td>
                <td>Total</td>
            </tr>

            @foreach($order->items as $item)
            <tr class="item">
                <td>
                    {{ $item->product->name }}<br>
                    <small>Size: {{ $item->size ?? 'N/A' }}, Color: {{ $item->color ?? 'N/A' }}</small>
                </td>
                <td style="text-align: center;">${{ number_format($item->price, 2) }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td colspan="2"></td>
                <td style="text-align: right; font-weight: bold;">Subtotal:</td>
                <td>${{ number_format($order->total_amount - ($order->delivery_charge ?? 0), 2) }}</td>
            </tr>
            <tr class="total">
                <td colspan="2"></td>
                <td style="text-align: right; font-weight: bold;">Shipping:</td>
                <td>${{ number_format($order->delivery_charge ?? 0, 2) }}</td>
            </tr>
            <tr class="total">
                <td colspan="2"></td>
                <td style="text-align: right; font-weight: bold; font-size: 20px;">Total:</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </table>

        @if($order->notes)
        <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 10px;">
            <strong>Notes:</strong><br>
            {{ $order->notes }}
        </div>
        @endif

        <div style="margin-top: 50px; text-align: center; color: #777; font-size: 14px;">
            Thank you for your business!
        </div>
    </div>
</body>

</html>