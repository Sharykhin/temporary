<?php

namespace Language\Support;

use Language\Contracts\GenerateFileContract;
use Language\Contracts\ApiContract;
use Language\Contracts\FileCreatorContract;
use Language\Exceptions\ApiException;
use Language\Exceptions\LanguageException;
use Language\Exceptions\GenerateFileException;
use Language\Contracts\OutPutContract;
use Language\Contracts\ConfigContract;

/**
 * Class LanguageFile
 * @package Support
 */
class LanguagePhpFile implements GenerateFileContract
{
    use DirectoryTrait;
    
    /**
     * Contains the applications which ones require translations.
     *
     * @var array
     */
    protected $applications = array();

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
        // The applications where we need to translate.
        $this->applications = $this->config->get('system.translated_applications');
        $this->outPutService->printText("\nGenerating language files\n");
        foreach ($this->applications as $application => $languages) {
            $this->outPutService->printText("[APPLICATION: " . $application . "]\n");
            foreach ($languages as $language) {
                $this->outPutService->printText("\t[LANGUAGE: " . $language . "]");
                try {
                    $phpContent = $this->getLanguageFile($application, $language);
                    // If we got correct data we store it.
                    $destination = $this->getLanguageCachePath($application) . $language . '.php';

                    $this->createDir($destination);
                    
                    $result = (bool) $this->fileCreator->writeIntoFile($destination, $phpContent);
                    
                    if ($result) {
                        $this->outPutService->printText(" OK\n");
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
        try {
            $result = $this->api->call(
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
        return $this->config->get('system.paths.root') . '/cache/' . $application. '/';
    }
}