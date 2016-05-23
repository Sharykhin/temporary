<?php

chdir(__DIR__);

include('../vendor/autoload.php');

$languageBatchBo = Support\DI::create('\Language\LanguageBatchBo');
$languageBatchBo->generateLanguageFiles();
$languageBatchBo->generateAppletLanguageXmlFiles();