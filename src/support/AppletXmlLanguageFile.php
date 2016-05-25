<?php

namespace Language\Support;

use Language\Contracts\GenerateFileContract;
use Language\Contracts\ApiContract;
use Language\Contracts\FileCreatorContract;
use Language\Exceptions\LanguageException;
use Language\Exceptions\ApiException;
use Language\Exceptions\GenerateFileException;
use Language\Contracts\OutPutContract;
use Language\Contracts\ConfigContract;


/**
 * Class AppletXmlLanguageFile
 * @package Support
 */
class AppletXmlLanguageFile implements GenerateFileContract
{
    use DirectoryTrait;
    /**
     * Contains the applications which ones require translations.
     *
     * @var array
     */
    protected $applets = array(
        "memberapplet" => "JSM2_MemberApplet",
    );

    /** @var ApiContract $api */
    private $api;

    /** @var FileCreatorContract $fileCreator */
    private $fileCreator;

    /** @var OutPutContract $outPutService */

    private $outPutService;

    /** @var ConfigContract $config */
    private $config;

    /**
     * LanguagePhpFile constructor.
     * @param ApiContract $api
     * @param FileCreatorContract $fileCreator
     * @param OutPutContract $outPutService
     * @param ConfigContract $config
     */
    public function __construct(
        ApiContract $api,
        FileCreatorContract $fileCreator,
        OutPutContract $outPutService,
        ConfigContract $config
    )
    {
        $this->api = $api;
        $this->fileCreator = $fileCreator;
        $this->outPutService = $outPutService;
        $this->config = $config;
    }

    public function generateFile()
    {
        $this->outPutService->printText("\nGetting applet language XMLs..\n");

        foreach ($this->applets as $appletDirectory => $appletLanguageId) {
            $this->outPutService->printText(" Getting > $appletLanguageId ($appletDirectory) language xmls..\n");

            try {
                $languages = $this->getAppletLanguages($appletLanguageId);
            } catch (LanguageException $e) {
                throw new GenerateFileException($e->getMessage(), $e->getCode(), $e);
            }

            if (empty($languages)) {
                throw new GenerateFileException("There is no available languages for the " . $appletLanguageId . " applet.");
            }
            else {
                $this->outPutService->printText(" - Available languages: " . implode(", ", $languages) . "\n");
            }
            $path = $this->getLanguageCachePath();
            $this->createDir($path);
            foreach ($languages as $language) {
                $xmlContent = $this->getAppletLanguageFile($appletLanguageId, $language);
                $xmlFile    = $path . "/lang_" . $language . ".xml";
                if (strlen($xmlContent) == $this->fileCreator->writeIntoFile($xmlFile, $xmlContent)) {
                    $this->outPutService->printText(" OK saving " . $xmlFile . " was successful \n");
                }
                else {
                    throw new GenerateFileException("Unable to save applet: ("
                        . $appletLanguageId . ") language: (" . $language
                        . ") xml (" . $xmlFile . ")!");
                }
            }
            $this->outPutService->printText(" < $appletLanguageId ($appletDirectory) language xml cached.\n");
        }

        $this->outPutService->printText("\nApplet language XMLs generated.\n");
    }


    /**
     * Gets the available languages for the given applet.
     *
     * @param string $applet   The applet identifier.
     *
     * @return array   The list of the available applet languages.
     */
    protected function getAppletLanguages($applet)
    {
        try {
            $result = $this->api->call(
                'system_api',
                'language_api',
                array(
                    'system' => 'LanguageFiles',
                    'action' => 'getAppletLanguages'
                ),
                array('applet' => $applet)
            );
        } catch (ApiException $e) {
            throw new LanguageException('Getting languages for applet (' . $applet . ') was unsuccessful ' . $e->getMessage());
        }

        return $result['data'];
    }


    /**
     * Gets a language xml for an applet.
     *
     * @param string $applet      The identifier of the applet.
     * @param string $language    The language identifier.
     *
     * @return string|false   The content of the language file or false if weren't able to get it.
     */
    protected function getAppletLanguageFile($applet, $language)
    {
        try {
            $result = $this->api->call(
                'system_api',
                'language_api',
                array(
                    'system' => 'LanguageFiles',
                    'action' => 'getAppletLanguageFile'
                ),
                array(
                    'applet' => $applet,
                    'language' => $language
                )
            );
        } catch (ApiException $e) {
            throw new LanguageException('Getting language xml for applet: (' . $applet . ') on language: ('
                . $language . ') was unsuccessful: ' . $e->getMessage());
        }

        return $result['data'];
    }

    protected function getLanguageCachePath()
    {
        return $this->config->get("system.paths.root") . "/cache/flash";
    }
}