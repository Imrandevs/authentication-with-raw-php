<?php require_once "app/autoload.php" ?>

<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8" />
    <title>Scale | Web Application</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
   
</head>

<?php 

//data get

    if(isset($_POST['submit'])){

        $name     = $_POST['name'];
        $uname    = $_POST['uname'];
        $email    = $_POST['email'];
        $cell     = $_POST['cell'];
        $pass     = $_POST['pass'];
        $con_pass = $_POST['con_pass'];
        $status='disagree';
        if(isset($_POST['status'])){
        $status = $_POST['status'] ;
        }

        $hash_pass=password_hash($pass,PASSWORD_DEFAULT);

        $file_name=$_FILES['photo']['name'];
        $file_tmp_name=$_FILES['photo']['tmp_name'];
        $unique_name=md5(time().rand()).$file_name;
        move_uploaded_file($file_tmp_name,'./photo/'.$unique_name);

        //email check
        
        $emailCheck=valueCheck('users','email',$email);

         //username  check
        $unameCheck=valueCheck('users','uname',$uname);

          //cell check
        $cellCheck=valueCheck('users','cell',$cell);


        if(strlen($cell)== 11){

            $cell_v= true;
   
         }else{
   
            $cell_v= false;
         }
   
         if( empty($name) || empty($uname) || empty($email) || empty($cell) || empty( $pass) || empty($status ) ){
   
   
             $mess=validate('All fields are require !');
   
         }else if($cell_v == false){
   
            $mess=validate('Invalid Cell !','warning');
   
         }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
   
            $mess=validate('Invalid Email !','warning');
   
         }else if($pass!=$con_pass){
   
            $mess=validate('Password not match !','warning');
   
         }else if($status == 'disagree'){
   
            $mess=validate('Please agree first !','warning');
   
         }else if($emailCheck > 0){
   
            $mess=validate('Email already exists !','warning');
   
         }else if($cellCheck > 0){
   
            $mess=validate('cell already exists !','warning');
   
         }else if($unameCheck > 0){
   
            $mess=validate('username already exists !','warning');
   
         }else{
   
           insert("INSERT INTO users(name,uname,email,cell,photo,pass,status)values('$name','$uname','$email','$cell','$unique_name','$hash_pass','$status') ");
   
            // $mess=validate('Registration successful','success');
            header('location:login.php');
       
         }
        

    }





?>

<body>
    <section id="content" class="shadow-dark m-t-lg ">
        <div class="container aside-xl">
            <a class="navbar-brand block" href="index.html">Scale</a>
            <section class="m-b-lg">
                <header class="wrapper text-center">
                    <strong>Sign up to find interesting thing</strong>
                    <?php if(isset($mess)){
                        echo $mess;
                    }?>
                </header>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="list-group">
                        <div class="list-group-item">
                            <input name="name" type="text" placeholder="Name" class="form-control">
                        </div>
                        <div class="list-group-item">
                            <input name="uname" type="text" placeholder="Username" class="form-control">
                        </div>
                        <div class="list-group-item">
                            <input name="email" type="text" placeholder="Email" class="form-control">
                        </div>
                        <div class="list-group-item">
                            <input name="cell" type="text" placeholder="Cell" class="form-control">
                        </div>
                        <div class="list-group-item">
                            <label name="photo"  for="im"><img style="width: 60px;" src="assets/images/download.png" alt=""></label>
                            <input name="photo" type="file" id="im" placeholder="Photo" class="hidden">
                        </div>
                        <div class="list-group-item">
                            <input name="pass" type="password" placeholder="Password" class="form-control">
                        </div>
                        <div class="list-group-item">
                            <input name="con_pass" type="password" placeholder="Confirm password" class="form-control">
                        </div>
                    </div>
                    <div class="checkbox m-b">
                        <label>
                             <input name="status" value="agree" type="checkbox"> Agree the 
                             <a href="">terms and policy</a> 
                        </label>
                    </div>
                    <input name="submit" type="submit" class="btn btn-lg btn-primary btn-block" value="Sign up">
                    <div class="line line-dashed">

                    </div>
                    <p class="text-muted text-center">
                        <small>Already have an account?</small>
                    </p>
                    <a href="login.php" class="btn btn-lg btn-default btn-block">Log In</a>
                </form>
            </section>
        </div>
    </section>
    <!-- footer -->
    <footer id="footer">
        
    </footer>
    <br>
    <br>
    <br>
    <br>
    <!-- / footer -->
    <!-- App -->
    <script src="assets/js/app.v1.js"></script>
    <script src="assets/js/app.plugin.js"></script>
</body>

</html>