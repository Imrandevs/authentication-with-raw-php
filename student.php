<?php require_once "app/autoload.php" ?>

<?php 

 if(isset($_GET['active_id'])){

    $active=$_GET['active_id'];

    $sql="UPDATE users SET status='agree' WHERE id='$active' ";

    $conn->query($sql);
    header('location:student.php');

 }


?>

<?php 

    if(isset($_GET['logout']) AND $_GET['logout']== 'ok'  ){
        session_destroy();
        header('location:login.php');
}

    if(!isset($_SESSION['user_id'])){

        
        header('location:login.php');
    }


?>
<?php 

if(isset($_GET['inactive_id'])){

   $inactive=$_GET['inactive_id'];

   $sql="UPDATE users SET status='disagree' WHERE id='$inactive' ";

   $conn->query($sql);

   header('location:student.php');

}   


?>

   <?php 
   
      if(isset($_GET['delete_id'])){

         $delete_id=$_GET['delete_id'];
         $del_photo=$_GET['del_photo'];

         $sql="DELETE FROM users WHERE id='$delete_id' ";
         $conn->query($sql);

         unlink('photo/'.$del_photo);
         header('location:student.php');

      }
      if(isset($_SESSION['user_id'])){

         $all_data=$_SESSION['user_id'];
         $sql= "SELECT * FROM users WHERE id='$all_data' ";
 
         $login_data=$conn->query($sql);
 
         $pro=$login_data->fetch_assoc();
 
     }
   
   
   
   ?>

<!DOCTYPE html>
<html lang="en" class="app">


<head>
    <meta charset="utf-8" />
    <title>Scale | Web Application</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="assets/fonts/font awesome/css/all.css">
    <link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
   
</head>

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
                            <img src="./photo/<?php echo $pro['photo'];?>" alt=""" alt="...">
                        </span> <?php echo $pro['uname'];?> <b class="caret"></b> 
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
         
                        <li>
                            <a href="docs.html">Help</a> 
                        </li>
                        <li class="divider"></li>
                        <li> <a href="?logout=ok" >Logout</a> </li>
                    </ul>
                </li>
            </ul>
        </header>
        
        <div class="tbl" style="width:900px;margin:100px auto 0;">
                     <div class="card">
                        <div class="card-header">
                           <h5 class="card-title">All Srudent Data</h5>
                        </div>
                        <div class="card-body">
                           <table class="table table-striped text-center">
                              <thead class="text-center">
                                 <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Cell</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                 </tr>
                              </thead>
                              <tbody class="text-center">
                                 <?php 
                                    $sql="SELECT * FROM users";
                                    $all_data=$conn->query($sql);
                                    $i=1;

                                    while( $data=$all_data->fetch_assoc()){
                                 ?>
                                 <tr>
                                    <td><?php echo $i; $i++; ?></td>
                                    <td><?php echo $data['name'];?></td>
                                    <td><?php echo $data['uname'];?></td>
                                    <td><?php echo $data['email'];?></td>
                                    <td><?php echo $data['cell'];?></td>
                                    <td> <img style="width:60px;height:60px;" src="./photo/<?php echo $data['photo'];?>" alt=""> </td>
                                    <td>
                                          <?php if($data['status'] == 'disagree'): ?>

                                          <a class="btn btn-sm btn-success" href="?active_id=<?php echo $data['id']; ?>"><i class="far fa-thumbs-up"></i></a>

                                          <?php elseif($data['status'] == 'agree'):?>

                                          <a class="btn btn-sm btn-danger" href="?inactive_id=<?php echo $data['id']; ?>"><i class="far fa-thumbs-down"></i></a>

                                          <?php endif;?>
                                    </td>
                                    <td>

                                       <?php if($data['id']== $_SESSION['user_id']): ?>
                                          <a class="btn btn-sm btn-primary" href="profile.php?profile_id=<?php echo $data['id']; ?>&photo_id=<?php echo $data['photo']; ?>"><i class="far fa-eye"></i></a>
                                          <!-- <a class="btn btn-sm btn-info" href=""><i class="fas fa-edit"></i></a> -->
                                          <a class="btn btn-sm btn-danger del" href="?delete_id=<?php echo $data['id']; ?>&del_photo=<?php echo $data['photo']; ?>"><i class="fas fa-trash"></i></a>
                                       <?php else :?>
                                          <a class="btn btn-sm btn-primary" href="profile.php?profile_id=<?php echo $data['id']; ?>&photo_id=<?php echo $data['photo']; ?>"><i class="far fa-eye"></i></a>
                                       <?php endif; ?>
                                      
                                    </td>
                                 </tr>
                                 <?php }?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     </div>


    
    </section>
    <!-- Bootstrap -->
    <!-- App -->
    <script src="assets/js/app.v1.js"></script>
    <script src="assets/js/charts/easypiechart/jquery.easy-pie-chart.js"></script>
    <script src="assets/js/app.plugin.js"></script>
    <script src="assets/js/custom.js"></script>
</body>


</html>