<?php
session_start();

// Șterge toate variabilele de sesiune
session_unset();

// Distrugerea sesiunii
session_destroy();

// Redirecționează către pagina de login
header("Location: http://localhost/try/index.html");
exit();
?>
