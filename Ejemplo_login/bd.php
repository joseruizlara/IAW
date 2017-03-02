<?php

//Constantes necesarias para la conexión de la BD
define('SERVER_DB', '127.0.0.1');
define('USER_DB', 'root');
define('PASS_DB', '');
define('NAME_DB', 'test');

function login($user, $password){
  $db = mysqli_connect(SERVER_DB, USER_DB, PASS_DB, NAME_DB);
  $query = "SELECT * FROM usuario WHERE id = $user";
  $result = mysqli_query($db, $query);
  if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      //Todo correcto
      $return = 0;
    }else{
      //Contraseña no válida
      $result = -1;
    }
  }else{
    //Usuario no válido
    $result = -2;
  }
  mysqli_close($db);

  return $return;
}

function createUser($user, $password, $name, $email){
  $db = mysqli_connect(SERVER_DB, USER_DB, PASS_DB, NAME_DB);
  $result = mysqli_query($db, $query);
  $insert = "INSERT INTO usuarios(id, password, nombre, correo)
  VALUES($user, $passhash, $name, $email)";
  $hashpass = password_hash($password, PASSWORD_DEFAULT);
  $ok = mysqli_query($db, $insert);
  if ($ok) {
    $return = 0;
  }else{
    //Se produjo un eror en la creación del usuario
    $return = -1;
  }
  mysqli_close($db);

  return $return;
}

function checkUserId($user){
  $db = mysqli_connect(SERVER_DB, USER_DB, PASS_DB, NAME_DB);
  $query = "SELECT * FROM usuarios WHERE id = $user";
  $result = mysqli_query($db, $query);
  if($result && mysqli_num_rows($result) == 1){
    //El usuario ya existe
    $result = -1;
  }else{
    //El usuario no existe, todo correcto
    $result = 0;
  }
  mysqli_close($db);

  return $result;
}

function checkEmail($email){
  $db = mysqli_connect(SERVER_DB, USER_DB, PASS_DB, NAME_DB);
  $query = "SELECT * FROM usuarios WHERE correo = $email";
  $result = mysqli_query($db, $query);
  if($result && mysqli_num_rows($result) == 1){
    //El correo ya está registrado
    $result = -1;
  }else{
    //El usuario no existe, todo correcto
    $result = 0;
  }
  mysqli_close($db);

  return $result;
}

?>
