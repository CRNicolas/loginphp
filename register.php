<?php
    require_once "config.php"; 
    require_once "session.php"; 
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

        $fullname = trim($_POST['name']);
        $lastname = trim($_POST['lastname']); 
        $email = trim($_POST['email']); 
        $password = trim($_POST['password']); 
        $confirm_password = trim($_POST["confirm_password"]); 
        $password_hash = password_hash( $password, PASSWORD_BCRYPT);
         
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute([$email]);
        $error = '';
        $success = '';

        if ($query->rowCount() > 0) { 
            $error .= '<p class="error">El correo Electronico ya esta registrado!</p>';
        } else { 
            // validamos la contraseña
            if (strlen($password) < 4) {
                $error .= '<p class="error">La contraseña debe ser mayor a 4 caracteres, </p>'; 
            } 

            // Validate confirm password
            if (empty($confirm_password)) { 
                $error .= '<p class="error">Por favor confirme la contraseña.</p>'; 
            } else { 
                if (empty($error) && ($password != $confirm_password)) { 
                    $error .= '<p class="error">la contraseña no coicide.</p>'; 
                } 
            }

            if (empty($error)) { 
                $insertQuery = $pdo->prepare("INSERT INTO users (name, lastname, email, password) VALUES (?, ?, ?, ?);");
                $result = $insertQuery->execute([$fullname, $lastname, $email, $password_hash]); 
                
                if ($result) { 
                    $success .= '<p class="success">Registro Exitoso!<ip>'; 
                } else { 
                    $error .= '<p class="error">Intentalo de nuevo!</p>'; 
                }
            }
        }
        // cerramos la conexión con la base de datos
        $query = null;
        $insertQuery = null;
        $pdo = null;
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>..: Registro :..</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">

                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Crear una Cuenta Nueva!</h1>
                            </div>
                            <form class="user" action="" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Nombre" require>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="lastname" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Apellidos" require>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Correo Electronico" require>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Contraseña" require>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="confirm_password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Confirmar Contraseña" require>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Registrarme">
                                </div>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Registrar con Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Registrar con Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.php">¿Olvidaste tu Contraseña?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">¿Ya tienes una Cuenta? Iniciar Secion!!!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>