<?php
class Customerbooking extends Controller {
    public function __construct() {
        $this->customermodel = $this->model('Customer');
        $this->bookingmodel = $this->model('Booking');
        $this->thankingcardmodel = $this->model('Thankingcard');
        $this->costumemodel = $this->model('Costume');
        $this->packagesmodel = $this->model('Packages');
    }

    public function errormake(){
        $data=[
            "weddingdetails"=>"",
            "preshootdetails"=>"",
            "engagementdetails"=>"",
            "homecomingdetails"=>""
        ];
        return $data;
    }
    public function verifymail(){
        $id['user_id']=$_GET['mail_id'];
        $_SESSION['uid']=$_GET['mail_id'];
        if($this->customermodel->update_vstatus($id)){
            header('location:'.URLROOT.'/Customerbooking');
        }
    }

    public function index() {
        if(isset($_SESSION['id'])){
            $customer['user_id']=$_SESSION['id'];
        }else{
            $customer['user_id']=$_SESSION['uid'];
        }
        
        $status=$this->customermodel->fetch_status($customer);
        if($status[0]->v_status==1){
            unset($_SESSION['uid']);
            header('location:'.URLROOT.'/Customerbooking/bookingnumber');
        }
        else{
            echo "Please Verify the email";
        }
        
    }

    public function bookingnumber() {
        $id= [
            "id"=>$_SESSION["id"]
        ];

        $customerid = $this->customermodel->fetchcustomerid($id);
        $customer['customerid']=$customerid[0]->customer_id;
        $data['numberofbookings']=$this->bookingmodel->fetchingbookingnumber($customer);

        if(($data['numberofbookings'])){
            $this->view('customerbookingnumber',$data);

        } else {
            header('location:'.URLROOT.'/Booknow');
        }
    }

    public function fetchbookingdetails() {
        
        $data=$this->errormake();
        if(isset($_POST['view_details'])){
            $_SESSION['bookingid']=$_POST['id'];
        }
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            
            $booking_payment=$this->bookingmodel->fetchbooking($id);
            $booking_date=$this->bookingmodel->fetch_date_cancel($id);
            $weddingdetails=$this->bookingmodel->fetchweddingdetails($id);
            $preshootdetails=$this->bookingmodel->fetchpreshootdetails($id);
            $homecomingdetails=$this->bookingmodel->fetchhomecomingdetails($id);
            $engagementdetails=$this->bookingmodel->fetchengagementdetails($id);
            
            $_SESSION['cancel_date']=$booking_date[0]->date;
            $data['booking_data']=$booking_payment;
            $data["weddingdetails"]=$weddingdetails;
            $data["homecomingdetails"]=$homecomingdetails;
            $data["preshootdetails"]=$preshootdetails;
            $data["engagementdetails"]=$engagementdetails;
            
        
        $this->view('customerviewbooking', $data);
    }

    public function view_details_wedding(){
        $data=$this->errormake();
        
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["weddingdetails"]=$this->bookingmodel->fetchweddingdetails($id);
            $data['details']=$data['weddingdetails'][0]->progress;
            
        $this->view('weddingdetails', $data);
    }

    public function view_details_preshoot(){
        $data=$this->errormake();
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["preshootdetails"]=$this->bookingmodel->fetchpreshootdetails($id);
            $data["details"]=$data['preshootdetails'][0]->progress;
        $this->view('weddingdetails', $data);
    }

    public function view_details_engagement(){
        $data=$this->errormake();
       
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["engagementdetails"]=$this->bookingmodel->fetchengagementdetails($id);
            $data['details']=$data['engagementdetails'][0]->progress;
        $this->view('weddingdetails', $data);
    }

    public function view_details_homecoming(){
        $data=$this->errormake();
        
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["homecomingdetails"]=$this->bookingmodel->fetchhomecomingdetails($id);
            $data['details']=$data['homecomingdetails'][0]->progress;
        $this->view('weddingdetails', $data);
    }
             
