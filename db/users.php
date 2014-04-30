<?php if(isset($open) && $open){ $users = array (
  0 => 
  array (
    'username' => 'rootuser',
    'password' => '81dc9bdb52d04dc20036dbd8313ed055',
    'priv' => 'root',
  ),
); }else {echo "Access denied."; header("HTTP/1.1 403 Forbidden"); exit; } ?>