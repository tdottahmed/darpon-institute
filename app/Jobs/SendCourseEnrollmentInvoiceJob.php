<?php

namespace App\Jobs;

use App\Jobs\GenerateCourseEnrollmentInvoicePdfJob;
use App\Mail\CourseEnrollmentInvoiceMail;
use App\Models\CourseRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendCourseEnrollmentInvoiceJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $backoff = [60, 180, 600]; // Retry after 1min, 3min, 10min

    /**
     * Create a new job instance.
     */
    public function __construct(
        public CourseRegistration $courseRegistration,
        public float $totalPrice,
        public ?string $pdfPath = null
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Use provided PDF path or get predictable path
        $pdfPath = $this->pdfPath ?? GenerateCourseEnrollmentInvoicePdfJob::getPdfPath($this->courseRegistration);

        // If PDF doesn't exist, generate it first
        if (!Storage::disk('public')->exists($pdfPath)) {
            $pdfJob = new GenerateCourseEnrollmentInvoicePdfJob($this->courseRegistration, $this->totalPrice);
            $pdfPath = $pdfJob->handle();
        }

        // Verify PDF exists
        if (!Storage::disk('public')->exists($pdfPath)) {
            throw new \Exception("Invoice PDF not found at path: {$pdfPath}");
        }

        // Send email with stored PDF
        Mail::to($this->courseRegistration->email)
            ->send(new CourseEnrollmentInvoiceMail($this->courseRegistration, $this->totalPrice, $pdfPath));
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        logger()->error('Failed to send invoice email after retries', [
            'course_registration_id' => $this->courseRegistration->id,
            'email' => $this->courseRegistration->email,
            'pdf_path' => $this->pdfPath,
            'error' => $exception->getMessage(),
        ]);
    }
}
