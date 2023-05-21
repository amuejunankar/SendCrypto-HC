function generatePDF(name, phoneNumber) {
    const downloadButton = document.querySelector('.download-button');
    downloadButton.textContent = 'Download PDF';
    const qrCodeStand = document.querySelector('.qr-code-stand');
    qrCodeStand.style.display = 'block'; // Show the element

    const element = document.createElement('div');
    element.classList.add('qr-code-stand');

    const logoImage = document.createElement('img');
    logoImage.classList.add('Logo');
    logoImage.src = './logo.png';
    logoImage.alt = 'Send Logo';
    element.appendChild(logoImage);

    const businessName = document.createElement('div');
    businessName.classList.add('business-name');
    businessName.textContent = name;
    element.appendChild(businessName);

    const qrCodeElement = document.getElementById('qrcode');
    const qrCode = new QRCode(qrCodeElement, {
        text: phoneNumber,
        width: 200,
        height: 200
    });

    // Generate QR code image as data URL
    const qrCodeDataURL = qrCodeElement.querySelector('img').src;

    // Create an image element with the QR code data URL
    const qrCodeImage = new Image();
    qrCodeImage.src = qrCodeDataURL;

    // Wait for the image to load before generating the PDF
    qrCodeImage.onload = () => {
        const opt = {
            margin: 0.5,
            filename: name + '_qr_code_stand.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        const canvas = document.createElement('canvas');
        canvas.width = qrCodeImage.width;
        canvas.height = qrCodeImage.height;
        const context = canvas.getContext('2d');
        context.drawImage(qrCodeImage, 0, 0);

        const qrCodeImageDataURL = canvas.toDataURL();

        // Create a new element to hold the QR code image in the PDF
        const qrCodeImageElement = document.createElement('img');
        qrCodeImageElement.src = qrCodeImageDataURL;
        qrCodeImageElement.classList.add('qr-code-image');
        element.appendChild(qrCodeImageElement);

        const scanInstructions = document.createElement('div');
        scanInstructions.classList.add('scan-instructions');
        scanInstructions.innerHTML = '<p>Scan QR code using the SendCrypto Web App for Crypto Payment.</p>';
        element.appendChild(scanInstructions);

        // Generate the PDF with the updated element
        html2pdf().set(opt).from(element).outputPdf('datauristring').then(function (pdfString) {
            const element = document.createElement('a');
            element.href = pdfString;
            element.download = name + '_qr_code_stand.pdf';
            element.click();

            // Reset the button text after generating the PDF
            downloadButton.textContent = 'Generate PDF';
        });
        qrCodeStand.style.display = 'none'; // Hide the element after generating the PDF
    };
}