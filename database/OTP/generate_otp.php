<?php
function generate_random_int() {
  $num_str = sprintf("%06d", mt_rand(100000, 999999));
  return (int)$num_str;
}

?>