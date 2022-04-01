<?php
class Adminpackages extends Controller {
    public function __construct(){
        $this->packagesmodel = $this->model('Packages');
        
    }

    

    public function index() {
         
        $packagedetails=$this->packagesmodel->fetchdetails();
      
        $data['packagedetails']=$packagedetails;
        
        $this->view('adminpackages',$data);  
    }

    public function update(){
        if(isset($_POST['update'])){
            $_SESSION['package_id']=$_POST['id'];
        }
            
            $fetchdetails=[
                "package_id"=>$_SESSION['package_id']
            ];     
            
            $getdetails=$this->packagesmodel->fetchpackagedetail($fetchdetails);
            
            
            $data["id"]=$getdetails[0]->package_id;
            $data["name"]=$getdetails[0]->name;
            $data["price"]=$getdetails[0]->price;
        if(isset($_POST['update_price'])){
            if(empty($_POST['price'])){
                $data["package_error"]="This field can't be empty";
            }else{
                $price['price']=$_POST['price'];
                $price['package_id']=$_SESSION['package_id'];
                if($this->packagesmodel->update_price($price)){
                    echo "<script>window.alert('Price successfully updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/adminpackages'</script>";
                }
            }
        }
            

            $this->view('adminpackagesupdate',$data);
        
        
    }
}