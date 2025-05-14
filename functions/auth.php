<?php
// functions/auth.php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Verificación de acceso para rutas de administrador
if (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
  if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location: ../pages/index.php");
    exit;
  }
}
