<?php require_once "app/autoload.php"?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title> Description </title>
</head>

<?php 

//database connection

   

   //value isset
   if(isset($_POST['submit']) ){
   $edit_id = $_GET['edit_id'];
   $photo_id = $_GET['photo_id'];
      //get value

      $name       =$_POST['name'];
      $uname      =$_POST['uname'];
      $email      =$_POST['email'];
      $cell       =$_POST['cell'];
      $age        =$_POST['age'];
      if(isset($_POST['gender']) ){
      $gender     =$_POST['gender'];
      }
      $shift      =$_POST['shift'];
      $location   =$_POST['location'];

      //file upload
      $photo_name='';
      if(empty($_FILES['new_photo']['name'])){

         $photo_name=$_POST['old_photo'];

      }else{

         $file_name=$_FILES['new_photo']['name'];
         $file_tmp_name=$_FILES['new_photo']['tmp_name'];

         $photo_name=md5(time().rand()).$file_name;

         move_uploaded_file($file_tmp_name,'photo/'.$photo_name);
         unlink('photo/'.$photo_id);


      }

      

      if(strlen($cell)== 11){

         $cell_v= true;

      }else{

         $cell_v= false;
      }

      if( empty($name) || empty($uname) || empty($email) || empty($cell) || empty($age) || empty($gender ) || empty($shift ) || empty($location ) ){


          $mess=validate('All fields are require !');

      }else if($cell_v == false){

         $mess=validate('Invalid Cell !','warning');

      }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

         $mess=validate('Invalid Email !','warning');

      }else{

         $sql="UPDATE student SET name='$name' ,uname='$uname',email='$email',cell='$cell',age='$age',gender='$gender',shift='$shift',location='$location',photo='$photo_name' WHERE id='$edit_id' ";
         $conn->query($sql);

         $mess=validate('Data Updated','success');
         header('location:student.php');
    
      }


   }


?>

<?php 


if(isset($_GET['edit_id'])){

   $edit_id = $_GET['edit_id'];

   $sql="SELECT * FROM student WHERE id='$edit_id' ";

   $data=$conn->query($sql);

   $edit_data=$data->fetch_assoc();

}




?>

<body>

 
   <div class="stu shadow" style="width:350px;margin:100px auto 0;">
      <a class="btn btn-primary" href="student.php">Back</a>
         <div class="card">
                 <div class="card-header">
                      <h5 class="card-title">Update student</h5>
                          <?php
                            if(isset($mess)){

                                echo $mess;

                                }
                          ?>
                  </div>
                 <div class="card-body">
                 <form action="" method="POST" enctype="multipart/form-data">
                         <div class="form-group">
                              <label for="">Name</label>
                              <input name="name" value="<?php echo $edit_data['name']; ?>" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                              <label for="">Username</label>
                              <input name="uname" value="<?php echo $edit_data['uname']; ?>" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                              <label for="">Email</label>
                              <input name="email" value="<?php echo $edit_data['email']; ?>" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                              <label for="">Cell</label>
                              <input name="cell" value="<?php echo $edit_data['cell'];?>" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                              <img style="width:120px;" src="./photo/<?php echo $edit_data['photo'];?>" alt="">
                              <input name="old_photo" value="<?php echo $edit_data['photo'];?>" type="hidden">
                        </div>
                        <div class="form-group">
                              <label for="">Photo</label>
                              <input name="new_photo" type="file" class="form-control-file">
                        </div>
                        <div class="form-group">
                              <label for="">Age</label>
                              <input name="age" value="<?php echo $edit_data['age']; ?>" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                              <label for="">Gender</label><br>
                              <input name="gender" <?php if($edit_data['gender']== 'male'){echo 'checked';} ?> type="radio" value="male" id="male"><label for="male">Male</label>
                              <input name="gender" <?php if($edit_data['gender']== 'female'){echo 'checked';} ?> type="radio" value="female" id="female"><label for="female">Female</label>
                        </div>
                        <div class="form-group">
                              <label for="">Shift</label>
                              <select name="shift" class="form-control" id="">
                                 <option value="">-Select-</option>
                                 <option <?php if($edit_data['shift']== 'Day'){echo 'selected';} ?> value="Day">Day</option>
                                 <option <?php if($edit_data['shift']== 'Evening'){echo 'selected';} ?> value="Evening">Evening</option>
                              </select>
                        </div>
                        <div class="form-group">
                              <label for="">Location</label>
                              <select name="location" class="form-control" id="">
                                 <option value="">-Select-</option>
                                 <option <?php if($edit_data['location']== 'Dhaka'){echo 'selected';} ?> value="Dhaka">Dhaka</option>
                                 <option <?php if($edit_data['location']== 'Gazipur'){echo 'selected';} ?> value="Gazipur">Gazipur</option>
                                 <option <?php if($edit_data['location']== 'Cumilla'){echo 'selected';} ?> value="Cumilla">Cumilla</option>
                                 <option <?php if($edit_data['location']== 'Chitagong'){echo 'selected';} ?> value="Chitagong">Chitagong</option>
                                 <option <?php if($edit_data['location']== 'Sylhet'){echo 'selected';} ?> value="Sylhet">Sylhet</option>
                              </select>
                        </div>
                        
                        <div class="form-group">
                        <input name ="submit" type ="submit" class="btn btn-sm btn-primary" value="update">
                        </div>
                     </form>
                 </div>
         </div>
   </div>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>

    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>