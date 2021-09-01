<?php 
/**
 * A helper for phpmailer class
 */
require_once APP_ROOT . '/third_party/PHPMailer/PHPMailerAutoload.php';

class Mailer
{
    public function __construct()
    {
        $this->_mail = new PHPMailer;
    }
    public function mail($subject,$message,$receiverEmail,$senderName)
    {
    	try {
		    //Server settings
		    $this->_mail->SMTPDebug = 0;                                       // Enable verbose debug output
		    $this->_mail->isSMTP();                                            // Set mailer to use SMTP
		    $this->_mail->Host       = 'ssl://premium29.web-hosting.com';  // Specify main and backup SMTP servers
		    $mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		        )
		    );
		    $this->_mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $this->_mail->Username   = 'testing@test.com';                     // SMTP username
		    $this->_mail->Password   = 'password';                               // SMTP password
		    $this->_mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
		    $this->_mail->Port       = 465;                                    // TCP port to connect to

		    //Recipients
		    $this->_mail->setFrom('testing@test.com', 'noreply');
		    $this->_mail->addAddress($receiverEmail, 'Receiver');     // Add a recipient
		   /* $this->_mail->addAddress('ellen@example.com');       */        // Name is optional
		    //$this->_mail->addReplyTo($senderEmail, 'Information');
		    /*$this->_mail->addCC('cc@example.com');
		    $this->_mail->addBCC('bcc@example.com');*/

		    // Attachments
		    /*$this->_mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		    $this->_mail->addAttachment('/tmp/image.jpg', 'new.jpg'); */   // Optional name

		    // Content
		    $this->_mail->isHTML(true);                                  // Set email format to HTML
		    $this->_mail->Subject = $subject;
		    $this->_mail->Body    = $message.'.<p>Message was sent from CorpAcademia</p>';
		    // $this->_mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    if($this->_mail->send()) return 'Invitation has been sent';
		    
		} catch (Exception $e) {
		    return "Message could not be sent. Mailer Error: {$this->_mail->ErrorInfo}";
		}
    }
}
?>