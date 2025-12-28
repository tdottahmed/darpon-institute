<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - Enrollment #{{ $courseRegistration->id }}</title>
  <style>
    @media print {
      body {
        margin: 0;
        padding: 0;
      }

      .no-print {
        display: none !important;
      }

      .print-break {
        page-break-after: always;
      }
    }

    body {
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
      color: #333;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background: white;
    }

    .invoice-header {
      border-bottom: 3px solid #4f46e5;
      padding-bottom: 20px;
      margin-bottom: 30px;
    }

    .invoice-title {
      font-size: 32px;
      font-weight: bold;
      color: #4f46e5;
      margin: 0;
    }

    .invoice-meta {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      flex-wrap: wrap;
      gap: 20px;
    }

    .invoice-section {
      margin-bottom: 30px;
    }

    .section-title {
      font-size: 18px;
      font-weight: bold;
      color: #1f2937;
      border-bottom: 2px solid #e5e7eb;
      padding-bottom: 8px;
      margin-bottom: 15px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 150px 1fr;
      gap: 10px 20px;
      margin-bottom: 10px;
    }

    .info-label {
      font-weight: 600;
      color: #6b7280;
    }

    .info-value {
      color: #1f2937;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    .table th {
      background-color: #f3f4f6;
      padding: 12px;
      text-align: left;
      font-weight: 600;
      color: #374151;
      border-bottom: 2px solid #e5e7eb;
    }

    .table td {
      padding: 12px;
      border-bottom: 1px solid #e5e7eb;
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
      font-weight: bold;
      font-size: 16px;
      background-color: #f9fafb;
    }

    .status-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-pending {
      background-color: #fef3c7;
      color: #92400e;
    }

    .status-confirmed {
      background-color: #dbeafe;
      color: #1e40af;
    }

    .status-completed {
      background-color: #d1fae5;
      color: #065f46;
    }

    .status-paid {
      background-color: #d1fae5;
      color: #065f46;
    }

    .status-overdue {
      background-color: #fee2e2;
      color: #991b1b;
    }

    .footer {
      margin-top: 50px;
      padding-top: 20px;
      border-top: 2px solid #e5e7eb;
      text-align: center;
      color: #6b7280;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <!-- Print Button -->
  <div class="no-print" style="margin-bottom: 20px; text-align: right;">
    <button onclick="window.print()"
            style="background: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 600;">
      🖨️ Print Invoice
    </button>
    <a href="{{ route('admin.course-registrations.show', $courseRegistration) }}"
       style="margin-left: 10px; padding: 10px 20px; border: 1px solid #d1d5db; border-radius: 6px; text-decoration: none; color: #374151; display: inline-block;">
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
        <div style="font-weight: 600; color: #1f2937; margin-bottom: 5px;">{{ config('app.name', 'Darpon') }}</div>
        <div style="color: #6b7280; font-size: 14px;">Course Enrollment Invoice</div>
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
            <td class="text-right">BDT {{ number_format($courseRegistration->installments->where('status', 'paid')->sum('amount'), 2) }}</td>
            <td colspan="2"></td>
          </tr>
          <tr class="total-row">
            <td colspan="2"><strong>Remaining Balance</strong></td>
            <td class="text-right">
              <strong>BDT {{ number_format($totalPrice - $courseRegistration->installments->where('status', 'paid')->sum('amount'), 2) }}</strong>
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
                <br><span style="color: #6b7280; font-size: 14px;">{{ $courseRegistration->courseVariation->name }}</span>
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
</body>

</html>

