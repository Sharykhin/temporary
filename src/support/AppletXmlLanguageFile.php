<?php

namespace Language\Support;

use Language\Contracts\GenerateFileContract;
use Language\Contracts\ApiContract;
use Language\Contracts\FileCreatorContract;
use Language\Exceptions\LanguageException;
use Language\Exceptions\ApiException;
use Language\Exceptions\GenerateFileException;
use Language\Config;


/**
 * Class AppletXmlLanguageFile
 * @package Support
 */
class AppletXmlLanguageFile implements GenerateFileContract
{

    /** @var ApiContract $api */
    private static $api;

    /** @var FileCreatorContract  */
    private static $fileCreator;

    /**
     * Contains the applications which ones require translations.
     *
     * @var array
     */
    protected static $applets = array(
        "memberapplet" => "JSM2_MemberApplet",
    );

    /**
     * AppletXmlLanguageFile constructor.
     * @param ApiContract $api
     * @param FileCreatorContract $fileCreator
     */
    public function __construct(ApiContract $api, FileCreatorContract $fileCreator)
    {
        self::$api = $api;
        self::$fileCreator = $fileCreator;
    }

    public function generateFile()
    {
        echo "\nGetting applet language XMLs..\n";

        foreach (self::$applets as $appletDirectory => $appletLanguageId) {
            echo " Getting > $appletLanguageId ($appletDirectory) language xmls..\n";

            try {
                $languages = $this->getAppletLanguages($appletLanguageId);
            } catch (LanguageException $e) {
                throw new GenerateFileException($e->getMessage(), $e->getCode(), $e);
            }

            if (empty($languages)) {
                throw new GenerateFileException("There is no available languages for the " . $appletLanguageId . " applet.");
            }
            else {
                echo " - Available languages: " . implode(", ", $languages) . "\n";
            }
            $path = Config::get("system.paths.root") . "/cache/flash";
            foreach ($languages as $language) {
                $xmlContent = $this->getAppletLanguageFile($appletLanguageId, $language);
                $xmlFile    = $path . "/lang_" . $language . ".xml";
                if (strlen($xmlContent) == self::$fileCreator->writeIntoFile($xmlFile, $xmlContent)) {
                    echo " OK saving " . $xmlFile . " was successful \n";
                }
                else {
                    throw new GenerateFileException("Unable to save applet: ("
                        . $appletLanguageId . ") language: (" . $language
                        . ") xml (" . $xmlFile . ")!");
                }
            }
            echo " < $appletLanguageId ($appletDirectory) language xml cached.\n";
        }

        echo "\nApplet language XMLs generated.\n";
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
            $result = self::$api->call(
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
            $result = self::$api->call(
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
}