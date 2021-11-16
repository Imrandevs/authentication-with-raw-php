<?php require_once "app/autoload.php"; ?>

<?php 

    if(isset($_GET['logout']) AND $_GET['logout']== 'ok'  ){

        setcookie('log_user',$_SESSION['user_id'],time()-(60*60*24*30*12));

        if(isset($_COOKIE['recent_log_user'])){

            $recen_val=$_COOKIE['recent_log_user'];
            $re_log=explode(',',$recen_val);

            array_push($re_log,$_SESSION['user_id']);

            $total_log=implode(',',$re_log);

        }else{
            $total_log=$_SESSION['user_id'];
        }

        

        setcookie('recent_log_user',$total_log,time()+(60*60*24*30*12));



        session_destroy();
        header('location:login.php');
}

    if(!isset($_SESSION['user_id'])){

        
        header('location:login.php');
    }

    if(isset($_SESSION['user_id'])){

        $all_data=$_SESSION['user_id'];
        $sql= "SELECT * FROM users WHERE id='$all_data' ";

        $login_data=$conn->query($sql);

        $pro=$login_data->fetch_assoc();

    }

    if(isset($_GET['profile_id'] ) ){

        $profile_id = $_GET['profile_id'];
    
        $sql= "SELECT * FROM users WHERE id='$profile_id' ";
    
        $login_data=$conn->query($sql);
    
        $pro=$login_data->fetch_assoc();
     }


?>




<!DOCTYPE html>
<html lang="en" class="app">


<head>
    <meta charset="utf-8" />
    <title>Scale | <?php echo $pro['name']; ?></title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
   
</head>

<?php 

//data get

    if(isset($_POST['submit'])){

        $profile_id = $_GET['profile_id'];
        $photo_id   = $_GET['photo_id'];


        $name       = $_POST['name'];
        $uname      = $_POST['uname'];
        $email      = $_POST['email'];
        $cell       = $_POST['cell'];

        $photo_name='';
        if(empty($_FILES['new_photo']['name'])){

            $photo_name=$_POST['old_photo'];

        }else{

            $file_name=$_FILES['new_photo']['name'];
            $file_tmp_name=$_FILES['new_photo']['tmp_name'];
            $photo_name=md5(time().rand()).$file_name;
            move_uploaded_file($file_tmp_name,'./photo/'.$photo_name);
            unlink('photo/'.$photo_id);
        }


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
   
         if( empty($name) || empty($uname) || empty($email) || empty($cell) ){
   
   
             $mess=validate('All fields are require !');
   
         }else if($cell_v == false){
   
            $mess=validate('Invalid Cell !','warning');
   
         }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
   
            $mess=validate('Invalid Email !','warning');
   
         }else if($emailCheck > 0){
   
            $mess=validate('Email already exists !','warning');
   
         }else if($cellCheck > 0){
   
            $mess=validate('cell already exists !','warning');
   
         }else if($unameCheck > 0){
   
            $mess=validate('username already exists !','warning');
   
         }else{
   
           $sql="UPDATE users SET name='$name', uname='$uname', email='$email', cell='$cell',  photo='$photo_name' WHERE id = '$profile_id' ";
           $conn->query($sql);
   
            $mess=validate('Updated successful','success');
            header('location:student.php');
            
       
         }
        

    }

?>






