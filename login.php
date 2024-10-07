<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <?php

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("config_login.php");
    try {
      $conn = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, PASSWORD);
      //echo "Conexion Exitosa";
      $usr = $_POST['username'];
      $pass = $_POST['password'];
      $hashed_pass = hash('sha256', $pass);
      $sql = "select * from users where (username=:usr or email=:usr) and (active='SI') and (password=:hashed_pass)";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':usr', $usr);
      $stmt->bindValue(':hashed_pass', $hashed_pass);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row == 0) {
        //echo " Login Incorrecto";
  ?>
        <div class="alert alert-danger">
          <a href="login.html" class="close" data-dismiss="alert">X</a>
          <div class="text-center">
            <h5><strong>¡Error!</strong> Login Invalido.</h5>
          </div>
        </div>
  <?php
      } 
      else {
        session_start();
        //echo "Login Correcto";
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $_SESSION['time'] = date('H:i:s');
        $_SESSION['username'] = $usr;
        $_SESSION['logueado'] = true;
        header("location:welcome.php");
      }
    } 
    catch (PDOException $e) {
      echo "¡Error!: ";
      die();
    }
  } else {
    exit("Error");
  }
  ?>


</body>

</html>