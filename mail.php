<?php 
error_reporting(0);

error_reporting(E_ALL);

require_once('PHPMailer/class.phpmailer.php'); 
include("PHPMailer/class.smtp.php");  
 
function send_template_mail_new($fromemail,$to,$subject,$description) 
{
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        
        try {
            $mail->SMTPDebug = 2;
    		$mail->SMTPAuth = true;
    
    		$mail->SMTPSecure = 'tls';
    
    		$mail->Host = "smtp.gmail.com";
    
    		$mail->Port = '587';  
            //$mail->SMTPKeepAlive = true;
    		$mail->Username = 'jmi@corrintech.com';
    
    		$mail->Password = 'jdjyqnhrrgpzyzza'; 
    
    		$mail->From = 'jmi@corrintech.com';
    
    		$mail->FromName = "Jamia Millia Islamia";
    
    		$mail->Subject = $subject;
    
    		$mail->AltBody = "";
    
    		$mail->MsgHTML($description); 
    
    		echo $mail->AddAddress($to, "User");
            
    		$mail->IsHTML(true);
    
    		$mail->SMTPOptions = array(
        		'ssl' => array(
        		'verify_peer' => false,
        		'verify_peer_name' => false,
        		'allow_self_signed' => true
        		)
    		);
    		
    		return $mail->Send(); 
    		
        }catch (phpmailerException $e) {
          echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
          echo $e->getMessage(); //Boring error messages from anything else!
        }
}

function send_template_mail($fromemail,$to,$subject,$description) 
{
  
 $mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->SMTPAuth = true;

		$mail->SMTPSecure = "tls";

		$mail->Host = 'mail.vecospace.com';

		$mail->Port = '587';  

		$mail->Username = 'info@vecospace.com';

		$mail->Password = 'admin@3214'; 

		$mail->From = 'info@vecospace.com';

		$mail->FromName = 'Jamia Millia Islamia';

		$mail->Subject = $subject;

		$mail->AltBody = "";

		$mail->MsgHTML($description); 

		$mail->AddAddress($to, "");

		$mail->IsHTML(true);

		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
		);
		$mail->Send(); 
} 

function send_template_mail_reg($fromemail,$to,$subject,$description) 
{
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        
        try {
            $mail->SMTPDebug = 0;
    		$mail->SMTPAuth = true;
    
    		$mail->SMTPSecure = 'tls';
    
    		$mail->Host = "smtp.gmail.com";
    
    		$mail->Port = '587';  
            //$mail->SMTPKeepAlive = true;
    		$mail->Username = 'jmi@corrintech.com';
    
    		$mail->Password = 'jdjyqnhrrgpzyzza'; 
    
    		$mail->From = 'jmi@corrintech.com';
    
    		$mail->FromName = "Jamia Millia Islamia";
    
    		$mail->Subject = $subject;
    
    		$mail->AltBody = "";
    
    		$mail->MsgHTML($description); 
    
    		$mail->AddAddress($to, "User");
            
    		$mail->IsHTML(true);
    
    		$mail->SMTPOptions = array(
        		'ssl' => array(
        		'verify_peer' => false,
        		'verify_peer_name' => false,
        		'allow_self_signed' => true
        		)
    		);
    		
    		$mail->Send(); 
    		
        }catch (phpmailerException $e) {
          return $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
          return $e->getMessage(); //Boring error messages from anything else!
        }
}

 ?>