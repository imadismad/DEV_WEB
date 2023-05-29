<?php
// Supprimer les cookies
setcookie('user_logged_in', '', time() - 3600, '/');
setcookie('admin', '', time() - 3600, '/');

// Rediriger vers une autre page après la déconnexion
header('Location: index.php');
exit;
?>