<?php


require 'PHPMailerAutoload.php';

function sendMail($receivermail,$subject,$body){
    $mail = new PHPMailer(true);


    //Server settings
    
    
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    //$mail->SMTPDebug=4;
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;
    $mail->Username="studiolaza4@gmail.com";
    $mail->Password="studiolaza@77";
                                                             
    $mail->SMTPSecure = "tls";        
    $mail->Port       = 587;
    $mail->setFrom('studiolaza4@gmail.com');
    $mail->addAddress($receivermail);
    // Content
    $mail->isHTML(true);
    $mail->Subject =$subject;
    $mail->Body    =$body;
    //$mail->AltBody =$altbody;


    if($mail->send()){
        echo "success";
        return true;
    }
    else{
        echo "failed";
        return false;
    } 

}
 
?>