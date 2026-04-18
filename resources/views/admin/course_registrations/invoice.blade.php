<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - Enrollment #{{ $courseRegistration->id }}</title>
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

    .invoice-brand-logo {
      height: 44px;
      width: auto;
      max-width: 200px;
      object-fit: contain;
      margin-bottom: 10px;
      display: inline-block;
      filter: brightness(0) invert(1);
    }

    @media print {
      .invoice-brand-logo {
        height: 32px;
        max-width: 160px;
      }
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

    .status-confirmed {
      background-color: #dbeafe;
      color: #1e40af;
    }

    .status-completed,
    .status-paid {
      background-color: #d1fae5;
      color: #065f46;
    }

    .status-overdue {
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
      <a href="{{ route('admin.course-registrations.show', $courseRegistration) }}"
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
            <span class="info-value">ENR-{{ str_pad($courseRegistration->id, 6, '0', STR_PAD_LEFT) }}</span>
            <span class="info-label">Date:</span>
            <span class="info-value">{{ $courseRegistration->created_at->format('F d, Y') }}</span>
            <span class="info-label">Enrollment Type:</span>
            <span class="info-value">
              <span class="status-badge status-{{ $courseRegistration->status }}">
                {{ ucfirst($courseRegistration->enrollment_type) }}
              </span>
            </span>
          </div>
        </div>
        <div style="text-align: right;">
          @php
            $invoiceLogoPath = \App\Models\Setting::get('logo_light');
            $invoiceLogoUrl = $invoiceLogoPath
                ? url(\Illuminate\Support\Facades\Storage::url($invoiceLogoPath))
                : asset('darponbdv.png');
          @endphp
          <img src="{{ $invoiceLogoUrl }}" alt="{{ config('app.name', 'Darpon') }}" class="invoice-brand-logo"
               onerror="this.style.display='none'" />
          <div style="color: rgba(255, 255, 255, 0.9); font-size: 14px;">Course Enrollment Invoice</div>
        </div>
      </div>
    </div>

    <!-- Student Information -->
    <div class="invoice-section">
      <h2 class="section-title">Student Information</h2>
      <div class="info-grid">
        <span class="info-label">Name:</span>
        <span class="info-value">{{ $courseRegistration->name }}</span>
        <span class="info-label">Email:</span>
        <span class="info-value">{{ $courseRegistration->email }}</span>
        <span class="info-label">Phone:</span>
        <span class="info-value">{{ $courseRegistration->phone }}</span>
        @if ($courseRegistration->address)
          <span class="info-label">Address:</span>
          <span class="info-value" style="white-space: pre-wrap;">{{ $courseRegistration->address }}</span>
        @endif
      </div>
    </div>

    <!-- Course Information -->
    <div class="invoice-section">
      <h2 class="section-title">Course Details</h2>
      <div class="info-grid">
        <span class="info-label">Course:</span>
        <span class="info-value" style="font-weight: 600;">{{ $courseRegistration->course->title }}</span>
        @if ($courseRegistration->courseVariation)
          <span class="info-label">Variation:</span>
          <span class="info-value">{{ $courseRegistration->courseVariation->name }}</span>
          @if ($courseRegistration->courseVariation->duration)
            <span class="info-label">Duration:</span>
            <span class="info-value">{{ $courseRegistration->courseVariation->duration }}</span>
          @endif
        @elseif ($courseRegistration->course->duration)
          <span class="info-label">Duration:</span>
          <span class="info-value">{{ $courseRegistration->course->duration }}</span>
        @endif
      </div>
    </div>

    <!-- Payment Details -->
    <div class="invoice-section">
      <h2 class="section-title">Payment Details</h2>
      @if ($courseRegistration->is_installment_payment && $courseRegistration->installments->count() > 0)
        <!-- Installment Payment -->
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Description</th>
              <th class="text-right">Amount (BDT)</th>
              <th>Due Date</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($courseRegistration->installments as $installment)
              <tr>
                <td>{{ $installment->installment_number }}</td>
                <td>Installment {{ $installment->installment_number }}</td>
                <td class="text-right">{{ number_format($installment->amount, 2) }}</td>
                <td>{{ $installment->due_date->format('M d, Y') }}</td>
                <td class="text-center">
                  <span class="status-badge status-{{ $installment->status }}">
                    {{ ucfirst($installment->status) }}
                  </span>
                </td>
              </tr>
            @endforeach
            <tr class="total-row">
              <td colspan="2"><strong>Total Amount</strong></td>
              <td class="text-right"><strong>BDT {{ number_format($totalPrice, 2) }}</strong></td>
              <td colspan="2"></td>
            </tr>
            <tr>
              <td colspan="2">Total Paid</td>
              <td class="text-right">BDT
                {{ number_format($courseRegistration->installments->where('status', 'paid')->sum('amount'), 2) }}</td>
              <td colspan="2"></td>
            </tr>
            <tr class="total-row">
              <td colspan="2"><strong>Remaining Balance</strong></td>
              <td class="text-right">
                <strong>BDT
                  {{ number_format($totalPrice - $courseRegistration->installments->where('status', 'paid')->sum('amount'), 2) }}</strong>
              </td>
              <td colspan="2"></td>
            </tr>
          </tbody>
        </table>
      @else
        <!-- One-time Payment -->
        <table class="table">
          <thead>
            <tr>
              <th>Description</th>
              <th class="text-right">Amount (BDT)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <strong>{{ $courseRegistration->course->title }}</strong>
                @if ($courseRegistration->courseVariation)
                  <br><span
                        style="color: #6b7280; font-size: 14px;">{{ $courseRegistration->courseVariation->name }}</span>
                @endif
              </td>
              <td class="text-right"><strong>BDT {{ number_format($totalPrice, 2) }}</strong></td>
            </tr>
            <tr class="total-row">
              <td><strong>Total Amount</strong></td>
              <td class="text-right"><strong>BDT {{ number_format($totalPrice, 2) }}</strong></td>
            </tr>
          </tbody>
        </table>
      @endif

      @if ($courseRegistration->payment_gateway_id)
        <div style="margin-top: 20px; padding: 15px; background-color: #f9fafb; border-radius: 6px;">
          <div class="info-grid">
            <span class="info-label">Payment Method:</span>
            <span class="info-value">{{ $courseRegistration->paymentGateway->name ?? 'N/A' }}</span>
            @if ($courseRegistration->transaction_id)
              <span class="info-label">Transaction ID:</span>
              <span class="info-value" style="font-family: monospace;">{{ $courseRegistration->transaction_id }}</span>
            @endif
            <span class="info-label">Payment Status:</span>
            <span class="info-value">
              <span class="status-badge status-{{ $courseRegistration->payment_status }}">
                {{ ucfirst($courseRegistration->payment_status) }}
              </span>
            </span>
          </div>
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
