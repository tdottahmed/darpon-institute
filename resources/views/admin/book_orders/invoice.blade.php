<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - Order #{{ $bookOrder->id }}</title>
  <style>
    /* Page sizing and print behavior */
    @page {
      size: A4;
      margin: 10mm;
    }

    @media print {

      html,
      body {
        width: 100%;
        background: white;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      body {
        margin: 0;
        padding: 10mm;
      }

      .no-print {
        display: none !important;
      }

      .print-break {
        page-break-after: always;
      }

      /* Tighter spacing for print */
      .invoice-header {
        padding-bottom: 8px;
        margin-bottom: 8px;
      }

      .invoice-title {
        font-size: 18px;
      }

      .section-title {
        font-size: 13px;
        padding-bottom: 6px;
        margin-bottom: 10px;
      }

      .info-grid {
        gap: 6px 12px;
        grid-template-columns: 120px 1fr;
      }

      .table th,
      .table td {
        padding: 6px;
        font-size: 11px;
      }

      .footer {
        font-size: 11px;
        margin-top: 20px;
        padding-top: 12px;
      }

      .status-badge {
        padding: 3px 8px;
        font-size: 11px;
      }
    }

    /* Screen layout: modern and beautiful */
    body {
      font-family: 'Inter', 'Segoe UI', 'Arial', sans-serif;
      font-size: 14px;
      line-height: 1.6;
      color: #1f2937;
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
    }

    .invoice-container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      padding: 40px;
      margin: 20px 0;
    }

    .invoice-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 30px;
      border-radius: 8px;
      margin-bottom: 30px;
    }

    .invoice-title {
      font-size: 32px;
      font-weight: 800;
      color: white;
      margin: 0 0 10px 0;
      letter-spacing: -0.5px;
    }

    .invoice-meta {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
      flex-wrap: wrap;
      gap: 15px;
      align-items: start;
      color: rgba(255, 255, 255, 0.95);
    }

    .invoice-meta .info-label {
      color: rgba(255, 255, 255, 0.8);
      font-weight: 500;
    }

    .invoice-meta .info-value {
      color: white;
      font-weight: 600;
    }

    .invoice-section {
      margin-bottom: 18px;
    }

    .section-title {
      font-size: 18px;
      font-weight: 700;
      color: #1f2937;
      border-bottom: 3px solid #667eea;
      padding-bottom: 10px;
      margin-bottom: 20px;
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -3px;
      left: 0;
      width: 60px;
      height: 3px;
      background: #764ba2;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 130px 1fr;
      gap: 8px 14px;
      margin-bottom: 6px;
    }

    .info-label {
      font-weight: 600;
      color: #6b7280;
      font-size: 13px;
    }

    .info-value {
      color: #1f2937;
      font-size: 13px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .table th {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 12px;
      text-align: left;
      font-weight: 600;
      border-bottom: none;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .table td {
      padding: 8px;
      border-bottom: 1px solid #e5e7eb;
      font-size: 13px;
    }

    .table tr:last-child td {
      border-bottom: none;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .total-row {
      font-weight: 700;
      font-size: 16px;
      background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
      border-top: 2px solid #667eea;
    }

    .status-badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
    }

    .status-pending {
      background-color: #fef3c7;
      color: #92400e;
    }

    .status-processing {
      background-color: #dbeafe;
      color: #1e40af;
    }

    .status-shipped {
      background-color: #e0e7ff;
      color: #3730a3;
    }

    .status-delivered {
      background-color: #d1fae5;
      color: #065f46;
    }

    .status-cancelled {
      background-color: #fee2e2;
      color: #991b1b;
    }

    /* Compact action buttons */
    .no-print button {
      padding: 8px 12px;
      font-size: 13px;
    }

    .no-print a {
      padding: 8px 12px;
      font-size: 13px;
    }

    .footer {
      margin-top: 30px;
      padding-top: 12px;
      border-top: 1px solid #e5e7eb;
      text-align: center;
      color: #6b7280;
      font-size: 12px;
    }

    /* Small screens - ensure readability */
    @media (max-width: 480px) {
      .info-grid {
        grid-template-columns: 1fr;
      }

      .invoice-meta {
        flex-direction: column;
        align-items: flex-start;
      }

      .invoice-title {
        font-size: 18px;
      }
    }
  </style>
</head>

<body>
  <div class="invoice-container">
    <!-- Print Button -->
    <div class="no-print" style="margin-bottom: 30px; text-align: right;">
      <button onclick="window.print()"
              style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); transition: transform 0.2s;">
        🖨️ Print Invoice
      </button>
      <a href="{{ route('admin.book-orders.show', $bookOrder) }}"
         style="margin-left: 10px; padding: 12px 24px; border: 2px solid #e5e7eb; border-radius: 8px; text-decoration: none; color: #374151; display: inline-block; font-weight: 600; transition: all 0.2s;">
        ← Back
      </a>
    </div>

    <!-- Invoice Header -->
    <div class="invoice-header">
      <h1 class="invoice-title">INVOICE</h1>
      <div class="invoice-meta">
        <div>
          <div class="info-grid">
            <span class="info-label">Invoice #:</span>
            <span class="info-value">ORD-{{ str_pad($bookOrder->id, 6, '0', STR_PAD_LEFT) }}</span>
            <span class="info-label">Date:</span>
            <span class="info-value">{{ $bookOrder->created_at->format('F d, Y') }}</span>
            <span class="info-label">Order Status:</span>
            <span class="info-value">
              <span class="status-badge status-{{ $bookOrder->status }}">
                {{ ucfirst($bookOrder->status) }}
              </span>
            </span>
          </div>
        </div>
        <div style="text-align: right;">
          <div style="font-weight: 700; color: white; margin-bottom: 5px; font-size: 20px;">{{ config('app.name', 'Darpon') }}</div>
          <div style="color: rgba(255, 255, 255, 0.9); font-size: 14px;">Book Order Invoice</div>
        </div>
      </div>
    </div>

    <!-- Customer Information -->
    <div class="invoice-section">
      <h2 class="section-title">Customer Information</h2>
      <div class="info-grid">
        <span class="info-label">Name:</span>
        <span class="info-value">{{ $bookOrder->name }}</span>
        <span class="info-label">Email:</span>
        <span class="info-value">{{ $bookOrder->email }}</span>
        <span class="info-label">Phone:</span>
        <span class="info-value">{{ $bookOrder->phone }}</span>
        <span class="info-label">Address:</span>
        <span class="info-value" style="white-space: pre-wrap;">{{ $bookOrder->address }}</span>
        <span class="info-label">Shipping Method:</span>
        <span class="info-value">{{ $bookOrder->shipping_method == 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}</span>
      </div>
    </div>

    <!-- Order Details -->
    <div class="invoice-section">
      <h2 class="section-title">Order Details</h2>
      <table class="table">
        <thead>
          <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th class="text-right">Unit Price (BDT)</th>
            <th class="text-right">Subtotal (BDT)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <strong>{{ $bookOrder->book->title ?? 'Unknown Book' }}</strong>
              @if ($bookOrder->book->author ?? null)
                <br><span style="color: #6b7280; font-size: 14px;">by {{ $bookOrder->book->author }}</span>
              @endif
            </td>
            <td>{{ $bookOrder->quantity }}</td>
            <td class="text-right">
              @php
                $bookPrice = ($bookOrder->book->discount > 0) 
                  ? $bookOrder->book->price - ($bookOrder->book->price * ($bookOrder->book->discount / 100)) 
                  : $bookOrder->book->price;
                $unitPrice = $bookPrice;
              @endphp
              {{ number_format($unitPrice, 2) }}
            </td>
            <td class="text-right">{{ number_format($unitPrice * $bookOrder->quantity, 2) }}</td>
          </tr>
          <tr>
            <td colspan="3" class="text-right">Shipping Cost:</td>
            <td class="text-right">{{ number_format($bookOrder->shipping_cost, 2) }}</td>
          </tr>
          <tr class="total-row">
            <td colspan="3"><strong>Total Amount</strong></td>
            <td class="text-right"><strong>BDT {{ number_format($bookOrder->total_amount, 2) }}</strong></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Payment Information -->
    <div class="invoice-section">
      <h2 class="section-title">Payment Information</h2>
      <div style="padding: 15px; background-color: #f9fafb; border-radius: 6px;">
        <div class="info-grid">
          <span class="info-label">Payment Method:</span>
          <span class="info-value">{{ strtoupper($bookOrder->payment_method ?? 'COD') }}</span>
          <span class="info-label">Total Amount:</span>
          <span class="info-value" style="font-weight: 700; font-size: 16px; color: #667eea;">BDT {{ number_format($bookOrder->total_amount, 2) }}</span>
        </div>
      </div>
      @if ($bookOrder->note)
        <div style="margin-top: 15px; padding: 15px; background-color: #fef3c7; border-radius: 6px; border-left: 4px solid #f59e0b;">
          <div class="info-label" style="margin-bottom: 5px;">Order Note:</div>
          <div class="info-value">{{ $bookOrder->note }}</div>
        </div>
      @endif
      @if ($bookOrder->consignment_id || $bookOrder->tracking_code)
        <div style="margin-top: 15px; padding: 15px; background-color: #dbeafe; border-radius: 6px; border-left: 4px solid #3b82f6;">
          <div class="info-label" style="margin-bottom: 5px;">Shipping Information:</div>
          @if ($bookOrder->consignment_id)
            <div class="info-grid">
              <span class="info-label">Consignment ID:</span>
              <span class="info-value" style="font-family: monospace;">{{ $bookOrder->consignment_id }}</span>
            </div>
          @endif
          @if ($bookOrder->tracking_code)
            <div class="info-grid">
              <span class="info-label">Tracking Code:</span>
              <span class="info-value" style="font-family: monospace; font-weight: 600;">{{ $bookOrder->tracking_code }}</span>
            </div>
          @endif
          @if ($bookOrder->consignment_created_at)
            <div class="info-grid">
              <span class="info-label">Shipped Date:</span>
              <span class="info-value">{{ $bookOrder->consignment_created_at->format('F d, Y h:i A') }}</span>
            </div>
          @endif
        </div>
      @endif
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>This is a computer-generated invoice. No signature required.</p>
      <p style="margin-top: 10px;">Generated on {{ now()->format('F d, Y h:i A') }}</p>
    </div>
  </div>
</body>

</html>

