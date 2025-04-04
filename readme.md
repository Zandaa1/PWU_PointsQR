# PWU Points Tracker

The **PWU Points Tracker** is a web-based application designed to manage and track points for users. It includes features such as QR code generation, QR code scanning, and a points management system.

## Features
- **QR Code Generation**: Generate QR codes with unique text, booth names, descriptions, points, and expiration times.
- **QR Code Scanning**: Scan QR codes to claim points using a webcam or mobile camera.
- **Points Management**: Track, reset, and manage user points.
- **Responsive Design**: Optimized for both desktop and mobile devices.
- **Admin Dashboard**: Complete user management with ability to view all users, edit points, and delete accounts.
- **History Tracking**: View scan history and point claims for auditing purposes.

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

### 2. [html5-qrcode](https://github.com/mebjas/html5-qrcode)
This library provides QR code scanning capabilities using a device's camera.

#### Integration:
- Used in the `scan_qr_code.php` page to enable real-time QR code scanning.
- Supports both front and back cameras on mobile devices.

#### Key Features:
- Fast and accurate QR code scanning.
- Camera selection for devices with multiple cameras.
- Works across different browsers and devices.

### 3. [add-to-homescreen](https://github.com/philfung/add-to-homescreen)
This library enables the "Add to Home Screen" functionality for Progressive Web Apps (PWAs).

#### Integration:
- Provides a prompt for users to add the application to their home screen on mobile devices.
- Enhances the mobile user experience by allowing the application to be accessed like a native app.

#### Key Features:
- Customizable prompt appearance.
- Supports iOS, Android, and other mobile platforms.
- Detects when the app is already installed to prevent redundant prompts.

## User Management

The application includes a comprehensive user management system with different access levels:

- **Student**: Basic users who can scan QR codes, view their points, and claim rewards.
- **Faculty**: Users with additional privileges related to educational activities.
- **Admin**: Full access to all features, including:
  - Creating and managing QR codes
  - Viewing all system users
  - Editing user point balances
  - Managing user accounts
  - Accessing system history and audit trails

## Security Features

- Session-based authentication
- Role-based access control
- Input validation to prevent SQL injection
- XSS protection through output escaping