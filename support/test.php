<?php

chdir(__DIR__);

include('../vendor/autoload.php');

$lbb = Support\DI::create('Language\LanguageBatchBo');
die(var_dump($lbb));