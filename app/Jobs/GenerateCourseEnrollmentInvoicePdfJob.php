<?php

namespace App\Jobs;

use App\Models\CourseRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GenerateCourseEnrollmentInvoicePdfJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $backoff = [30, 60, 120]; // Retry after 30s, 1min, 2min

    /**
     * Create a new job instance.
     */
    public function __construct(
        public CourseRegistration $courseRegistration,
        public float $totalPrice
    ) {
        //
    }

    /**
     * Get the predictable PDF path for this registration.
     */
    public static function getPdfPath(CourseRegistration $courseRegistration): string
    {
        $invoiceNumber = 'ENR-' . str_pad($courseRegistration->id, 6, '0', STR_PAD_LEFT);
        $filename = 'Invoice-' . $invoiceNumber . '.pdf';
        return 'invoices/course-registrations/' . $filename;
    }

    /**
     * Execute the job.
     */
    public function handle(): string
    {
        // Load relationships if not already loaded
        $this->courseRegistration->loadMissing('course', 'courseVariation', 'paymentGateway', 'installments');

        // Generate PDF
        $pdf = Pdf::loadView('admin.course_registrations.invoice', [
            'courseRegistration' => $this->courseRegistration,
            'totalPrice' => $this->totalPrice,
        ])->setPaper('a4', 'portrait');

        // Get predictable path
        $path = self::getPdfPath($this->courseRegistration);

        // Store PDF in public storage
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        logger()->error('Failed to generate invoice PDF after retries', [
            'course_registration_id' => $this->courseRegistration->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
