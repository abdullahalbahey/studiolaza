<?php
class Adminthankingcard extends Controller {
    public function __construct(){
        $this->thankingcardmodel = $this->model('Thankingcard');
    }

    public function errormake(){
        $error=[
            "error"=>"",
            "imageerror"=>"",
            "id"=>"",
            "name"=>"",
            "image"=>"",
            "description"=>"",
            "thankingcarddetails"=>"",
            "searchdetails"=>""
        ];

        return $error;
    }

    public function error_check($errorchecklist=[]){
        if(empty($errorchecklist['name'])){
            $data['nameerror']='Please enter name';
        }else{
            $data['nameerror']='';
        }
        if(!strlen(trim($_POST['description']))){
            $data["descriptionerror"]='Please enter description';
        }else{
            $data['descriptionerror']='';
        }
        return $data;
    }

    public function add_update_images($image_array=[]){
        $allowedtypes[]="image/jpeg";
        $allowedtypes[]="image/png";
        $allowedtypes[]="image/jpg";

        $uploadedimage="";
        if($image_array['image']['name']!="" && $image_array['image']['error']==0 && in_array($image_array['image']['type'],$allowedtypes)){
            $uploadedimage="img/thankingcard/".$image_array['image']['name'];
            move_uploaded_file($image_array['image']['tmp_name'],$uploadedimage);
        }

        return $uploadedimage;
    }

    public function index(){
        $_SESSION['t_name']="";
        $_SESSION['t_description']="";
        $_SESSION['array_2']="";
        
        header('location:'.URLROOT.'/adminthankingcard/add');
    }

    public function add(){
        $data=$this->errormake();
        $thankingcarddetails=$this->thankingcardmodel->fetchthankingcarddetails();
        $data["thankingcarddetails"]=$thankingcarddetails;

        $thanking_name=$this->thankingcardmodel->fetch_thankingcard_name();
        $y=count($thanking_name);
        for($a=0;$a<$y;$a++){
            $_SESSION["array_2"][$a]=$thanking_name[$a]->name;
        }
        
        if(isset($_POST['add'])){
            $errorchecklist=[
                "name"=>trim($_POST['name']),
                "description"=>$_POST['description']
                
            ];
            $_SESSION['t_name']=$errorchecklist['name'];
            $_SESSION['t_description']=$errorchecklist['description'];
            
            $data['error']=$this->error_check($errorchecklist);
            if($data['error']['nameerror']=='' && $data['error']['descriptionerror']==''){
                $uploadedimage=$this->add_update_images($_FILES);
                
                if($uploadedimage==""){
                    $data['imageerror']='Please choose image';
                }else{
                    $thankingcarddata=[
                        "name"=>trim($_POST['name']),
                        "image"=>$uploadedimage, 
                        "description"=>$_POST['description']   
                         ];

                    if($this->thankingcardmodel->addthankingcard($thankingcarddata)){
                        unset($_SESSION['t_name']);
                        unset($_SESSION['t_description']);
                        echo "<script>window.alert('Thanking card added')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/adminthankingcard'</script>";
                    }else{
                        echo "<script>window.alert('Thanking card not added')</script>";
                        
                    }          
                }
            }
        }
        $this->view('adminthankingcard',$data);
        
    }

    public function update(){
        $data=$this->errormake();
       
            $fetchdetails=[
                "thankingcard_id"=>$_POST['id']
            ];     
            
            $getdetails=$this->thankingcardmodel->fetchthankingcarddetailforadmintoupdate($fetchdetails);
            
            $data["id"]=$getdetails[0]->thankingcard_id;
            $data["name"]=$getdetails[0]->name;
            $data["description"]=$getdetails[0]->description;

            $uploadedimage=$getdetails[0]->image;
        

        if(isset($_POST['submit'])){
            $errorchecklist=[
                "name"=>trim($_POST['name']),
                "description"=>$_POST['description']
            ];
            
            $data['error']=$this->error_check($errorchecklist);
            if($data['error']['nameerror']=='' && $data['error']['priceerror']=='' && $data['error']['descriptionerror']==''){
                
                if(!empty($_FILES['image']['name'])){
                    unlink($uploadedimage);
                    $uploadedimage=$this->add_update_images($_FILES);
                }
                    $thankingcarddata=[
                        "name"=>trim($_POST['name']),
                        "image"=>$uploadedimage, 
                        "description"=>$_POST['description'],
                        "id"=>$_POST['id']   
                         ];

                    if($this->thankingcardmodel->update_thankingcard($thankingcarddata)){
                        echo "<script>window.alert('Thanking card updated')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/adminthankingcard'</script>";
                    }else{
                        echo "<script>window.alert('Thanking card not updated')</script>";
                        
                    }          
            
            }
        }

        if(isset($_POST['delete'])){
            $send_id=[
                "thankingcard_id"=>$_POST['id']
            ];
            $thanking_in_wedding=$this->thankingcardmodel->check_thankingcard_exists($send_id);
            if($thanking_in_wedding){
                echo "<script>window.alert('Cannot delete customer has chosen ')</script>";
                
            }else{
                if($this->thankingcardmodel->delete_thankingcard($send_id)){
                    unlink($uploadedimage);
                    echo "<script>window.alert('Thanking card deleted')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/adminthankingcard'</script>";
                }
            }
        }

        $this->view('adminthankingcardupdate',$data);
    }

    
}
