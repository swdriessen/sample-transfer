<?php

//files in the public folder reference the core.php in the non-public folder that has all the business logic
require_once $_SERVER['SERVER_NAME'] == 'transfer.swdriessen.nl' ? '../transfer/core.php' : '../core/core.php';