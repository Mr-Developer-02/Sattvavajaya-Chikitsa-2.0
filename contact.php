<?php
// contact.php - Handles contact form submission for contact.html using PHPMailer

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If using Composer autoload
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    // If you have PHPMailer files in your folder (not using Composer)
    require_once __DIR__ . '/PHPMailer.php';
    require_once __DIR__ . '/SMTP.php';
    require_once __DIR__ . '/Exception.php';
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$success = false;
$responseMsg = "";

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize input
    $firstName = isset($_POST['firstName']) ? sanitize_input($_POST['firstName']) : '';
    $lastName  = isset($_POST['lastName']) ? sanitize_input($_POST['lastName']) : '';
    $email     = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $contactNo = isset($_POST['contactNo']) ? sanitize_input($_POST['contactNo']) : '';
    $message   = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';

    // Validate required fields
    if (empty($firstName)) {
        $errors['firstName'] = "First Name is required.";
    }
    if (empty($lastName)) {
        $errors['lastName'] = "Last Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "A valid Email is required.";
    }
    if (empty($contactNo) || !preg_match('/^[0-9]{10,15}$/', $contactNo)) {
        $errors['contactNo'] = "A valid Contact Number is required.";
    }
    if (empty($message)) {
        $errors['message'] = "Message is required.";
    }

    if (empty($errors)) {
        // Prepare email
        $to = "shrirampatil246@gmail.com"; // Change to your receiving email
        $subject = "New Contact Form Submission from $firstName $lastName";
        $body = "You have received a new message from the contact form:\n\n"
              . "Name: $firstName $lastName\n"
              . "Email: $email\n"
              . "Contact No: $contactNo\n"
              . "Message:\n$message\n";

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            // $mail->isSMTP(); // Uncomment if you want to use SMTP
            // $mail->Host = 'smtp.example.com'; // Set SMTP server
            // $mail->SMTPAuth = true;
            // $mail->Username = 'your_smtp_username';
            // $mail->Password = 'your_smtp_password';
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mail->Port = 587;

            $mail->setFrom($email, "$firstName $lastName");
            $mail->addAddress($to);
            $mail->addReplyTo($email, "$firstName $lastName");
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->isHTML(false);

            if ($mail->send()) {
                $success = true;
                $responseMsg = "Thank you for contacting us! We will get back to you soon.";
            } else {
                $responseMsg = "Sorry, there was an error sending your message. Please try again later.";
            }
        } catch (Exception $e) {
            $responseMsg = "Sorry, there was an error sending your message. Please try again later.";
        }
    } else {
        $responseMsg = "Please correct the errors in the form.";
    }

    // Show thank you message or error
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Contact Form Submission</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body { font-family: Arial, sans-serif; background: #f8fafc; padding: 2em; }
            .container { max-width: 500px; margin: 2em auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); padding: 2em; }
            .success { color: #1CBCCF; font-weight: bold; }
            .error { color: #d32f2f; }
            ul { padding-left: 1.2em; }
            a { color: #1CBCCF; text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="container">
            <?php if ($success): ?>
                <p class="success" style="font-size:1.3em;"><?php echo $responseMsg; ?></p>
                <p><a href="contact.html">&larr; Back to Contact Page</a></p>
            <?php else: ?>
                <p class="error"><?php echo $responseMsg; ?></p>
                <?php if (!empty($errors)): ?>
                    <ul class="error">
                        <?php foreach ($errors as $field => $err): ?>
                            <li><?php echo $err; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p><a href="contact.html">&larr; Back to Contact Page</a></p>
            <?php endif; ?>
        </div>
    </body>
    </html>
    <?php
    exit;
} else {
    // If accessed directly, redirect to contact page
    header("Location: contact.html");
    exit;
}
