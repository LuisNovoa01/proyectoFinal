<?php

session_start();

require 'utilidades/Session.php';

Session::cerrar();
setcookie('uid', '', time()-5);//esto actualiza la fecha de caducidad a 5 segundos antes
header('Location: index.php');
