<?php
class Booknow extends Controller {
    public function __construct() {
        require "../app/Mailserver/Mail.php";
        $this->customermodel = $this->model('Customer');
        $this->bookingmodel = $this->model('Booking');
        $this->packagesmodel = $this->model('Packages');
        $this->thankingcardmodel = $this->model('Thankingcard');
        $this->costumemodel = $this->model('Costume');
        $this->usermodel = $this->model('User');
    }

    public function errormake(){
        $error=[
            "mainerror"=>""
        ];
        return $error;
    }


    public function index(){
        header('location:'.URLROOT.'/Booknow/newbooking');
    }

    public function bookingid(){
        $id = [
            "id"=>$_SESSION['id']
        ];

        $customerid = $this->customermodel->fetchcustomerid($id);
        $booking = [
            "customerid"=>$customerid[0]->customer_id
        ];
        return $booking;
    }

    public function newbooking() {
        $booked_dates=$this->bookingmodel->fetch_booked_dates();
        if($booked_dates){
            $count=count($booked_dates);
            for($i=0;$i<$count;$i++){
                $_SESSION['dates'][$i]=$booked_dates[$i]->date;
            }
        }
        
        $data=$this->errormake();
        if(isset($_POST['homecoming'])) {
            if(empty($_POST['dateh']) && empty($_POST['timeh']) && empty($_POST['venueh'])){
                $data['mainerror']="Enter the details";
            }
        }

        if(isset($_POST['engagement'])) {
            if(empty($_POST['datee']) && empty($_POST['timee']) && empty($_POST['venuee'])){
                $data['mainerror']="Enter the details";
            }
        }

        if(isset($_POST['preshoot'])) {
            if(empty($_POST['datep']) && empty($_POST['timep']) && empty($_POST['venuep'])){
                $data['mainerror']="Enter the details";
            }
        }

        if(empty($data['mainerror'])) {
            
            if(isset($_POST['savedetails'])) { 
                $booking=$this->bookingid();
                $booking_details=[
                    "customerid"=>$booking['customerid'],
                    "date"=>date("Y-m-d"),
                    "status"=>2
                ];
                if($this->bookingmodel->newbooking($booking_details)) {

                    $bookingid= $this->bookingmodel->fetchbookingid($booking);

                    if(isset($_POST['preshoot'])) {

                        $preshootbooking = [
                            "date"=>$_POST['datep'],
                            "time"=>$_POST['timep'],
                            "venue"=>$_POST['venuep'],
                            "bookingid"=>$bookingid[0]->booking_id
    
                        ];

                        $pre=$this->bookingmodel->newpreshoot($preshootbooking);

                    }

                    if(isset($_POST['homecoming'])) {

                        $homecomingbooking = [
                            "date"=>$_POST['dateh'],
                            "time"=>$_POST['timeh'],
                            "venue"=>$_POST['venueh'],
                            "bookingid"=>$bookingid[0]->booking_id
    
                        ];

                        $home=$this->bookingmodel->newhomecoming($homecomingbooking);
                    }  

                    if(isset($_POST['engagement'])) {

                        $engagementbooking = [
                            "date"=>$_POST['datee'],
                            "time"=>$_POST['timee'],
                            "venue"=>$_POST['venuee'],
                            "bookingid"=>$bookingid[0]->booking_id
    
                        ];

                        $engage=$this->bookingmodel->newengagement($engagementbooking);
                    }

                    $weddingbooking = [
                        "date"=>$_POST['datew'],
                        "time"=>$_POST['timew'],
                        "venue"=>$_POST['venuew'],
                        "bookingid"=>$bookingid[0]->booking_id

                    ];
   
                        if($this->bookingmodel->newwedding($weddingbooking)) {
                            unset($_SESSION['dates']);
                            header('location:'.URLROOT.'/Booknow/weddingform');
                        }
  
                }

            }

        }
    $this->view("booknow",$data);

    }


    public function weddingform() {

        if(isset($_POST['savedetails'])) { 
            $price=0;
            $details="";
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

            $booking=$this->bookingid();
            $booking_id=$this->bookingmodel->fetchbookingid($booking);

            $_SESSION['price']=$price;
            $weddingdetails = [
                "details"=>$details,
                "price"=>$price,
                "bookingid"=>$booking_id[0]->booking_id
                
            ];
            
            if($this->bookingmodel->addingweddingdetails($weddingdetails)) {
                header('location:'.URLROOT.'/Booknow/thankingcardform');
            }
        }

        $this->view("weddingform");
    }


    public function thankingcardform() {
        
        $booking=$this->bookingid();
        $booking_id=$this->bookingmodel->fetchbookingid($booking);
        $fetch_wedding=[
            "bookingid"=>$booking_id[0]->booking_id
        ];
        $details=$this->bookingmodel->fetchweddingdetails($fetch_wedding);
        $data["thankingcarddetails"]=$this->thankingcardmodel->fetchthankingcarddetails();
        $price=$details[0]->price;
        
        $packagedetails=$this->packagesmodel->fetchpricedetails();

        if(isset($_POST['savedetails'])) {
                $u=0;//to store thanking card price
                $newdetails=$newdetails.$_POST['thankingcard'];
                $y=$this->thankingcardmodel->fetchthankingcarddetails();
                $z=$y[0]->thankingcard_id;
                
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
            
                $_SESSION['price']=$_SESSION['price']+$price;

            $thankingdetails= [
                "price"=>$price,
                "thankingcardid"=>$_POST['thankingcardid'],
                "thankingcard_price"=>$u,
                "thankingcard_detail"=>$newdetails,
                "bookingid"=>$booking_id[0]->booking_id
                
            ];
            
            if($this->bookingmodel->addingthankingcarddetails($thankingdetails)) {
                header('location:'.URLROOT.'/Booknow/costumeform');
            }
        }

        $this->view("thankingcardform",$data);
    }

