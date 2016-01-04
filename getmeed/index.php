<?php
$ch = curl_init();
$postvars = '';

$url = "https://getmeed.com/majors/degrees";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);               //0 for a get request
curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
$response = curl_exec($ch);
//print "curl response is:" . $response;
curl_close($ch);
$response = json_decode($response);
$majors = $response->majors;
$degrees = $response->degrees;

//echo '<pre>';
//print_r($majors);
//die('aa');
?>
<?php

// login user 
if (isset($_POST['login-btn']) && $_POST['login-btn'] != '') {

  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  $ch = curl_init();
  $fields = array('username' => $username, 'password' => $password);
  $postvars = '';
  foreach ($fields as $key => $value) {
    $postvars .= $key . "=" . $value . "&";
  }
  $url = "http://qa.getmeed.com/login/verify.json";
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $response = curl_exec($ch);
  //print "curl response is:" . $response;
  curl_close($ch);
  $response = json_decode($response);
  if ($response->success) {
    header('Location: http://qa.getmeed.com/');
    exit;
  } else {
    echo "Invalid username and password";
    exit;
  }
}

// Register user
if (isset($_POST['register-btn']) && $_POST['register-btn'] != '') {
  $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
  $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
  $primary_email = isset($_POST['primary_email']) ? $_POST['primary_email'] : '';
  $university_email = isset($_POST['university_email']) ? $_POST['university_email'] : '';
  $year = isset($_POST['year']) ? $_POST['year'] : '';
  $degree = isset($_POST['degree']) ? $_POST['degree'] : '';
  $major = isset($_POST['major']) ? $_POST['major'] : '';
  $phone_field = isset($_POST['phone_field']) ? $_POST['phone_field'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $handle = isset($_POST['handle']) ? $_POST['handle'] : '';

  $ch = curl_init();
  $fields = array('first_name' => $first_name, 'last_name' => $last_name, 'primary_email' => $primary_email, 'university_email' => $university_email, 'degree' => $degree, 'year' => $year, 'major' => $major, 'phone_field' => $phone_field, 'password' => $password, 'handle' => $handle);
  $postvars = '';
  foreach ($fields as $key => $value) {
    $postvars .= $key . "=" . $value . "&";
  }
  $url = "http://qa.getmeed.com/users/account.json";
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $response = curl_exec($ch);
  //print "curl response is:" . $response;
  curl_close($ch);
  $response = json_decode($response);
  //print_r($response);
  //exit;
  if ($response->success) {
    header('Location: http://qa.getmeed.com/');
    exit;
  } else {
    echo $response->error;
    echo "Incorrect data";
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <title>Getmeed</title>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://cdn.jsdelivr.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>
  <script type="text/javascript" src="leanModal-modified-for-onload.js"></script>
  
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
  <link type="text/css" rel="stylesheet" href="style.css" />

  <body>
    <div class="container">
      <a id="modal_trigger" href="#modal" class="btn">Click here to Login or register</a>

      <div id="modal" class="popupContainer" style="display:none;">
        <header class="popupHeader">
          <span class="header_title">Login</span>
          <span class="modal_close"><i class="fa fa-times"></i></span>
        </header>

        <section class="popupBody">

          <!-- Username & Password Login form -->
          <div class="user_login">
            <form method="post" action="" id="userlogin">
              <label>Email / Username</label>
              <input type="text" required="required" placeholder="username"  name="uname" id="uname" class="in-text"/>
              <br />

              <label>Password</label>
             <input type="password" required="required" placeholder="password"  name="password" id="password" class="in-text"/>
              <br />

              <div class="action_btns">
                <div class="one_half"><input type="submit" name="login-btn" href="#" class="btn btn-secondary" value="Login"></div> 
                <div class="one_half_link">&nbsp;&nbsp;OR</div> 
                <div class="one_half last"><span></span> <a href="#" id="register_link" class="btn btn-primary">Register</a></div>
              </div>


            </form>			
          </div>

          <!-- Register Form -->
          <div class="user_register">
            <form method="post" action="" id="user-rgister">
              <label>First Name</label>
              <input required="required" type="text" name="first_name" placeholder="Firstname"/>

              <label>Last Name</label>
              <input required="required" type="text" placeholder="Last Name" name="last_name"/>

              <label>Primary Email</label>
              <input required="required" type="email" name="primary_email" placeholder="Primary Email" />

              <label>University Email</label>
              <input required="required" type="email" name="university_email" placeholder="University Email" />

              <label>Choose Degree</label>
              <select required="required" name="degree">
              <option value="" selected="selected">-- Select an option --</option>
              <?php foreach($degrees as $key=>$value){ ?>
                <option value="<?php print $value;?>"><?php print $value;?></option>  
              <?php }?>
              </select>

              <label>Choose Year of Graduation</label>
              <select required="required" name="year">
              <option value="" selected="selected">-- Select an option --</option>
              <?php 
              $year = 1950;
              for($i = $year;$i <= 2020;$i++){ ?>
                <option value="<?php print $i;?>"><?php print $i;?></option>  
              <?php }?>
              </select>

              <label>Choose Major</label>
              <select required="required" name="major">
              <option value="" selected="selected">-- Select an option --</option>
              <?php foreach($majors as $key=>$value){ ?>
                <option value="<?php print $value->_id;?>"><?php print $value->major;?></option>  
              <?php }?>
              </select>

              <label>Phone Number</label>
              <input required="required" type="text" name="phone_field" placeholder="Phone Number" />

              <label>Password</label>
              <input required="required" type="password" id="password" placeholder="Password" name="password"/>
              <label>Handle</label>
              <input required="required" type="text" name="handle" placeholder="Handle" />


              <br />					

              <div class="action_btns">
                <div class="one_half"><a href="#" id="login_back" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
                <div class="one_half last"><input type="submit" name="register-btn" href="#" class="btn btn-primary" value="Register"></div>
              </div>
            </form>
          </div>
        </section>
      </div>
    </div>

    <script type="text/javascript">
      $("#modal_trigger").leanModal({top: 20, overlay: 0.6, closeButton: ".modal_close"});
		
		  $("#userlogin").validate({
			rules: {
				uname: "required",
				password: "required",
				uname: {
					required: true,
					minlength: 2
				},
				password: {
					required: true,
					minlength: 2
				}
			}
		});
		 $("#user-rgister").validate({
			rules: {
				firstname: "required",
				password: "required",
				
				password: {
					required: true,
					minlength: 2
				},				
				email: {
					required: true,
					email: true
				},
				topic: {
					required: "#newsletter:checked",
					minlength: 2
				},
				agree: "required"
			}
		});

      $(function () {
        // Calling Login Form
        $("#login_back").click(function () {
          $(".user_register").hide();
          $(".social_login").hide();
          $(".user_login").show();
          return false;
        });

        // Calling Register Form
        $("#register_link").click(function () {
          $(".user_login").hide();
          $(".social_login").hide();
          $(".user_register").show();
          $(".header_title").text('Register');
          return false;
        });

        // Going back to Social Forms
        $("#register_btn").click(function () {
          $(".user_login").hide();
          $(".user_register").show();
          $(".header_title").text('Login');
          return false;
        });

      })
    </script>

  </body>
</html>
