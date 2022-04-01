<?php
    
    if(checksession()){
        header('location:'.URLROOT.'/loginpage');
    }?>
    <?php 
    if(checksession()){
        header('location:'.URLROOT.'/loginpage');
    }?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/review.css">
    
    
    <style>
        button {
            background-color: #f2f2f2;
            border: 2px solid #890000;
            color: #890000;
            padding: 10px;
            padding-left: 20px;
            padding-right: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 30px;
            z-index: 1;
            height: 40px;
        }

        button:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }

    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1" >
        <div class="sidenavigation brownbox">
            <?php include 'includes/customersidenav.php' ?>
        </div>

                 <div class="form-box" style="margin-left:120" >
                 <form action="<?php echo URLROOT; ?>/Customerreview/add_review" method="POST">

                       
	<div class="container">
    <label><b>Write a Review</b></label> <br/><br/>
		<div class="rating-wrap">
			<div class="center">
				<fieldset class="rating">
					<input <?php if($data['rating']==5){
                        ?> checked <?php } ?>
                        type="radio" id="star5" name="rating" value="5"/><label for="star5" class="full" title="Awesome"></label>

					<input <?php if($data['rating']==4){
                        ?> checked <?php } ?>
                        type="radio" id="star4" name="rating" value="4"/><label for="star4" class="full"></label>

					<input <?php if($data['rating']==3){
                        ?> checked <?php } ?>
                        type="radio" id="star3" name="rating" value="3"/><label for="star3" class="full"></label>

					<input <?php if($data['rating']==2){
                        ?> checked <?php } ?>
                        type="radio" id="star2" name="rating" value="2"/><label for="star2" class="full"></label>

					<input <?php if($data['rating']==1){
                        ?> checked <?php } ?>
                    type="radio" id="star1" name="rating" value="1"/><label for="star1" class="full"></label>

				</fieldset>
			</div>

			<h4 id="rating-value"></h4>
		</div>
	</div>

                        <textarea  name="review" placeholder="Write a Review" required><?php echo $data['content']; ?></textarea> <br/>
                        <?php 
                        if(empty($data['id'])){ ?>
                            <div style="text-align:center;">
                            <button class="button" type="submit" name="add"> Add </button>
                        </div>
                        <?php } else { ?>
                            <input type="hidden" name="review_id" value="<?php echo $data['id']; ?>">
                            <div style="text-align:center;">
                            <button class="button" type="submit" name="update"> Update </button>
                        </div>
                        <br/>
                        <input type="hidden" name="review_id" value="<?php echo $data['id']; ?>">
                        <div style="text-align:center;">
                            <button class="button" type="submit" name="delete"> Delete </button>
                        </div>
                        <?php } ?>
                        

                        <br><br>

                 </div>
      

    </div>


    <script>
        let star = document.querySelectorAll('input');
        let showValue = document.querySelector('#rating-value');

        for (let i = 0; i < star.length; i++) {
	    star[i].addEventListener('click', function() {
		i = this.value;

		showValue.innerHTML = i + " out of 5";
	});
}
    </script>

<div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>

</body>



</html>
