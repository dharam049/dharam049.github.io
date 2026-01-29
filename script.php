<?php
// ...existing code...
<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

// 1. Where do you want the email sent?
$to = "rangam@skhotelgroup.com";

// 2. Collect and clean the data from the form
$name_raw    = $_POST["name"] ?? '';
$email_raw   = $_POST["email"] ?? '';
$message_raw = $_POST["message"] ?? '';

$name    = strip_tags(trim($name_raw));
$name    = str_replace(["\r", "\n"], ' ', $name); // prevent header injection
$email   = filter_var(trim($email_raw), FILTER_SANITIZE_EMAIL);
$message = trim(strip_tags($message_raw));
$message = str_replace("\0", '', $message);

// Basic validation
if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Please provide a valid name, email and message.'); window.history.back();</script>";
    exit;
}

// 3. Create the Email content
$subject = "New Website Inquiry from " . preg_replace("/[\r\n]+/", ' ', $name);

$email_content  = "Name: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

// 4. Set the Email headers
$from_address = "website@skhospitality.com";
$from_name = "SK Hospitality";

$headers  = "From: {$from_name} <{$from_address}>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// 5. Send the email — pass -f to set the envelope sender (may be ignored on some Windows setups)
$sent = mail($to, $subject, $email_content, $headers, "-f{$from_address}");

if ($sent) {
    echo "<script>alert('Your inquiry has been sent successfully!'); window.location.href='index.html';</script>";
} else {
    echo "<script>alert('Oops! Something went wrong. Please try again.'); window.history.back();</script>";
}
?>
// ...existing code...