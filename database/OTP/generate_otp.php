<?php
function generate_random_int() {
  $num_str = sprintf("%06d", mt_rand(1, 999999));
  return (int)$num_str;
}
?>
