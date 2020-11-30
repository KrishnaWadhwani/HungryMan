<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <title>Hungry Signup</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Hungry</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="signup.php">Signup</a>
        </li>

    </div>
  </div>
</nav>



    <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <?php
$username = $_POST['username'];
$password = $_POST['password'];
$useremail = $_POST['useremail'];
$cno = $_POST['cno'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];

if (!empty($username) || !empty($password) || !empty($address) || !empty($useremail) || !empty($pincode)  || !empty($cno)) {
    include 'db_connect.php'; 
    if (mysqli_connect_error()) {
    die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    }

  else{
     $SELECT = "SELECT useremail From logindb Where useremail = ? Limit 1";
     $INSERT = "INSERT INTO logindb (username, useremail, password, cno, pincode, address, income) VALUES (?,?,?,?,?,?,0)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $useremail);
     $stmt->execute();
     $stmt->bind_result($useremail);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0){
      $to = $useremail;
      $subject = "Signup In Hunger";
      $message = "Hello Mr/Mrs $username Thank You For Making Account In Hungry
      Below Are The Information Of Account:
      Username: $username
      Registerd E-Mail: $useremail
      Registerd Pincode: $pincode
      Contact No. Registerd: $cno
      Account Password: $password
      Thank You For Using Hungry
      MR/MRS $username
      ";
      $headers = "From: kwswhwmw@gmail.com";
      mail($to, $subject, $message, $headers);
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssiss", $username, $useremail, $password, $cno, $pincode, $address);
      $stmt->execute();
      header('Location: login.html');
      }else {
        echo '<div class="alert alert-warning" role="alert">
        Someone Alredy Registerd Using This E-Mail ! Sorry For The Inconvinience.
      </div>';
        echo '<div class="alert alert-success" role="alert">
        If This Is Your E-Mail Just Go & Login There 
      </div>';
             echo '<a href = "signup.php"><button class="btn btn-outline-success my-2 my-sm-0">Go Back To Signup</button></a>';
        echo '<a href = "login.html"><button class="btn btn-outline-success my-2 my-sm-0">Go To Login </button></a>';
        echo '<hr>';
     }
     $stmt->close();
     $conn->close();
    
    }}else{
    echo '<div class="alert alert-danger" role="alert">
    Please Fill All The Feilds Of Form!
    </div>';
     echo '<a href = "Login.php"><button class="btn btn-outline-success my-2 my-sm-0">Go Back </button></a>
     <hr>
     
    ';
 die();
}
?>
  </body>
</html>