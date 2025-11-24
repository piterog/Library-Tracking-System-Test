<?php

# 1.
$a = [];
$maxTarget = 20;

for ($i=0; $i < 10; $i++) {
    $a[] = mt_rand(1, $maxTarget);
}

# 2.
$f = [];

$f = array_filter($a, function($number) {
    return $number < 10;
});


print_r([$a, $f]);

# 3.
// ...
