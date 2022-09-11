<?php

$p = new DateTime();
sleep(2);

$pp = new DateTime();

echo $pp->diff($p)->format('%s') / 1000;
