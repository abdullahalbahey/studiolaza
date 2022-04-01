<?php
class Customerreview extends Controller {
    public function __construct() {
        $this->reviewmodel = $this->model('Review');
        $this->customermodel = $this->model('Customer');
    }

    public function index() {
         
        header('location:'.URLROOT.'/Customerreview/add_review');
    }

    public function add_review() {
        $customer_id=[
            "id"=>$_SESSION['id']
        ];

        $customer=$this->customermodel->fetchcustomerid($customer_id);


        $customer_data["customer_id"]=$customer[0]->customer_id;
        $review=$this->reviewmodel->fetch_review($customer_data);

        $data['content']='';
        $data['id']='';
        $data['rating']='';

        if($review){
            $data['content']=$review[0]->content;
            $data['id']=$review[0]->review_id;
            $data['rating']=$review[0]->rating;
        }

        if(isset($_POST['add'])){

            $reviewdata=[
                "content"=>$_POST['review'],
                "date"=>date('Y-m-d'),
                "time"=>date("H:i:S"),
                "rating"=>$_POST['rating'],
                "customer_id"=>$customer[0]->customer_id
            ];
    
            if($this->reviewmodel->add_review($reviewdata)){
                echo "<script>window.alert('Review added')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerreview'</script>";
            }

        }

        if(isset($_POST['update'])){
            $reviewdata=[
                "content"=>$_POST['review'],
                "date"=>date('Y-m-d'),
                "time"=>date("H:i:S"),
                "rating"=>$_POST['rating'],
                "review_id"=>$_POST['review_id']
            ];
    
            if($this->reviewmodel->update_review($reviewdata)){
                echo "<script>window.alert('Review updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerreview'</script>";
            }
        }

        if(isset($_POST['delete'])){
            $reviewdata=[
                "review_id"=>$_POST['review_id']
            ];
    
            if($this->reviewmodel->delete_review($reviewdata)){
                echo "<script>window.alert('Review deleted')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerreview'</script>";
            }
        }

        $this->view('customerreview',$data); 
    }

    



    
}