    public function costumeform() {
        
        $booking=$this->bookingid();
        $booking_id=$this->bookingmodel->fetchbookingid($booking);
        $costumedetails = [
            "bookingid"=>$booking_id[0]->booking_id
        ];

        $costume=$this->bookingmodel->fetchweddingdetails($costumedetails);
        
        $price=$costume[0]->price;
        $wedding_date['date1']=$costume[0]->datew;
        $wedding_date['date2']=date('Y-m-d', strtotime($costume[0]->datew. ' + 3 days'));
        $data['costumedetails']=$this->costumemodel->fetchcostumedetails();
        $booked_costumes=$this->costumemodel->fetch_costume_to_form($wedding_date);

        $data['costumedetails2']="";
        if($booked_costumes){
            $x=count($booked_costumes);
            for($i=0;$i<$x;$i++){
                $data['costumedetails2'][$i]=$booked_costumes[$i]->costume_id;
            }
        }


            if(isset($_POST['savedetails'])) {
                $x=$costume[0]->price+$_POST['price'];
                $costumedetails= [
                    "costumeid"=>$_POST['costumeid'],
                    "price"=>$x,
                    "bookingid"=>$booking_id[0]->booking_id
                    
                ];
                $_SESSION['price']=$_SESSION['price']+$x;

                if($this->bookingmodel->addingcostumedetails($costumedetails)) {
                    header('location:'.URLROOT.'/Booknow/preshootform');
                }
            }

            $this->view("costumeform",$data);
    
        
    }

    public function preshootform(){

        $booking=$this->bookingid();
        $booking_id=$this->bookingmodel->fetchbookingid($booking);

        $preshoot = [
            "bookingid"=>$booking_id[0]->booking_id
        ];

        if($this->bookingmodel->fetchpreshootdetails($preshoot)) {  

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
                $_SESSION['price']=$_SESSION['price']+$price;
                $preshootdetails = [
                    "details"=>$details,
                    "price"=>$price,
                    "bookingid"=>$booking_id[0]->booking_id
                ];

                if($this->bookingmodel->addingpreshootdetails($preshootdetails)) {
                    header('location:'.URLROOT.'/Booknow/engagementform');
                    
                }
            }

        $this->view("preshootform");
        }
        else {
            header('location:'.URLROOT.'/Booknow/engagementform');
        }
    }

    public function engagementform() {

        $booking=$this->bookingid();
        $booking_id=$this->bookingmodel->fetchbookingid($booking);

        $engagement = [
            "bookingid"=>$booking_id[0]->booking_id
        ];

        if($this->bookingmodel->fetchengagementdetails($engagement)) {  

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
            $_SESSION['price']=$_SESSION['price']+$price;
            $engagementdetails = [
                "details"=>$details,
                "price"=>$price,
                "bookingid"=>$booking_id[0]->booking_id
            ];

            if($this->bookingmodel->addingengagementdetails($engagementdetails)) {

                header('location:'.URLROOT.'/Booknow/homecomingform');
                
            }
        }

        $this->view("engagementform");
    }

    else {
        header('location:'.URLROOT.'/Booknow/homecomingform');
    }
}

    

    public function homecomingform() {

        $booking=$this->bookingid();
        $booking_id=$this->bookingmodel->fetchbookingid($booking);

        $homecoming = [
            "bookingid"=>$booking_id[0]->booking_id
        ];

        if($this->bookingmodel->fetchhomecomingdetails($homecoming)) {  

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
            $_SESSION['price']=$_SESSION['price']+$price;
            $homecomingdetails = [
                "details"=>$details,
                "price"=>$price,
                "bookingid"=>$booking_id[0]->booking_id
            ];

            if($this->bookingmodel->addinghomecomingdetails($homecomingdetails)) {
                header('location:'.URLROOT.'/Booknow/sendmail');
                
            }
        }

        $this->view("homecomingform");

    }
    
    else {
        header('location:'.URLROOT.'/Booknow/sendmail');
    }

}

public function sendmail(){
    if(isset($_POST['confirm'])){
        $id = [
            "io"=>$_SESSION['id']
        ];
        $customer_details=$this->usermodel->fetchcustomerdetails($id);
        
        $booking=$this->bookingid();
        $booking_id=$this->bookingmodel->fetchbookingid($booking);
        
        $price=[
            'price'=>$_SESSION['price'],
            'balance'=>$_SESSION['price'],
            'status'=>0,
            'booking_id'=>$booking_id[0]->booking_id
        ];
        
        if($this->bookingmodel->total_price($price)){
            $link=URLROOT."/Payment/advancepayment?bookingid=".$booking_id[0]->booking_id."&userid=".$_SESSION['id'];
            $receivermail=$customer_details[0]->email;
            $subject="Advance payment link ";
            $body="<p>Hello ".$customer_details[0]->username."! To confirm the booking you have to pay advance within 5 days, </p>
            <a href=".$link.">Click here to pay advance</a>";
            if(sendMail($receivermail,$subject,$body)){
                echo "<script>window.alert('Advance payment email sent')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking'</script>";
            }
        }
    }
    

    $this->view('booking_confirm_box');
    
    
}
    

    

    
}