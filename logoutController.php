<?php
// Mulai sesi
session_start();

// Hapus sesi
session_unset();
session_destroy();

header('Location: index.php');
exit;
?>