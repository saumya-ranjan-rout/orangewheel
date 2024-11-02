<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Phpmailer_lib
{
    public function __construct(){
//     log_message('Debug', 'PHPMailer class is loaded.');
}

public function load($message, $subject, $to, $from,$attachmentPath){
    // Include PHPMailer library files
    include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';
    $mail = new PHPMailer(true);
    // $adminmail = new PHPMailer(TRUE);


    try{
        $mail -> SMTPDebug = 0;     
        $mail -> isSMTP();
        $mail -> SMTPAuth = true;
        $mail -> Host = "smtp.gmail.com";
        $mail -> Port = 587;  
        $mail -> SMTPSecure = "tls";                                             
        $mail -> Username = "orangewheels123@gmail.com";                                
        $mail -> Password = "muegswtcvzijgslq";     
        // $mail -> Username = "yagyaseni@3sdsolutions.com";                                
        // $mail -> Password = "dxhwmbbdmrhbnufi";          
    
        $mail -> setFrom($from,"Orange Wheels"); 
        $mail -> addAddress($to);
        $mail -> isHTML(true);
     //   $mail -> addAttachment('./userfiles/emp_images/'.$image.'', $image);
    
        $mail -> Subject = $subject;
        $mail -> Body = $message;
        $mail->addAttachment($attachmentPath);
        $mail -> send();
       // echo'<script> alert("Mail has been sent successfully!");</script>';
    
    }catch(Exception $e){
       // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    
    }


}   
}