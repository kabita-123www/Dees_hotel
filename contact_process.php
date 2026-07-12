<?php
/**
 * Handles the AJAX contact form submission from contact.php
 * Stores the message in the database and returns a JSON response.
 */
require_once 'config/db.php';
header('Content-Type: application/json');

function respond($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.');
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// --- Basic validation ---
if ($name === '' || $email === '' || $message === '') {
    respond(false, 'Please fill in your name, email, and message.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.');
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$name, $email, $phone, $subject, $message]);

    // Optional: send an email notification to the hotel using PHP mail()
    // mail('info@deesboutiquehotel.com', 'New Contact Form Message: ' . $subject,
    //      "Name: $name\nEmail: $email\nPhone: $phone\n\n$message");

    respond(true, 'Thank you! Your message has been sent. We will get back to you shortly.');
} catch (PDOException $e) {
    respond(false, 'Something went wrong. Please try again later.');
}
