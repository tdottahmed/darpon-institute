import jsPDF from "jspdf";
import html2canvas from "html2canvas";

/**
 * Generate and download a PDF from an HTML element.
 *
 * Fixes addressed:
 *  - Tailwind CSS-variable gradients not rendering  → dark class removed before capture
 *  - Dark mode artifacts                            → html.dark class temporarily removed
 *  - overflow-hidden / border-radius clipping       → overridden inline before capture
 *  - Wrong multi-page slicing                       → slice-canvas approach
 *  - Logo CORS                                      → useCORS + allowTaint: false
 */
export async function generatePDF(element, filename, options = {}) {
    if (!element) return;

    const html = document.documentElement;

    try {
        if (options.onStart) options.onStart();

        // ── 1. Hide pdf-exclude nodes ──────────────────────────────────────
        const excluded = [...element.querySelectorAll(".pdf-exclude, [data-pdf-exclude]")];
        excluded.forEach((el) => {
            el.dataset._pdfDisplay = el.style.display;
            el.style.display = "none";
        });

        // ── 2. Force light mode so CSS variables resolve to light-theme values ──
        const wasDark = html.classList.contains("dark");
        if (wasDark) html.classList.remove("dark");

        // ── 3. Override styles that break html2canvas ──────────────────────
        const savedRadius   = element.style.borderRadius;
        const savedOverflow = element.style.overflow;
        const savedBoxShadow = element.style.boxShadow;
        element.style.borderRadius = "0";
        element.style.overflow     = "visible";
        element.style.boxShadow    = "none";

        // ── 4. Capture ─────────────────────────────────────────────────────
        const canvas = await html2canvas(element, {
            scale: 2,
            useCORS: true,
            allowTaint: false,
            logging: false,
            backgroundColor: "#ffffff",
            // Match the real viewport so responsive classes behave correctly
            windowWidth:  document.documentElement.clientWidth,
            windowHeight: document.documentElement.clientHeight,
            // Correct for page scroll position
            scrollX: -window.scrollX,
            scrollY: -window.scrollY,
            ...options.canvasOptions,
        });

        // ── 5. Restore everything ──────────────────────────────────────────
        element.style.borderRadius = savedRadius;
        element.style.overflow     = savedOverflow;
        element.style.boxShadow    = savedBoxShadow;
        if (wasDark) html.classList.add("dark");
        excluded.forEach((el) => {
            el.style.display = el.dataset._pdfDisplay ?? "";
            delete el.dataset._pdfDisplay;
        });

        // ── 6. Build PDF ───────────────────────────────────────────────────
        const pdf       = new jsPDF({ orientation: "portrait", unit: "mm", format: "a4", ...options.pdfOptions });
        const PAGE_W_MM = pdf.internal.pageSize.getWidth();   // 210
        const PAGE_H_MM = pdf.internal.pageSize.getHeight();  // 297
        const MARGIN_MM = 10;
        const CONTENT_W = PAGE_W_MM - MARGIN_MM * 2;         // 190
        const CONTENT_H = PAGE_H_MM - MARGIN_MM * 2;         // 277

        // Pixels that correspond to one PDF content-height page
        // canvas.width = element px × 2 (scale)
        const pxPerMm       = canvas.width / CONTENT_W;       // canvas px per mm
        const sliceHeightPx = Math.floor(CONTENT_H * pxPerMm);

        let yPx      = 0;
        let pageNum  = 0;

        while (yPx < canvas.height) {
            if (pageNum > 0) pdf.addPage();

            const thisSlicePx = Math.min(sliceHeightPx, canvas.height - yPx);
            const thisSliceMm = thisSlicePx / pxPerMm;

            // Draw just this slice into a temporary canvas
            const slice    = document.createElement("canvas");
            slice.width    = canvas.width;
            slice.height   = sliceHeightPx;                   // full page height even if last slice is shorter
            const ctx      = slice.getContext("2d");
            ctx.fillStyle  = "#ffffff";
            ctx.fillRect(0, 0, slice.width, slice.height);
            ctx.drawImage(canvas, 0, yPx, canvas.width, thisSlicePx, 0, 0, canvas.width, thisSlicePx);

            pdf.addImage(
                slice.toDataURL("image/jpeg", 0.92),
                "JPEG",
                MARGIN_MM,
                MARGIN_MM,
                CONTENT_W,
                thisSliceMm,
            );

            yPx     += sliceHeightPx;
            pageNum += 1;
        }

        pdf.save(filename);
        if (options.onSuccess) options.onSuccess();
    } catch (err) {
        console.error("PDF generation error:", err);
        if (options.onError) options.onError(err);
    }
}
