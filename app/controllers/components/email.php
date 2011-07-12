<?php
/**
 * This is a component to send email from CakePHP using PHPMailer
 * @link http://bakery.cakephp.org/articles/view/94
 * @see http://bakery.cakephp.org/articles/view/94
 */

class EmailComponent
{
	/**
	 * Send email using SMTP Auth by default.
	 */

	var $from         = 'no-reply@theprofile.co.uk';
	var $fromName     = "theProfile";
	var $sitePrefix = 'theProfile';
	var $useSMTPAuth = false;
	var $smtpUserName = 'no-reply@theprofile.co.uk';  // SMTP username
	var $smtpPassword = 'p4ssword'; // SMTP password
	var $smtpHostNames= "mail.theprofile.co.uk";  // specify main and backup server
	var $smtpDebug = 0; // enables SMTP debug information (for testing)
	var $text_body = null;
	var $html_body = null;
	var $to = null;
	var $toName = null;
	var $subject = null;
	var $layout = 'email';
	var $cc = null;
	var $bcc = null;
	var $template = 'email/default';
	var $attachments = null;

 var $controller; 

    function startup( &$controller ) { 
      $this->controller = &$controller; 
    } 

    function bodyText() { 
    /** This is HTML body text for HTML-enabled mail clients 
     */ 

    // Temporarily store vital variables used by the controller. 
       $tmpLayout = $this->controller->layout; 
       $tmpAction = $this->controller->action; 
       $tmpOutput = $this->controller->output; 
       $tmpRender = $this->controller->autoRender; 

      ob_start(); 
      $this->controller->output = null; 
      $mail = $this->controller->render($this->template . '_text', $this->layout . '_text'); 
      ob_get_clean(); 


       // Restore the layout, view, output, and autoRender values to the controller. 
       $this->controller->layout = $tmpLayout; 
       $this->controller->action = $tmpAction; 
       $this->controller->output = $tmpOutput; 
       $this->controller->autoRender = $tmpRender; 

      return $mail; 
    } 

    function bodyHTML() { 
    /** This is HTML body text for HTML-enabled mail clients 
     */ 

    // Temporarily store vital variables used by the controller. 
       $tmpLayout = $this->controller->layout; 
       $tmpAction = $this->controller->action; 
       $tmpOutput = $this->controller->output; 
       $tmpRender = $this->controller->autoRender; 

      ob_start(); 
      $this->controller->output = null; 
      $mail = $this->controller->render($this->template . '_html', $this->layout . '_html'); 
      ob_get_clean(); 


       // Restore the layout, view, output, and autoRender values to the controller. 
       $this->controller->layout = $tmpLayout; 
       $this->controller->action = $tmpAction; 
       $this->controller->output = $tmpOutput; 
       $this->controller->autoRender = $tmpRender; 

      return $mail; 
    } 

    function attach($filename, $asfile = '') { 
      if (empty($this->attachments)) { 
        $this->attachments = array(); 
        $this->attachments[0]['filename'] = $filename; 
        $this->attachments[0]['asfile'] = $asfile; 
      } else { 
        $count = count($this->attachments); 
        $this->attachments[$count+1]['filename'] = $filename; 
        $this->attachments[$count+1]['asfile'] = $asfile; 
      } 
    } 


    function send() 
    { 
    App::import('Vendor', 'phpmailer', array('file' => 'phpmailer'.DS.'class.phpmailer.php')); 

    $mail = new PHPMailer(); 

    $mail->IsSMTP();            // set mailer to use SMTP 
    $mail->SMTPAuth = true;     // turn on SMTP authentication 
    $mail->Host   = $this->smtpHostNames; 
    $mail->Username = $this->smtpUserName; 
    $mail->Password = $this->smtpPassword; 

    $mail->From     = $this->from; 
    $mail->FromName = $this->fromName; 
    $mail->AddAddress($this->to, $this->toName ); 
    $mail->AddReplyTo($this->from, $this->fromName ); 

    $mail->CharSet  = 'UTF-8'; 
    $mail->WordWrap = 50;  // set word wrap to 50 characters 

    if (!empty($this->attachments)) { 
      foreach ($this->attachments as $attachment) { 
        if (empty($attachment['asfile'])) { 
          $mail->AddAttachment($attachment['filename']); 
        } else { 
          $mail->AddAttachment($attachment['filename'], $attachment['asfile']); 
        } 
      } 
    } 

    $mail->IsHTML(true);  // set email format to HTML 

    $mail->Subject = $this->subject; 
    $mail->Body    = $this->bodyHTML(); 
    $mail->AltBody = $this->bodyText(); 

    $result = $mail->Send(); 

    if($result == false ) $result = $mail->ErrorInfo; 

    return $result; 
    } 
} 
?>