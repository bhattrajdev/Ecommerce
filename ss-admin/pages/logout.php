<?php

session_destroy();
// unset($_SESSION['email']);
// unset($_SESSION['is_admin']);
header('Location:' . url('ss-admin/'));
