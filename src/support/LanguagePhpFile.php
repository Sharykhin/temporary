<?php

namespace Language\Support;

use Language\Contracts\GenerateFileContract;
use Language\Contracts\ApiContract;
use Language\Contracts\FileCreatorContract;
use Language\Exceptions\ApiException;
use Language\Exceptions\LanguageException;
use Language\Exceptions\GenerateFileException;
use Language\Config;

/**
 * Class LanguageFile
 * @package Support
 */
class LanguagePhpFile implements GenerateFileContract
{
    /**
     * Contains the applications which ones require translations.
     *
     * @var array
     */
    protected static $applications = array();

    /** @var ApiContract $api */
    private static $api;
    
    /** @var FileCreatorContract  */
    private static $fileCreator;

    /**
     * LanguageFile constructor.
     * @param ApiContract $api
     */
    public function __construct(ApiContract $api, FileCreatorContract $fileCreator)
    {
        self::$api = $api;
        self::$fileCreator = $fileCreator;
    }

    public function generateFile()
    {
        // The applications where we need to translate.
        self::$applications = Config::get('system.translated_applications');

        echo "\nGenerating language files\n";
        foreach (self::$applications as $application => $languages) {
            echo "[APPLICATION: " . $application . "]\n";
            foreach ($languages as $language) {
                echo "\t[LANGUAGE: " . $language . "]";
                try {
                    $phpContent = $this->getLanguageFile($application, $language);
                    // If we got correct data we store it.
                    $destination = $this->getLanguageCachePath($application) . $language . '.php';
                    // If there is no folder yet, we'll create it.
                    var_dump($destination);
                    if (!is_dir(dirname($destination))) {
                        mkdir(dirname($destination), 0755, true);
                    }
                    
                    $result = (bool) self::$fileCreator->writeIntoFile($destination, $phpContent);
                    
                    if ($result) {
                        echo " OK\n";
                    }
                } catch (LanguageException $e) {
                    throw new GenerateFileException('Unable to generate language file!', $e->getCode(), $e);
                }
            }
        }
    }

    /**
     * @param $application
     * @param $language
     * @return bool
     */
    protected function getLanguageFile($application, $language)
    {
        $result = false;

        try {
            $languageResponse = self::$api->call(
                'system_api',
                'language_api',
                array(
                    'system' => 'LanguageFiles',
                    'action' => 'getLanguageFile'
                ),
                array('language' => $language)
            );
        } catch(ApiException $e) {
            throw new LanguageException(
                'Error during getting language file: (' . $application . '/' . $language . ')',
                $e->getCode(),
                $e);
        }

        return $result['data'];        
    }

    /**
     * Gets the directory of the cached language files.
     *
     * @param string $application   The application.
     *
     * @return string   The directory of the cached language files.
     */
    protected function getLanguageCachePath($application)
    {
        return Config::get('system.paths.root') . '/cache/' . $application. '/';
    }
}