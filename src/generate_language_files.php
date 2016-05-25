<?php

chdir(__DIR__);

include('../vendor/autoload.php');

$languageBatchBo = new Language\LanguageBatchBo(
    Language\Support\DI::create('Language\Support\LanguagePhpFileFactory'),
    Language\Support\DI::create('Language\Support\AppletLanguageXmlFileFactory')
);
$languageBatchBo->generateLanguageFiles();
$languageBatchBo->generateAppletLanguageXmlFiles();