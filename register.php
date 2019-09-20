<?php
   $db = mysqli_connect('127.0.0.1', 'root', '', '#ur db name here');
  session_start();
  if (mysqli_connect_errno()) {
    echo 'Database connection failed with errors: '  .mysqli_connect_error();
    die();

  }

        $name = ((isset($_POST['name']))?sanitize($_POST['name']): '');
        $email = ((isset($_POST['email']))?sanitize($_POST['email']): '');
        $password = ((isset($_POST['password']))?sanitize($_POST['password']): '');
        $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']): '');
        $permissioned = ((isset($_POST['permissioned']))?sanitize($_POST['permissioned']): '');
         $errors = array();

        if (isset($_POST['Register'])) {

            $emailQuery = $db->query("SELECT * FROM visitors WHERE email = '$email' ");
            $emailCount = mysqli_num_rows($emailQuery);
             if ($emailCount != 0 ) {
               $errors[] = 'That email already exist in the database!';
             }

          $required = array('name', 'email', 'password', 'confirm', 'permissioned');
          foreach ($required as $f) {
            if(empty($_POST[$f])){
              ?>
              <script>
                alert('All fields must be filled!');
                window.location = 'register.php';
              </script>
              ?>
              <?php
             // $errors[] = 'All field must be filled';
              //break;
            }
          }

            if(strlen($password) < 6) {
              $errors[] = 'Password must be atleast 6 characters!';
            }
            if ($password != $confirm) {
              $errors[] = 'Password do not match';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) ) {
              $errors[] = 'Invalid Email!';
            }


          if (!empty($errors)) {
            echo display_errors($errors);
          }else{
            //add user to database
            $hashed = password_hash($password,PASSWORD_DEFAULT);
          $insertQuery =  $db->query("INSERT INTO visitors (name, email, password,permissioned) VALUES ('$name', '$email', '$hashed', '$permissioned') ");
           //$_SESSION['success_flash'] = 'User added successfully!';
            //header('Location: users.php');
          }
          if ($insertQuery) {
            ?>
             <script>
               alert('You have successfully Register!');
               window.location = 'visitorlogin.php';
             </script>
             ?>
             <?php
          }else {
          echo  " <script> alert('Error Occured!'); </script>" .mysqli_error($db);

          }
        }

      ?>

      <style type="text/css">
  body{
    background-image:url(./image/bg2.jpg);
    background-repeat:repeat;
    background-size: 100vw 100vh;
    background-attachment: fixed;
      }
      #add-form{
    width: 60%;
    height: 60%;
    background-image:url('./image/bg4.jpg');
    background-attachment: fixed;
    border: 2px solid black;
    border-radius: 15px;
    box-shadow: 7px 7px 15px rgb(0,255,0,0.6);
    margin: 3% auto;
    padding: 15px;
    color: #fff;
    font-weight: bold;
}

    </style>

        <h2 class="text-center text-light" data-aos="fade-up-right"><b>Register</b></h2><hr>
        <form method="post" action="register.php?reg=1" data-aos="fade-down-right">
          <div id="add-form">
            <h3 class="text-center"> New Visitor</h3>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>" placeholder="john Somebody">
          </div>
           <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>" placeholder="john@gmail.com">
          </div>
           <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
          </div>
           <div class="form-group">
            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
          </div>
           <div class="form-group col-md-6">
            <label for="permissioned">Permissions</label>
            <select class="form-control" name="permissioned">
              <option value=""<?=(($permissioned == '')?' selected': '');?>></option>
              <option value="visitor"<?=(($permissioned == 'visitor')?' selected': '');?>>Visitor</option>
              <option value="fpi,visitor"<?=(($permissioned == 'fpi,visitor')?' selected': '');?>>FPI Student/Visitor</option>
              <option value="note">Note: Chose FPI Student/Visitor as permission if u are student of Computer Science ELse Chose Visitor only Thanks.</option>
            </select>
          </div>
          <div class="form-group  text-right">
            <a href="index.php" class="btn btn-primary">Cancel</a>
            <input type="submit" name="Register" id="Register" value="Register" class="btn btn-secondary">
          </div>
        </div>
        </form>






 <?php include 'includes/footer.php'; ?>
