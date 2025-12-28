<?php

namespace App\Mail;

use App\Models\CourseRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CourseEnrollmentInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $courseRegistration;
    public $totalPrice;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(CourseRegistration $courseRegistration, $totalPrice, $pdfPath = null)
    {
        $this->courseRegistration = $courseRegistration;
        $this->totalPrice = $totalPrice;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course Enrollment Invoice - ' . config('app.name', 'Darpon Institute'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.course_enrollment_invoice',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!$this->pdfPath || !Storage::disk('public')->exists($this->pdfPath)) {
            // Fallback: generate PDF on the fly if stored PDF doesn't exist
            return $this->generatePdfAttachment();
        }

        // Use stored PDF
        $invoiceNumber = 'ENR-' . str_pad($this->courseRegistration->id, 6, '0', STR_PAD_LEFT);
        $filename = 'Invoice-' . $invoiceNumber . '.pdf';

        return [
            Attachment::fromStorageDisk('public', $this->pdfPath)
                ->as($filename)
                ->withMime('application/pdf'),
        ];
    }

    /**
     * Generate PDF attachment on the fly (fallback).
     */
    protected function generatePdfAttachment(): array
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.course_registrations.invoice', [
            'courseRegistration' => $this->courseRegistration,
            'totalPrice' => $this->totalPrice,
        ])->setPaper('a4', 'portrait');

        $invoiceNumber = 'ENR-' . str_pad($this->courseRegistration->id, 6, '0', STR_PAD_LEFT);
        $filename = 'Invoice-' . $invoiceNumber . '.pdf';

        return [
            Attachment::fromData(fn () => $pdf->output(), $filename)
                ->withMime('application/pdf'),
        ];
    }
}
