<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
    <style>
        /* Base settings for receipt */
        body {
            font-family: 'Courier New', monospace;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            font-size: 18px;
            font-weight: bold;
            width: 80mm;
            /* Standard thermal receipt width */
            font-weight: normal;
            color: #000;
        }

        /* Receipt Container */
        .receipt-container {
            width: 80mm;
            max-width: 80mm;
            margin: 0 auto;
            background: white;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .store-details {
            font-size: 18px;
            font-weight: bold;
            line-height: 1.3;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
            margin: 4px 0;
        }

        /* Order Info */
        .order-info {
            margin-bottom: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .info-label {
            font-weight: bold;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            font-size: 18px;
            font-weight: bold;
        }

        .items-table th {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            padding: 3px 2px;
            border-bottom: 1px solid #000;
        }

        .items-table td {
            font-size: 18px;
            font-weight: bold;
            padding: 2px 2px;

        }

     .items-table tr {
    border-bottom: 2px solid #000; /* pure black, thicker for visibility */
    }

    @media print {
    .items-table tr {
    border-bottom: 2px solid #000; /* ensure print keeps it */
    }
    }


        .items-table .sl {
            width: 8%;
            text-align: center;
        }

        .items-table .description {
            width: 42%;

            font-size: 18px;
            font-weight: bold;
        }

        .items-table .qty {
            width: 10%;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .items-table .rate,
        .items-table .amount {
            width: 20%;
            text-align: right;
        }

        .item-variant {
            font-size: 18px;
            font-weight: bold;
            color: #555;
        }

        /* Totals */
        .totals {
            margin-bottom: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .grand-total {
            font-weight: bold;
            font-size: 18px;

            border-top: 1px solid #000;
            padding-top: 3px;
            margin-top: 4px;
        }

        /* Payment Info */
        .payment-info {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 6px;
        }

        .payment-title {
            font-weight: bold;
            font-size: 18px;

            margin-bottom: 4px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .card-number {
            font-family: monospace;
            letter-spacing: 1px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 8px;
        }

        .thank-you {
            font-weight: bold;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .visit-again {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 16px;
        }

        .receipt-id {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            font-family: monospace;
        }

        /* Print-specific styles */
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .receipt-container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
            }

            .receipt-container {
                page-break-inside: avoid;
            }

            @page {
                margin: 0;
                size: 80mm auto;
            }

            body * {
                visibility: hidden;
            }

            .receipt-container,
            .receipt-container * {
                visibility: visible;
            }

            .receipt-container {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        /* Hide scrollbars in web view */
        body {
            overflow: hidden;
        }
    </style>
</head>

<body>
    <!-- Fallback print instructions -->
    <div class="print-instructions" id="printInstructions">
        <h3>Printing Receipt...</h3>
        <p>If print dialog appears, click "Print" to continue</p>
        <p>Window will close automatically after printing</p>
    </div>

    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="store-name">{{config('app.name')}}</div>
            <div class="store-details">
                <div>{{config('restaurant.contact.address')}}</div>
                <div>Phone: {{config('restaurant.contact.phone')}}</div>
                <div>VAT No: {{config('restaurant.vat.vat_number')}}</div>
            </div>
        </div>

        <div class="title">RECEIPT</div>

        <!-- Order Info -->
        <div class="order-info">
            <div class="info-row">
                <div class="info-label">Order #:</div>
                <div class="info-value">{{str_pad($order->id,4,0,STR_PAD_LEFT)}}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date:</div>
                <div class="info-value">{{ date('d/m/Y', strtotime($order->created_at)) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Time:</div>
                <div class="info-value">{{ date('H:i', strtotime($order->created_at)) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Server:</div>
                <div class="info-value">{{$order->servedBy->name}}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Table:</div>
                <div class="info-value">{{$order->table_id}}</div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>

                    <th class="description">Description</th>
                    <th class="qty">Qty</th>
                    <th class="rate">Rate</th>
                    <th class="amount">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderPrice as $index => $orderDetails)
                <tr>

                    <td class="description qty">
                        {{ $orderDetails->dish->dish }}

                    </td>
                    <td class="qty">{{ $orderDetails->quantity }}</td>
                    <td class="rate">{{ number_format($orderDetails->net_price, 0) }}</td>
                    <td class="amount">{{ number_format(ceil(($orderDetails->net_price - $orderDetails->net_price *
                        $orderDetails->discount /100)/250 )*250 * $orderDetails->quantity, 0) }}</td>
                </tr>
                @if ($orderDetails->note)
                <tr>
                    <td colspan="5" class="note">{{ $orderDetails->note }}</td>
                </tr>

                @endif
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <div class="total-label">Subtotal:</div>
                <div class="total-value">{{ config('restaurant.currency.symbol') }}{{
                    number_format($order->orderPrice->sum('gross_price'), 0) }}</div>
            </div>

            @if($order->discount > 0)
            <div class="total-row">
                <div class="total-label">Discount:</div>
                <div class="total-value">
                    -{{ config('restaurant.currency.symbol') }}{{ number_format($order->discount, 0) }}</div>
            </div>
            @endif

            <div class="total-row">
                <div class="total-value">{{ config('restaurant.currency.symbol') }}{{ number_format($order->vat, 0) }}
                </div>
            </div>

            <div class="total-row grand-total">
                <div class="total-label">TOTAL:</div>
                <div class="total-value">{{ config('restaurant.currency.symbol') }}{{
                    number_format($order->orderPrice->sum('gross_price')+($order->orderPrice->sum('gross_price')*$order->vat)/100
                    - $order->discount, 0) }}</div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            @if($order->payment > 0)
            <div class="payment-title">PAYMENT DETAILS</div>

            @if(isset($order->payment_card) && $order->payment_card > 0)
            <div class="payment-row">
                <div class="payment-label">Card:</div>
                <div class="payment-value">{{ config('restaurant.currency.symbol') }}{{
                    number_format($order->payment_card, 0) }}</div>
            </div>
            @if(isset($order->card_number))
            <div class="payment-row card-number">
                <div class="payment-label">Card No:</div>
                <div class="payment-value">xxxx xxxx xxxx {{ substr($order->card_number, -4) }}</div>
            </div>
            @endif
            @endif

            @if(isset($order->payment_cheque) && $order->payment_cheque > 0)
            <div class="payment-row">
                <div class="payment-label">Cheque:</div>
                <div class="payment-value">{{ config('restaurant.currency.symbol') }}{{
                    number_format($order->payment_cheque, 0) }}</div>
            </div>
            @if(isset($order->cheque_number))
            <div class="payment-row">
                <div class="payment-label">Cheque No:</div>
                <div class="payment-value">{{ $order->cheque_number }}</div>
            </div>
            @endif
            @endif

            @if(isset($order->payment_cash) && $order->payment_cash > 0)
            <div class="payment-row">
                <div class="payment-label">Cash:</div>
                <div class="payment-value">{{ config('restaurant.currency.symbol') }}{{
                    number_format($order->payment_cash, 0) }}</div>
            </div>
            @endif

            <div class="payment-row">
                <div class="payment-label">Cash Tendered:</div>
                <div class="payment-value">{{ config('restaurant.currency.symbol') }}{{ number_format($order->payment,
                    0) }}</div>
            </div>

            <div class="payment-row">
                <div class="payment-label">Change:</div>
                <div class="payment-value">{{ config('restaurant.currency.symbol') }}{{
                    number_format($order->change_amount, 0) }}</div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">Thank You For Your Order</div>
            <div class="visit-again">Please Visit Again</div>
            <div class="receipt-id">{{ date('YmdHis', strtotime($order->created_at)) }}{{ str_pad($order->id, 4, '0',
                STR_PAD_LEFT) }}</div>
        </div>
    </div>

    <script>
        // Enhanced auto-print functionality
        let printAttempted = false;

        function autoPrint() {
            if (printAttempted) return;
            printAttempted = true;

            // Show instructions briefly
            const instructions = document.getElementById('printInstructions');
            if (instructions) {
                instructions.classList.add('show');
                setTimeout(() => instructions.classList.remove('show'), 2000);
            }

            // Try to print immediately
            try {


                // Close window after a short delay
                setTimeout(function() {
                    window.close();
                }, 2000);
            } catch (e) {
                console.log('Print failed:', e);
                // Fallback: close window anyway
                setTimeout(function() {
                    window.close();
                }, 3000);
            }
        }

        // Execute print as soon as possible
        if (document.readyState === 'loading') {
            // Document still loading
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(autoPrint, 100);
            });
        } else {
            // Document already loaded
            setTimeout(autoPrint, 50);
        }

        // Also try on window load as backup
        window.addEventListener('load', function() {
            setTimeout(autoPrint, 100);
        });

        // Force print on any user interaction (for browsers that block auto-print)
        document.addEventListener('click', autoPrint);
        document.addEventListener('keydown', autoPrint);

        // Auto-close after 5 seconds if nothing happens
        setTimeout(function() {
            if (!printAttempted) {
                window.close();
            }
        }, 5000);
    </script>
</body>

</html>
