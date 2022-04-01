<?php
class Managermessages extends Controller
{
    public function __construct()
    {
        $this->contactModel = $this->model('Message'); /* contactModel - Object Name */
        require "../app/Mailserver/Mail.php"; //email function required...
    }

    public function index()
    {
        header('location:' . URLROOT . '/managermessages/contactus');
    }
    public function errormake()
    {
        $error = [
            "details" => "",
        ];
        return $error;
    }
    public function contactus()
    {  /*var_dump($_POST);
        die;
*/

        $data = $this->errormake();
        $messageDetails = $this->contactModel->readMessage();
        $data["details"] = $messageDetails;

        $this->view('m_message', $data);
    }
    public function emailreply()
    {     
        $data['messageerror']="";     
            $replydata = [
                "messagereply" => trim($_POST['messagereply']),
                "message_id" => trim($_POST['message_id'])
            ];
            if (empty($replydata['messagereply'])) {
                $data['messageerror'] = 'Please enter the reply message';
            }
            if (empty($data['messageerror'])) {
                
                if ($this->contactModel->updateMessage($replydata)) { /* contactModel - Object Name in this file*/
                    
                    $receivermail = $_POST['email'];
                    $receiverName = $_POST['fname'];
                    $messagereply = $_POST['messagereply'];
                    $messagesrec = $_POST['message_received'];
                    $subject = "Reply for the message you sent to StudioLaza";
                    $body = "Hi " . $receiverName . "<br> We received the following message from you,<br>" . $messagesrec . "<br>" . $messagereply;

                    if (sendMail($receivermail, $subject, $body)) { //email function call
                        return true;
                    }
                    echo "<script>window.alert('Reply sent')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/managermessages'</script>";
                    
                } else {
                    echo "<script>window.alert('Could not sent reply')</script>";
                    
                }
            }
        
        $this->view('m_message', $data);
          
    }
}
