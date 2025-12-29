import jsPDF from "jspdf";
import html2canvas from "html2canvas";

/**
 * Generate and download PDF from HTML element
 * @param {HTMLElement} element - The HTML element to convert to PDF
 * @param {string} filename - The filename for the PDF
 * @param {object} options - Additional options
 */
export async function generatePDF(element, filename, options = {}) {
    if (!element) {
        console.error("Element not found for PDF generation");
        return;
    }

    try {
        // Show loading state if callback provided
        if (options.onStart) {
            options.onStart();
        }

        // Hide elements that should not appear in PDF
        const elementsToHide = element.querySelectorAll('.pdf-exclude, [data-pdf-exclude]');
        const originalStyles = [];
        elementsToHide.forEach((el) => {
            originalStyles.push({
                element: el,
                display: el.style.display,
            });
            el.style.display = 'none';
        });

        // Configure html2canvas options
        const canvasOptions = {
            scale: 2, // Higher quality
            useCORS: true,
            logging: false,
            backgroundColor: "#ffffff",
            ...options.canvasOptions,
        };

        // Convert HTML to canvas
        const canvas = await html2canvas(element, canvasOptions);

        // Restore hidden elements
        originalStyles.forEach(({ element, display }) => {
            element.style.display = display;
        });

        // Calculate PDF dimensions
        const imgWidth = canvas.width;
        const imgHeight = canvas.height;
        const pdfWidth = 210; // A4 width in mm
        const pdfHeight = (imgHeight * pdfWidth) / imgWidth;

        // Create PDF
        const pdf = new jsPDF({
            orientation: pdfHeight > pdfWidth ? "portrait" : "landscape",
            unit: "mm",
            format: "a4",
            ...options.pdfOptions,
        });

        // Add image to PDF
        const imgData = canvas.toDataURL("image/png");
        const pageHeight = pdf.internal.pageSize.height;
        const pageWidth = pdf.internal.pageSize.width;
        
        // Calculate scaled image height for PDF
        const scaledImgHeight = (imgHeight * pageWidth) / imgWidth;
        let heightLeft = scaledImgHeight;
        let position = 0;

        // Add first page
        pdf.addImage(imgData, "PNG", 0, position, pageWidth, scaledImgHeight);
        heightLeft -= pageHeight;

        // Add additional pages if needed
        while (heightLeft > 0) {
            position = heightLeft - scaledImgHeight;
            pdf.addPage();
            pdf.addImage(imgData, "PNG", 0, position, pageWidth, scaledImgHeight);
            heightLeft -= pageHeight;
        }

        // Download PDF
        pdf.save(filename);

        // Call success callback if provided
        if (options.onSuccess) {
            options.onSuccess();
        }
    } catch (error) {
        console.error("Error generating PDF:", error);
        if (options.onError) {
            options.onError(error);
        }
    }
}

