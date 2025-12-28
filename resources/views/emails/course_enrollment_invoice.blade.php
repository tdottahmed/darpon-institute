<!DOCTYPE html>
<html>
<head>
    <title>Course Enrollment Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #000; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <!-- Header -->
        <div style="border-bottom: 2px solid #000; padding: 20px 0; margin-bottom: 20px;">
            <h1 style="color: #000; margin: 0; font-size: 24px; font-weight: bold;">{{ config('app.name', 'Darpon Institute') }}</h1>
            <p style="color: #000; margin: 5px 0 0 0; font-size: 14px;">Course Enrollment Confirmation</p>
        </div>

        <!-- Greeting -->
        <div style="padding: 20px 0;">
            <p style="color: #000; margin: 0 0 10px 0; font-size: 16px;">Dear {{ $courseRegistration->name }},</p>
            <p style="color: #000; margin: 0; font-size: 14px;">
                Thank you for enrolling in our course. Your enrollment has been received and is being processed.
            </p>
        </div>

        <!-- Course Information -->
        <div style="border: 1px solid #000; padding: 15px; margin: 20px 0;">
            <h3 style="color: #000; margin: 0 0 15px 0; font-size: 16px; font-weight: bold;">Course Details</h3>
            <p style="margin: 5px 0; color: #000; font-size: 14px;">
                <strong>Course:</strong> {{ $courseRegistration->course->title }}
            </p>
            @if ($courseRegistration->courseVariation)
                <p style="margin: 5px 0; color: #000; font-size: 14px;">
                    <strong>Variation:</strong> {{ $courseRegistration->courseVariation->name }}
                </p>
            @endif
            <p style="margin: 5px 0; color: #000; font-size: 14px;">
                <strong>Total Amount:</strong> BDT {{ number_format($totalPrice, 2) }}
            </p>
            <p style="margin: 5px 0; color: #000; font-size: 14px;">
                <strong>Enrollment ID:</strong> #{{ $courseRegistration->id }}
            </p>
            <p style="margin: 5px 0; color: #000; font-size: 14px;">
                <strong>Enrollment Date:</strong> {{ $courseRegistration->created_at->format('F d, Y h:i A') }}
            </p>
            <p style="margin: 5px 0; color: #000; font-size: 14px;">
                <strong>Status:</strong> {{ ucfirst($courseRegistration->status) }}
            </p>
        </div>

        <!-- Invoice Attachment Notice -->
        <div style="border: 1px solid #000; padding: 15px; margin: 20px 0;">
            <p style="color: #000; margin: 0; font-size: 14px; font-weight: bold;">Invoice Attached</p>
            <p style="color: #000; margin: 5px 0 0 0; font-size: 14px;">
                Your detailed invoice has been attached to this email as a PDF document. Please keep it for your records.
            </p>
        </div>

        <!-- Next Steps -->
        <div style="padding: 20px 0;">
            <p style="color: #000; margin: 0 0 10px 0; font-size: 14px; font-weight: bold;">What's Next?</p>
            <ul style="color: #000; margin: 0; padding-left: 20px; font-size: 14px; line-height: 1.8;">
                <li>Your enrollment is being processed</li>
                <li>You will receive further instructions via email</li>
                <li>If you have any questions, please contact our support team</li>
            </ul>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #000; padding-top: 20px; margin-top: 30px;">
            <p style="color: #000; margin: 0; font-size: 14px;">
                Best regards,<br>
                <strong>The {{ config('app.name', 'Darpon Institute') }} Team</strong>
            </p>
            <p style="color: #000; margin: 15px 0 0 0; font-size: 12px;">
                This is an automated email. Please do not reply to this message.
            </p>
        </div>
    </div>
</body>
</html>
