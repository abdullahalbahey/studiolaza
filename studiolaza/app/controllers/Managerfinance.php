<?php
class Managerfinance extends Controller
{
    public function __construct()
    {
        $this->financeModel = $this->model('Finance'); /* financeModel - Object Name */
    }

    public function index()
    {
        header('location:' . URLROOT . '/managerfinance/addfinance');
    }
    public function errormake()
    {
        $error = [
            "details"=>"",
            "findordererror" => "",   
            "amounterror" => "",
        ];
        return $error;
    }
    public function addfinance()
    {
        $data = $this->errormake();
        $financeDetails = $this->financeModel->readfinance();
        $data["details"]=$financeDetails;
  
      if (isset($_POST['submit'])) {
            
           
        $financedata = [
                "searchorder_fin" => trim($_POST['searchorder_fin']),
                "financePurpose" => trim($_POST['financePurpose']),
                "otherfinancePurpose" => trim($_POST['otherfinancePurpose']),
                "financeDate" => $_POST['financeDate'],
                "financeAmount" => trim($_POST['financeAmount']),
                "financeType" => trim($_POST['financeType'])
            ];
              



            if (empty($financedata['searchorder_fin'])) {
                $data['findordererror'] = 'Please Find an order or a booking';
            }



            if (empty($financedata['financeAmount'])) {
                $data['amounterror'] = 'Please enter the amount';
            }

          
            if (empty($data['findordererror'])  && empty($data['amounterror'])) {               
            
                if ($this->financeModel->addfinance($financedata)) { /* financeModel - Object Name in this file*/
                    echo "<script>window.alert('Finance record added')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/managerfinance'</script>";
                } else {
                    echo "<script>window.alert('Record not added')</script>";
                }
            }
        }



        $this->view('managerfinance', $data);
    }
}
