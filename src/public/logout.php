<?php require_once 'includes/core.php';

$logger->log('signed off user: '.$_SESSION[SESSION_USER_ID]);

signOut();
redirect('/');