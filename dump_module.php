<?php
$f = file_get_contents('resources/views/admin/module.blade.php');
$lines = explode("\n", $f);
foreach ([23,24,25,42] as $idx) {
  $n = $idx; // 0-based? lines array 0-based, file line = idx+1
  if (!isset($lines[$n])) { echo "MISSING $idx\n"; continue; }
  echo "=== LINE ".($n+1)." len=".strlen($lines[$n])." ===\n";
  echo $lines[$n]."\n\n";
}
