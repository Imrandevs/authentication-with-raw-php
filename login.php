<?php require_once "app/autoload.php" ; ?>

<?php 

   if(isset($_SESSION['user_id'])){

      header('location:profile.php');

   }

   if(isset($_COOKIE['log_user'])){

      $u_id=$_COOKIE['log_user'];
      $sql="SELECT * FROM users WHERE id='$u_id' ";
      $data=$conn->query($sql);
      $all_data=$data->fetch_assoc();
      $_SESSION['user_id']=$all_data['id'];
      header('location:profile.php');



   }


?>

<?php 

   if(isset($_POST['submit'])){

      $us_email=$_POST['email_uname'];
      $password=$_POST['password'];

      if(empty($us_email)|| empty($password)){

         $mess=validate('All fields are require !');

      }else{

         $sql="SELECT * FROM users WHERE email='$us_email' OR uname='$us_email' ";
         $all=$conn->query($sql);
         $user=$all->num_rows;
         $sing_user=$all->fetch_assoc();
         if($user == 1){

            if(password_verify($password,$sing_user['pass'])){


               $_SESSION['user_id'] =$sing_user['id'];
               setcookie('log_user',$sing_user['id'],time()+(60*60*24*30*12));
              

               header('location:profile.php');

            }else{

               $mess=validate('password incorrect !');
            }

         }else{
            $mess=validate('Email Or Username incorrect !');
         }
      }
   }




?>

<!DOCTYPE html>
<html lang="en" class=" ">

<head>
    <meta charset="utf-8" />
    <title>Scale | Web Application</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
   
</head>

<body>
      <div class="container" style="margin:200px auto 0;">
         <div class="row">
                           <?php 

                              $log_info='';
                              if(isset($_COOKIE['recent_log_user'])){

                                 $log_info=$_COOKIE['recent_log_user'];

                              }
                              if(!empty($log_info)):
                              $sql="SELECT * FROM users WHERE id IN($log_info) ";
                              $data=$conn->query($sql);

                              while($re_log=$data->fetch_assoc()):


                  ?>
            <div class="col-lg-2">
                     
                  <div class="card shadow-lg" style="box-sizing:border-box;width:120px;border-radius:5px;text-align:center;border:1px solid #909090;">
                     <div class="card-body">
                        <img style="width:100%;" src="./photo/<?php echo $re_log['photo'];?>" alt="">
                        <h4><?php echo $re_log['name'];?></h4>
                     </div>
                  </div>

                  
            </div>
            <?php endwhile;endif;?>
            <div class="col-lg-6" style="margin:-200px auto 0;">
            <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
                        <div class="container aside-xl"> <a class="navbar-brand block" href="index.html">Scale</a>
                              <section class="m-b-lg">
                                 <header class="wrapper text-center"> 
                                    <strong>Sign in to get in touch</strong> 
                                    <?php include "template/message.php" ; ?>
                                 </header>
                                 <form action="" method="POST">
                                    <div class="list-group">
                                          <div class="list-group-item"> 
                                             <input name="email_uname" type="text" placeholder="Email/Username" class="form-control no-border"> 
                                          </div>
                                          <div class="list-group-item"> 
                                             <input name="password" type="password" placeholder="Password" class="form-control no-border"> 
                                          </div>
                                    </div> 
                                    <input name="submit" type="submit" value="Sign in" class="btn btn-lg btn-primary btn-block">

                                    <div class="text-center m-t m-b">
                                       <a href="#"><small>Forgot password?</small></a>
                                    </div>
                                    <div class="line line-dashed"></div>
                                    <p class="text-muted text-center"><small>Do not have an account?</small>
                                    </p> 
                                    <a href="register.php" class="btn btn-lg btn-default btn-block">Register Now</a> </form>
                              </section>
                        </div>
                  </section>
            </div>
         </div>
      </div>
    <!-- footer -->
    <footer id="footer">
       
    </footer>
    <!-- / footer -->
    <!-- App -->
    <script src="assets/js/app.v1.js"></script>
    <script src="assets/js/app.plugin.js"></script>
</body>

</html>