    public function show_update_form(){
        
        if(isset($_POST['wform']) && isset($_POST['cform']) && empty($_POST['tform'])){
            header('location:'.URLROOT.'/customerbooking/costumeform');
        }
        else if(isset($_POST['wform']) && isset($_POST['tform']) && empty($_POST['cform'])){
            header('location:'.URLROOT.'/customerbooking/thankingcardform');
        }
        else if(isset($_POST['wform']) && isset($_POST['tform']) && isset($_POST['cform'])){ 
           $this->view("wedding_update_form"); 
        }
        if(isset($_POST['pform'])){
            $this->view("preshoot_update_form"); 
        }
        if(isset($_POST['eform'])){
            $this->view("engagement_update_form"); 
        }
        if(isset($_POST['hform'])){
            $this->view("homecoming_update_form"); 
         }
    }

    public function weddingform() {
        
        $booking_id['bookingid']=$_SESSION['bookingid'];
        $data["weddingdetails"]=$this->bookingmodel->fetchweddingdetails($booking_id);
                
        if(isset($_POST['savedetails'])) { 
            $price=0;
            $details="";
            if($data['weddingdetails'][0]->thankingcard_id!=NULL){
                $price=$data['weddingdetails'][0]->thankingcard_price;
                if($data['weddingdetails'][0]->costume_id!=NULL){
                    $costume['costume_id']=$data['weddingdetails'][0]->costume_id;
                    $c_price=$this->costumemodel->fetch_costume_price($costume);
                    $price=$price+$c_price[0]->price;
                }
                
            }
            $packagedetails=$this->packagesmodel->fetchpricedetails();

            //bride's preparation shoot
            if(isset($_POST['bridepreparation'])) {
                $details=$details.$_POST['bridepreparation'].nl2br("\n");
                $price=$price+$packagedetails[0]->price;
            }

            //groom's preparation shoot
            if(isset($_POST['groompreparation'])) {
                $details=$details.$_POST['groompreparation'].nl2br("\n");
                $price=$price+$packagedetails[2]->price;
            }

            //magazine album
            if(isset($_POST['mainalbum'])) {
                $details=$details.$_POST['mainalbum'];
                
                if($_POST['magazinealbumsize']=='10x12') {
                    $details=$details.$_POST['magazinealbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[3]->price;
                }
                else {
                    $details=$details.$_POST['magazinealbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[4]->price;
                }
            }
            
            //magazine mini album
            if(isset($_POST['minialbum'])) {
                $details=$details.$_POST['minialbum'].nl2br("\n");
                $price=$price+$packagedetails[5]->price;
            }

            //magazine family album
            if(isset($_POST['familyalbum'])) {
                $details=$details.$_POST['familyalbum'];
                
                if($_POST['familyalbumsize']=='10/20') {
                    $details=$details.$_POST['familyalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[6]->price;
                }
                else {
                    $details=$details.$_POST['familyalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[7]->price;
                }
            }

            //Enlargement with frame
            if(isset($_POST['enlargement'])) {
                $details=$details.$_POST['enlargement'];
                
                if($_POST['enlargementsize']=='8x12') {
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[16]->price*$_POST['enlargementcount'];
                }
                else if($_POST['enlargementsize']=='12x18'){
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[17]->price*$_POST['enlargementcount'];
                }
                else if($_POST['enlargementsize']=='16x24'){
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[18]->price*$_POST['enlargementcount'];
                }
                else{
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[19]->price*$_POST['enlargementcount'];
                }
            }

            // Group photos with Frame
            if(isset($_POST['groupphotoswithframe'])) {
                $details=$details.$_POST['groupphotoswithframe'].nl2br("\n");
                $price=$price+$packagedetails[9]->price*$_POST['framecount'];
            }

            //signature board
            if(isset($_POST['signatureboard'])) {
                $details=$details.$_POST['signatureboard'].nl2br("\n");
                $price=$price+$packagedetails[10]->price;
            }

            //soft copies in dvd
            if(isset($_POST['dvdcopy'])) {
                $details=$details.$_POST['dvdcopy'].nl2br("\n");
                $price=$price+$packagedetails[11]->price;
            }

            //wedding shoot slide show
            if(isset($_POST['weddingslideshow'])) {
                $details=$details.$_POST['weddingslideshow'].nl2br("\n");
                $price=$price+$packagedetails[12]->price;
            }

            //online story book
            if(isset($_POST['onlinestorybook'])) {
                $details=$details.$_POST['onlinestorybook'];
                $price=$price+$packagedetails[13]->price;

                if($_POST['storybook']=='Private ') {
                    $details=$details.$_POST['storybook'].nl2br("\n");
                }
                else {
                    $details=$details.$_POST['storybook'].nl2br("\n");
                }
            }
                      
            $weddingdetails = [
                "details"=>$details,
                "price"=>$price,
                "bookingid"=>$booking_id['bookingid']
                
            ];
            if($this->bookingmodel->addingweddingdetails($weddingdetails)) {
                echo "<script>window.alert('Wedding details updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/view_details_wedding'</script>";
                
                
            }
        }

        $this->view("wedding_update_form");
    }

    public function thankingcardform() {
        $thankingcard_id['thankingcard_id']="";
        $data['thankingcardimage']="";
        $booking_id['bookingid']=$_SESSION['bookingid'];
        $data["weddingdetails"]=$this->bookingmodel->fetchweddingdetails($booking_id);
        $data["thankingcarddetails"]=$this->thankingcardmodel->fetchthankingcarddetails();

        $price=$data['weddingdetails'][0]->price;
        $u=0;
        $newdetails="";//to save thankingcard detail
        
        $packagedetails=$this->packagesmodel->fetchpricedetails();
        
        if($data['weddingdetails'][0]->thankingcard_id!=NULL){
            $thankingcard_id['thankingcard_id']=$data['weddingdetails'][0]->thankingcard_id;
            $data['thankingcardimage']=$this->thankingcardmodel->fetchthankingcarddetailforadmintoupdate($thankingcard_id);
            
        }
        if(isset($_POST['savedetails'])) {
            $newdetails=$newdetails.$_POST['thankingcard'];
                if($_POST['thankingcardsize']=='6x6') {
                    $newdetails=$newdetails.$_POST['thankingcardsize'].nl2br("\n");
                    $u=$packagedetails[14]->price*$_POST['cardcount'];
                    $price=$price+$u;
                }
                else {
                    $newdetails=$newdetails.$_POST['thankingcardsize'].nl2br("\n");
                    $u=$packagedetails[14]->price*$_POST['cardcount'];
                    $price=$price+$u;
                }
                $thankingdetails= [
                    "price"=>$price,
                    "thankingcardid"=>$_POST['thankingcardid'],
                    "thankingcard_price"=>$u,
                    "thankingcard_detail"=>$newdetails,
                    "bookingid"=>$_SESSION['bookingid']
                    
                ];
            if($this->bookingmodel->addingthankingcarddetails($thankingdetails)) {
                echo "<script>window.alert('Thanking card details updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/thankingcardform'</script>";
            }
        }

        if(isset($_POST['remove'])){
            $new_price=$price-$data['weddingdetails'][0]->thankingcard_price;

            $thankingcard_detail=[
                'price'=>$new_price,
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_thankingcard_in_wedding($thankingcard_detail)){
                echo "<script>window.alert('Thanking card removed')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/view_details_wedding'</script>";
            }
        }

        $this->view("thankingcardform_update",$data);
    }

    public function costumeform() {
        $costume_id['costume_id']="";
            $data['costumeimage']="";
            $booking_id['bookingid']=$_SESSION['bookingid'];
            
            $data["weddingdetails"]=$this->bookingmodel->fetchweddingdetails($booking_id);
            $data["costumedetails"]=$this->costumemodel->fetchcostumedetails();
            if($data['weddingdetails'][0]->costume_id!=NULL){
                $costume_id['costume_id']=$data['weddingdetails'][0]->costume_id;
                $data['costumeimage']=$this->costumemodel->fetchcostumedetailforadmintoupdate($costume_id);
            } 
         
        $costumedetails = [
            "bookingid"=>$_SESSION['bookingid']
        ];

        $costume=$this->bookingmodel->fetchweddingdetails($costumedetails);
        $wedding_date['date1']=$costume[0]->datew;
        $wedding_date['date2']=date('Y-m-d', strtotime($costume[0]->datew. ' + 3 days'));
        $booked_costumes=$this->costumemodel->fetch_costume_to_form($wedding_date);

        $data['costumedetails2']="";
        if($booked_costumes){
            $x=count($booked_costumes);
            for($i=0;$i<$x;$i++){
                $data['costumedetails2'][$i]=$booked_costumes[$i]->costume_id;
            }
        }
        
        $price=$costume[0]->price;
            $data["costumedetails"]=$this->costumemodel->fetchcostumedetails();

            if(isset($_POST['savedetails'])) {
                $x=$costume[0]->price+$_POST['price'];
                $costumedetails= [
                    "costumeid"=>$_POST['costumeid'],
                    "price"=>$x,
                    "bookingid"=>$_SESSION['bookingid']
                    
                ];

                if($this->bookingmodel->addingcostumedetails($costumedetails)) {
                    echo "<script>window.alert('Costume details added')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/costumeform'</script>";
                }
            }

            if(isset($_POST['remove'])){
                $costume_id['costume_id']=$data['weddingdetails'][0]->costume_id;
                $data['costumeimage']=$this->costumemodel->fetchcostumedetailforadmintoupdate($costume_id);
                $new_price=$price-$data['costumeimage'][0]->price;
    
                $costume_detail=[
                    'price'=>$new_price,
                    'booking_id'=>$_SESSION['bookingid']
                ];
                if($this->bookingmodel->update_costume_in_wedding($costume_detail)){
                    echo "<script>window.alert('Costume removed')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/view_details_wedding'</script>";
                }
            }


            $this->view("costumeform_update",$data);
    }

    public function engagement_update_form() {
        if(isset($_POST['savedetails'])) { 
            $price=0;
            $details="";
            $packagedetails=$this->packagesmodel->fetchpricedetails();

            //magazine family album
            if(isset($_POST['familyalbum'])) {
                $details=$details.$_POST['familyalbum'];
                
                if($_POST['familyalbumsize']=='10/20') {
                    $details=$details.$_POST['familyalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[6]->price;
                }
                else {
                    $details=$details.$_POST['familyalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[7]->price;
                }
            }

            //Enlargement with frame
            if(isset($_POST['enlargement'])) {
                $details=$details.$_POST['enlargement'];
                
                if($_POST['enlargementsize']=='8x12') {
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[16]->price*$_POST['count'];
                }
                else if($_POST['enlargementsize']=='12x18'){
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[17]->price*$_POST['count'];
                }
                else if($_POST['enlargementsize']=='16x24'){
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[18]->price*$_POST['count'];
                }
                else{
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[19]->price*$_POST['count'];
                }
            }

            //signature board
            if(isset($_POST['signatureboard'])) {
                $details=$details.$_POST['signatureboard'].nl2br("\n");
                $price=$price+$packagedetails[10]->price;
            }

            //magazine mini album
            if(isset($_POST['minialbum'])) {
                $details=$details.$_POST['minialbum'].nl2br("\n");
                $price=$price+$packagedetails[5]->price;
            }

            //Engagement coverage + Couple photo session + Album
            if(isset($_POST['engagementcoverage'])) {
                $details=$details.$_POST['engagementcoverage'];
                
                if($_POST['albumsize']=='8x12') {
                    $details=$details.$_POST['albumsize'].nl2br("\n");
                    $price=$price+$packagedetails[20]->price;
                }
                else if($_POST['albumsize']=='10x12'){
                    $details=$details.$_POST['albumsize'].nl2br("\n");
                    $price=$price+$packagedetails[21]->price;
                }
                else{
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[22]->price;
                }
            }

            $engagementdetails = [
                "details"=>$details,
                "price"=>$price,
                "bookingid"=>$_SESSION['bookingid']
            ];

            if($this->bookingmodel->addingengagementdetails($engagementdetails)) {

                echo "<script>window.alert('Engagement details updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/view_details_engagement'</script>";
                
            }
        }

        $this->view("engagement_update_form");
    
    }

    public function homecoming_update_form() {
        if(isset($_POST['savedetails'])) { 
            $price=0;
            $details="";
            $packagedetails=$this->packagesmodel->fetchpricedetails();

            //magazine main album
            if(isset($_POST['mainalbum'])) {
                $details=$details.$_POST['mainalbum'];
                
                if($_POST['mainalbumsize']=='10x12') {
                    $details=$details.$_POST['mainalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[3]->price;
                }
                else {
                    $details=$details.$_POST['mainalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[4]->price;
                }
            }

            //magazine family album
            if(isset($_POST['familyalbum'])) {
                $details=$details.$_POST['familyalbum'];
                
                if($_POST['familyalbumsize']=='10/20') {
                    $details=$details.$_POST['familyalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[6]->price;
                }
                else {
                    $details=$details.$_POST['familyalbumsize'].nl2br("\n");
                    $price=$price+$packagedetails[7]->price;
                }
            }

            //Enlargement with frame
            if(isset($_POST['enlargement'])) {
                $details=$details.$_POST['enlargement'];
                
                if($_POST['enlargementsize']=='8x12') {
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[16]->price*$_POST['count'];
                }
                else if($_POST['enlargementsize']=='12x18'){
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[17]->price*$_POST['count'];
                }
                else if($_POST['enlargementsize']=='16x24'){
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[18]->price*$_POST['count'];
                }
                else{
                    $details=$details.$_POST['enlargementsize'].nl2br("\n");
                    $price=$price+$packagedetails[19]->price*$_POST['count'];
                }
            }

            // thanking card
            if(isset($_POST['thankingcard'])) {
                $details=$details.$_POST['thankingcard'];
                
                if($_POST['thankingcardsize']=='6x6') {
                    $details=$details.$_POST['thankingcardsize'].nl2br("\n");
                    $price=$price+$packagedetails[14]->price*$_POST['count'];
                }
                else {
                    $details=$details.$_POST['thankingcardsize'].nl2br("\n");
                    $price=$price+$packagedetails[15]->price*$_POST['count'];
                }
            }

            //magazine mini album
            if(isset($_POST['minialbum'])) {
                $details=$details.$_POST['minialbum'].nl2br("\n");
                $price=$price+$packagedetails[5]->price;
            }

            //HomeComing/ Reception Coverage/ Couple photo session
            if(isset($_POST['homecomingcoverage'])) {
                $details=$details.$_POST['homecomingcoverage'];
                
                if($_POST['options']=='HRC') {
                    $details=$details.$_POST['options'].nl2br("\n");
                    $price=$price+$packagedetails[23]->price;
                }
                else if($_POST['options']=='HR'){
                    $details=$details.$_POST['options'].nl2br("\n");
                    $price=$price+$packagedetails[24]->price;
                }
                else {
                    $details=$details.$_POST['options'].nl2br("\n");
                    $price=$price+$packagedetails[25]->price;
                }
            }

            $homecomingdetails = [
                "details"=>$details,
                "price"=>$price,
                "bookingid"=>$_SESSION['bookingid']
            ];

            if($this->bookingmodel->addinghomecomingdetails($homecomingdetails)) {
                echo "<script>window.alert('Homecoming details updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/view_details_homecoming'</script>";
                
            }
        }

        $this->view("homecoming_update_form");

    }

    public function preshoot_update_form(){
            if(isset($_POST['savedetails'])) { 
                $price=0;
                $details="";
                $packagedetails=$this->packagesmodel->fetchpricedetails();

                //Magazine preshoot Album
                if(isset($_POST['preshootalbum'])) {
                    $details=$details.$_POST['preshootalbum'];
                    
                    if($_POST['albumsize']=='8x12') {
                        $details=$details.$_POST['albumsize'].nl2br("\n");
                        $price=$price+$packagedetails[26]->price;
                    }
                    else if($_POST['albumsize']=='10x12'){
                        $details=$details.$_POST['albumsize'].nl2br("\n");
                        $price=$price+$packagedetails[27]->price;
                    }
                    else{
                        $details=$details.$_POST['albumsize'].nl2br("\n");
                        $price=$price+$packagedetails[28]->price;
                    }
                }

                //Animated slide show of preshoot
                if(isset($_POST['slideshow'])) {
                    $details=$details.$_POST['slideshow'].nl2br("\n");
                    $price=$price+$packagedetails[8]->price;
                }

                //Time required
                    if($_POST['time']=='4') {
                        $details=$details.$_POST['time'].nl2br("\n");
                        $price=$price+$packagedetails[29]->price;
                    }
                    else{
                        $details=$details.$_POST['time'].nl2br("\n");
                        $price=$price+$packagedetails[30]->price;
                    }

                $preshootdetails = [
                    "details"=>$details,
                    "price"=>$price,
                    "bookingid"=>$_SESSION['bookingid']
                ];

                if($this->bookingmodel->addingpreshootdetails($preshootdetails)) {
                    echo "<script>window.alert('Pre wedding shoot details updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/view_details_preshoot'</script>";
                    
                }
            }

        $this->view("preshootform_update_form");
        
    }

    
}


