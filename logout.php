<?php

require_once 'init.php';

$auth = new GoogleAuth();

$auth->logout();

header('Location: index.php');