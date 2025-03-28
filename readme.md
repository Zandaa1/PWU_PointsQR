# PWU Points Tracker

The **PWU Points Tracker** is a web-based application designed to manage and track points for users. It includes features such as QR code generation, QR code scanning, and a points management system.

## Features
- **QR Code Generation**: Generate QR codes with unique text, booth names, descriptions, points, and expiration times.
- **QR Code Scanning**: Scan QR codes to claim points using a webcam or mobile camera.
- **Points Management**: Track, reset, and manage user points.
- **Responsive Design**: Optimized for both desktop and mobile devices.

---

## Libraries Used

### 1. [qr.html](https://github.com/six-two/qr.html)
This library is used for generating QR codes dynamically. It provides a lightweight and efficient way to create QR codes in the browser.

#### Integration:
- The `qr.html` library is used in the `create_qr_code.php` page to generate QR codes based on the "Unique Text" field.
- The QR code is dynamically updated as the user types in the input field.

#### Key Features:
- Lightweight and fast QR code generation.
- Customizable QR code size and error correction levels.