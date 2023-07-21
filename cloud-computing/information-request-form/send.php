<!-- From https://github.com/PHPMailer/PHPMailer -->
<?php
ob_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

// Retrieve form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$formattedPhoneNumber = sprintf(
    "(%s) %s-%s",
    substr($phoneNumber, 0, 3),
    substr($phoneNumber, 3, 3),
    substr($phoneNumber, 6, 4)
);
$schoolYear = $_POST['schoolYear'];
$degreePath = $_POST['degreePath'];
$desiredOutcome = $_POST['desiredOutcome'];

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // CONFIG SETTINGS FOR @OUTLOOK.COM https://support.microsoft.com/en-au/office/pop-imap-and-smtp-settings-for-outlook-com-d088b986-291d-42b8-9564-9c414e2aa040
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                   //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'pwdiscloud4910c@outlook.com';          //SMTP username
    $mail->Password   = 'Cloud4910C';                           //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('pwdiscloud4910c@outlook.com', 'CEN CLOUD');
    $mail->addAddress('pwdiscloud4910c@outlook.com', 'CEN CLOUD');

    //Content
    $mail->isHTML(true);
    $mail->Subject = "Information Request from $firstName $lastName";
    $mail->Body    = "
    <table>
        <tr>
            <th align='left' style='padding-right: 20px;'>Name</th>
            <td>$firstName $lastName</td>
        </tr>
        <tr>
            <th align='left' style='padding-right: 20px;'>Email</th>
            <td>$email</td>
        </tr>
        <tr>
            <th align='left' style='padding-right: 20px;'>Phone Number</th>
            <td>$formattedPhoneNumber</td>
        </tr>
        <tr>
            <th align='left' style='padding-right: 20px;'>School Year</th>
            <td>$schoolYear</td>
        </tr>
        <tr>
            <th align='left' style='padding-right: 20px;'>Degree Path</th>
            <td>$degreePath</td>
        </tr>
        <tr>
            <th align='left' style='padding-right: 20px;'>Desired Outcome</th>
            <td>$desiredOutcome</td>
        </tr>
    </table>";

    $mail->send();
    echo "
    <script>
        alert('Message has been sent');
        window.location.href='information-request-form.html';
    </script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}