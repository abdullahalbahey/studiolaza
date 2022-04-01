<?php
class Landing extends Controller
{
    public function __construct()
    {
        $this->portfoliomodel = $this->model('Portfolio');
        $this->contactModel = $this->model('Message');
        $this->reviewModel = $this->model('Review');
    }

    public function index()
    {

        $data['review']=$this->reviewModel->fetchreview();
        $this->view('landing', $data);
        
    }

    public function aboutus()
    {
        $data = [
            'title' => 'Home page'
        ];

        $this->view('aboutus', $data);
    }
    public function errormake()
    {
        $error = [
            "details" => "",
            "firstnameerror" => "",
            "lastnameerror" => "",
            "emailerror" => "",
            "messageerror" => "",
        ];
        return $error;
    }
    public function contactus()
    {
        $data = $this->errormake();
        if (isset($_POST['contactussubmit'])) {
            $contactdata = [
                "firstnameCon" => trim($_POST['firstname']),
                "lastnameCon" => trim($_POST['lastname']),
                "emailCon" => trim($_POST['email']),
                "messageCon" => trim($_POST['subject'])
                
            ];

            if (empty($contactdata['firstnameCon'])) {
                $data['firstnameerror'] = 'Please enter first name';
            }

            if (empty($contactdata['lastnameCon'])) {
                $data['lastnameerror'] = 'Please enter last name';
            }
            if (empty($contactdata['emailCon'])) {
                $data['emailerror'] = 'Please enter email';
            }

            if (empty($contactdata['messageCon'])) {
                $data['messageerror'] = 'Please enter the message';
            }
            if (empty($data['firstnameerror'])  && empty($data['lastnameerror']) && empty($data['emailerror']) && empty($data['messageerror'])) { {
                    if ($this->contactModel->writeMessage($contactdata)) { /* contactModel - Object Name in this file*/
                        echo "<script>window.alert('Message sent')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/landing/contactus'</script>";
                    } else {
                        echo "<script>window.alert('Message not sent')</script>";
                
                    }
                }
            }
        }
        $this->view('contactus', $data);
    }

    public function portfolio()
    {
        $data['albums'] = $this->portfoliomodel->fetch_portfolio_albums();
        $this->view('portfolio', $data);
    }
    public function portfolioalbum()
    {
        if (isset($_POST['view'])) {
            $portfolio_id['portfolio_id'] = $_POST['id'];
            $data['pics'] = $this->portfoliomodel->fetch_album_pics($portfolio_id);
        }
        $this->view('portfolio_album', $data);
    }
}