<body class="">
    <section class="vbox">
        <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
            <div class="navbar-header aside-md dk">
                <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                    <i class="fa fa-bars"></i>
               </a>
                <a href="index.html" class="navbar-brand">
                    <img src="assets/images/logo.png" class="m-r-sm" alt="scale">
                     <span class="hidden-nav-xs">Scale</span> 
                </a>
                <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
                    <i class="fa fa-cog"></i> 
               </a>
            </div>


            <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-left">
                            <img style="width: 70px;:height: 70px;border-radius: 50%;" src="./photo/<?php echo $pro['photo']; ?>" alt="...">
                        </span> <?php echo $pro['uname']; ?> <b class="caret"></b> 
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
         
                        <li>
                            <a href="student.php">All Student</a> 
                        </li>
                        <li class="divider"></li>
                        <li> <a href="?logout=ok">Logout</a> </li>
                    </ul>
                </li>
            </ul>
        </header>

        <section>

            <section class="hbox stretch">

                <section id="content">
                    <section class="vbox">
                        <section class="scrollable bg-white">
                            <div class="wrapper-lg bg-light">
                                <div class="hbox">
                                    <aside class="aside-md">
                                        <div class="text-center">
                                             <img style="width:170px;height: 170px;:border-radius: :50%;" src="./photo/<?php echo $pro['photo']; ?>" alt="..." class="img-circle m-b">
                                            <div>Profile finished</div>
                                            <div class="">
                                                <div class="progress progress-xs progress-striped active inline m-b-none bg-white" style="width:128px">
                                                    <div class="progress-bar bg-success" data-toggle="tooltip" data-original-title="50%" style="width: 50%"></div>
                                                </div>
                                            </div>
                                            <p>50%</p>
                                        </div>
                                    </aside>
                                    <aside>
                                        <p class="pull-right m-l inline"> 
                                           <a href="#" class="btn btn-sm btn-icon btn-info rounded m-b">
                                             <i class="fa fa-twitter"></i>
                                           </a>
                                            <a href="#" class="btn btn-sm btn-icon btn-primary rounded m-b">
                                               <i class="fa fa-facebook"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-icon btn-danger rounded m-b">
                                               <i class="fa fa-google-plus"></i>
                                            </a>
                                        </p>
                                        <h3 class="font-bold m-b-none m-t-none"><?php echo $pro['name']; ?></h3>
                                        <p><?php echo $pro['email']; ?></p>
                                        <p><i class="fa fa-lg fa-circle-o text-primary m-r-sm"></i>
                                            <strong>Web developer</strong>
                                        </p>
                                        <ul class="nav nav-pills nav-stacked aside-lg">
                                            <li class="bg-light dk">
                                               <a href="#"><i class="i i-phone m-r-sm"></i><?php echo $pro['cell']; ?></a>
                                             </li>
                                            <li class="bg-light dk">
                                               <a href="#"><i class="i i-mail m-r-sm"></i> Send Email</a>
                                             </li>
                                            <li class="bg-light dk">
                                               <a href="#"><i class="i i-chat m-r-sm"></i> Send Message</a>
                                           </li>
                                        </ul>
                                    </aside>
                                </div>
                            </div>



                            <ul class="nav nav-tabs m-b-n-xxs bg-light">
                               
                                <li>
                                    <a href="#edt" data-toggle="">Edit profile</a>
                                </li>
                            </ul>

                              <div id="edt" class="">
                              <div class="tab-pane wrapper-lg" id="edit">
                                    <?php 

                                        if(isset($mess)){
                                            echo $mess;
                                        }
                                    
                                    ?>
                                    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="form-group"> 
                                            <label class="col-sm-3 control-label">Name:</label>
                                            <div class="col-sm-5">
                                                 <input value="<?php echo $pro['name']; ?>" name="name" type="text" class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group"> 
                                            <label class="col-sm-3 control-label">Username:</label>
                                            <div class="col-sm-5">
                                                 <input value="<?php echo $pro['uname']; ?>" name="uname" type="text" class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group"> 
                                            <label class="col-sm-3 control-label" for="input-id-1">Email:</label>
                                            <div class="col-sm-5"> 
                                                <input value="<?php echo $pro['email']; ?>" name="email" type="text" class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group"> 
                                            <label class="col-sm-3 control-label">Phone:</label>
                                            <div class="col-sm-5"> 
                                                <input name="cell" value="<?php echo $pro['cell']; ?>" type="text" class="form-control"> 
                                            </div>
                                        </div>
                                        <div class="form-group">  
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                            <div class="col-sm-5"> 
                                            <label class="col-sm-8 control-label"></label>
                                                <img style="width:100px;" src="./photo/<?php echo $pro['photo']; ?>" alt="">
                                                <input name="old_photo" type="hidden" value="<?php echo $pro['photo']; ?>"> 
                                            </div>
                                        </div>
                                        <div class="line line-dashed b-b line-lg pull-in"></div>
                                        <div class="form-group"> 
                                            <label class="col-sm-3 control-label">Photo:</label>
                                            <div class="col-sm-5"> 
                                            <label name="new_photo"  for="im"><img style="width: 60px;" src="assets/images/download.png" alt=""></label>
                                            <input name="new_photo" type="file" id="im" placeholder="Photo" class="hidden"> 
                                            </div>
                                        </div>
                                                                             
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-5"> 
                                                <input name="submit" value="update" type="submit" class="btn btn-sm btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                              </div>

                            </div>
                        </section>
                    </section>
                    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
                </section>
            </section>
        </section>
    </section>
    <!-- Bootstrap -->
    <!-- App -->
    <script src="assets/js/app.v1.js"></script>
    <script src="assets/js/charts/easypiechart/jquery.easy-pie-chart.js"></script>
    <script src="assets/js/app.plugin.js"></script>
</body>


</html>