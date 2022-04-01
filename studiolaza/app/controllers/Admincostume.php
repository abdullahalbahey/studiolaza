<?php
class Admincostume extends Controller {
    public function __construct(){
        $this->costumemodel = $this->model('Costume');
    }

    public function errormake(){
        $error=[
            "error"=>"",
            "imageerror"=>"",
            "id"=>"",
            "name"=>"",
            "image"=>"",
            "price"=>"",
            "description"=>"",
            "costumedetails"=>"",
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

        if(empty($errorchecklist['price'])){
            $data['priceerror']='Please enter price';
        }else{
            $data['priceerror']='';
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
            $uploadedimage="img/costumes/".$image_array['image']['name'];
            move_uploaded_file($image_array['image']['tmp_name'],$uploadedimage);
        }

        return $uploadedimage;
    }

    public function index(){
        $_SESSION['c_name']="";
        $_SESSION['c_description']="";
        $_SESSION['c_price']="";
        $_SESSION['array']="";
        
        header('location:'.URLROOT.'/admincostume/add');
    }

    public function add(){
        $data=$this->errormake();
        $costumedetails=$this->costumemodel->fetchcostumedetails();
        $data["costumedetails"]=$costumedetails;
        
        if(isset($_POST['add'])){
            $errorchecklist=[
                "name"=>trim($_POST['name']),
                "price"=>trim($_POST['price']),
                "description"=>$_POST['description']
                
            ];

            $_SESSION['c_name']=$errorchecklist['name'];
            $_SESSION['c_description']=$errorchecklist['description'];
            $_SESSION['c_price']=$errorchecklist['price'];
            
            $data['error']=$this->error_check($errorchecklist);
            if($data['error']['nameerror']=='' && $data['error']['priceerror']=='' && $data['error']['descriptionerror']==''){
                $uploadedimage=$this->add_update_images($_FILES);
                
                if($uploadedimage==""){
                    $data['imageerror']='Please choose image';
                }else{
                    $costumedata=[
                        "name"=>trim($_POST['name']),
                        "image"=>$uploadedimage, 
                        "price"=>trim($_POST['price']),
                        "description"=>$_POST['description']   
                         ];

                    if($this->costumemodel->addcostume($costumedata)){
                        unset($_SESSION['c_name']);
                        unset($_SESSION['c_description']);
                        unset($_SESSION['c_price']);
                        echo "<script>window.alert('Costume added')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/admincostume'</script>";
                        
                    }else{
                        echo "<script>window.alert('Costume not added')</script>";
                        
                    }          
                }
            }
        }
        $this->view('admincostumes',$data);
        
    }

    public function update(){
        $data=$this->errormake();
       
            $fetchdetails=[
                "costume_id"=>$_POST['id']
            ];     
            
            $getdetails=$this->costumemodel->fetchcostumedetailforadmintoupdate($fetchdetails);
            
            $data["id"]=$getdetails[0]->costume_id;
            $data["name"]=$getdetails[0]->name;
            $data["price"]=$getdetails[0]->price;
            $data["description"]=$getdetails[0]->description;

            $uploadedimage=$getdetails[0]->image;
        

        if(isset($_POST['submit'])){
            $errorchecklist=[
                "name"=>trim($_POST['name']),
                "price"=>trim($_POST['price']),
                "description"=>$_POST['description']
            ];
            
            $data['error']=$this->error_check($errorchecklist);
            if($data['error']['nameerror']=='' && $data['error']['priceerror']=='' && $data['error']['descriptionerror']==''){
                
                if(!empty($_FILES['image']['name'])){
                    unlink($uploadedimage);
                    $uploadedimage=$this->add_update_images($_FILES);
                }
                    $costumedata=[
                        "name"=>trim($_POST['name']),
                        "image"=>$uploadedimage, 
                        "price"=>trim($_POST['price']),
                        "description"=>$_POST['description'],
                        "id"=>$_POST['id']   
                         ];

                    if($this->costumemodel->update_costume($costumedata)){
                        echo "<script>window.alert('Costume updated')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/admincostume'</script>";
                    }else{
                        echo "<script>window.alert('Costume not updated')</script>";
                        
                    }          
            
            }
        }

        if(isset($_POST['delete'])){
            $send_id=[
                "costume_id"=>$_POST['id']
            ];
            $costume_in_wedding=$this->costumemodel->check_costume_exists($send_id);
            if($costume_in_wedding){
                echo "<script>window.alert('Costume has been chosen cannot be deleted')</script>";
            }else{
                if($this->costumemodel->delete_costume($send_id)){
                    unlink($uploadedimage);
                    echo "<script>window.alert('Costume deleted')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/admincostume'</script>";
                }
            }
            
        }

        $this->view('admincostumeupdate',$data);
    }

    
}
