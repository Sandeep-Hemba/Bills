<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Log posted data for debugging
file_put_contents('log.txt', print_r($_POST, true), FILE_APPEND);

$email = $_POST['email'];
$custname = $_POST['custname'];
$items = nl2br($_POST['items']); // Bill items
$subtotal = $_POST['subtotal'];
$tax = $_POST['tax'];
$total = $_POST['total'];

// Add debug output to check values
/* echo "Email: $email<br>";
echo "Customer Name: $custname<br>";
echo "Items: $items<br>";
echo "Subtotal: $subtotal<br>";
echo "Tax: $tax<br>";
echo "Total: $total<br>";
*/

$mail = new PHPMailer(true);

try{ 
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'sandeephamba@gmail.com';
    $mail->Password = 'ueyt fivn beuc pqji';

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];
    
    $mail->setFrom('sandeephamba@gmail.com', 'Sunny Restaurant');
    $mail->addAddress($email);
    
    $mail->isHTML(true);
    $mail->Subject = 'Restaurant Bill';

    // HTML email body with dynamic bill content
    $mail->Body =  "
<html>
    <body>
        <h3>Dear {$custname}</h3>
        <div class='bill-section'>
            <h2 style='text-align: center;'>Sunny Ristorante</h2>
            <p style='text-align: center;'>123 Foodie Street, Culinary City</p>
            <p style='text-align: center;'>Phone: (123) 456-7890</p>
            <p>Date & Time: " . date('Y-m-d H:i:s') . "</p>
            <table border='1' cellpadding='10'>
                <thead>
                    <tr>
                        <th colspan='4'>Item</th>
                        
                    </tr>
                </thead>
                <tbody>
                   <td colspan='4'>{$items}</td>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan='3'><strong>Subtotal</strong></td>
                        <td>₹{$subtotal}</td>
                    </tr>
                    <tr>
                        <td colspan='3'><strong>Tax (5%)</strong></td>
                        <td>₹{$tax}</td>
                    </tr>
                    <tr>
                        <td colspan='3'><strong>Total</strong></td>
                        <td>₹{$total}</td>
                    </tr>
                </tfoot>
            </table>
            <p style='text-align: center; font-weight: bold;'>Thank you for visiting Sunny Restaurant!</p>
        </div>
    </body>
</html>
";

    $mail->send();
    echo "<script>alert('Mail sent successfully');
    window.location.href='index.html';</script>";
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}

?>