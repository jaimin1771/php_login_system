<?php
// Include database connection and PHPMailer
require '../vendor/autoload.php';
require 'connection.php'; // Replace with your DB connection file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize response array
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email from POST request
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        $response['message'] = 'Email is required.';
        echo json_encode($response);
        exit;
    }

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $response['message'] = 'Email not found in the database.';
        echo json_encode($response);
        exit;
    }

    // Generate a unique token and expiration time
    $token = bin2hex(random_bytes(32)); // Secure token
    $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid for 1 hour
    $user_id = $result->fetch_assoc()['id'];

    // Store the token in the database
    $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $token, $expires_at);
    $stmt->execute();

    // Send the email with PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'karishamabhuha@gmail.com'; // Your email
        $mail->Password = 'gyrfkvjptbljtkhy'; // Your email app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('karishmabhuha@gmail.com', 'Your Website Name');
        $mail->addAddress($email);

        // Email content
        $reset_link = "http://php_login_system.test:8080/reset_password.php?token=$token";
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "<p>Click the link below to reset your password:</p>
                       <p><a href='$reset_link'>$reset_link</a></p>
                       <p>This link will expire in 1 hour.</p>";

        $mail->send();
        $response['success'] = true;
        $response['message'] = 'Password reset link sent to your email.';
    } catch (Exception $e) {
        $response['message'] = 'Failed to send email. Error: ' . $mail->ErrorInfo;
    }
}

echo json_encode($response);
