<?php
class Adminportfolio extends Controller {
    public function __construct(){
        $this->portfoliomodel = $this->model('Portfolio');
    }

    public function index(){
        header('location:'.URLROOT.'/adminportfolio/add_new');
    }

    public function errormake(){
        $data=[
            'error'=>"",
            'details'=>"",
            'name'=>"",
            'portfolio_id'=>"",
            'picdetails'=>""
        ];
        return $data;
    }

    public function add_new(){
        $data=$this->errormake();
        $data["details"]=$this->portfoliomodel->fetch_portfolio_albums();
        if(isset($_POST['add'])){
            if(!empty($_POST['name'])){
                $portfolio_name['name']=$_POST['name'];
                if($this->portfoliomodel->add_new_portfolio($portfolio_name)){
                    $x=$portfolio_name['name'];
                    mkdir("img/portfolio/$x");
                    echo "<script>window.alert('Portfolio updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/adminportfolio'</script>";
                }
            }else{
                $data['error']="The name field is empty";
            }
        }
        
        $this->view('adminportfolio',$data);
    }

    public function show_pics(){
        $data=$this->errormake();
        $portfolio_id['portfolio_id']=$_POST['id'];
        $data['picdetails']=$this->portfoliomodel->fetch_album_pics($portfolio_id);
        $data['portfolio_id']=$_POST['id'];
        $data['name']=$_POST['name'];

        if(isset($_POST['delete'])){
            $data['picdetails']=$this->portfoliomodel->fetch_album_pics($portfolio_id);
            $y=$this->portfoliomodel->fetch_album_name($portfolio_id);
            $k=$y[0]->name;
            $x=count($data['picdetails']);
            for($i=0;$i<$x;$i++){
                unlink($data['picdetails'][$i]->image);
            }
            if($this->portfoliomodel->delete_album($portfolio_id)){
                rmdir("img/portfolio/$k");
                echo "<script>window.alert('Album deleted')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/adminportfolio'</script>";
            }
        }
        
        $this->view('adminportfolioupdate',$data);
    }

    public function add_pics(){
        if(isset($_POST['add'])){
            $allowedtypes[]="image/jpeg";
            $allowedtypes[]="image/png";
            $allowedtypes[]="image/jpg";

            $uploadedimage="";
            $x=count($_FILES['files']['name']);
            for($i=0;$i<$x;$i++){
                if($_FILES['files']['name'][$i]!="" && $_FILES['files']['error'][$i]==0 && in_array($_FILES['files']['type'][$i],$allowedtypes)){
                    $uploadedimage="img/portfolio/".$_POST['name']."/".$_FILES['files']['name'][$i];
                    move_uploaded_file($_FILES['files']['tmp_name'][$i],$uploadedimage);
                }
                $portfoliodata=[
                    "image"=>$uploadedimage,
                    "portfolio_id"=>$_POST['portfolio_id']
                ];
                if($this->portfoliomodel->add_pics_to_portfolio($portfoliodata)){
                    echo "<script>window.alert('Pictures added')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/adminportfolio'</script>";
                    
                }
            }
            
        }
    }

    public function delete_pics(){
        
        $x=count($_POST['id_no']);
        
        for($i=0;$i<$x;$i++){
            
            $image_id['image_id']=$_POST['id_no'][$i];
            $image_details=$this->portfoliomodel->fetch_image_details($image_id);
            unlink($image_details[0]->image);
            $j=$this->portfoliomodel->delete_pics($image_id);
            if($i==$x-1){
                echo "<script>window.alert('Pictures deleted')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/adminportfolio'</script>";
            }
        }
    }

}

    