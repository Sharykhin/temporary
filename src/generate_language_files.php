<?php

chdir(__DIR__);

include('../vendor/autoload.php');

$languageBatchBo = Language\Support\DI::create('\Language\LanguageBatchBo');
$languageBatchBo->generateLanguageFiles();
$languageBatchBo->generateAppletLanguageXmlFiles();