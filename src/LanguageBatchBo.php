<?php

namespace Language;

use Contracts\ApiContract;
use Exceptions\ApiException;
use Exceptions\LanguageException;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	/**
	 * Contains the applications which ones require translations.
	 *
	 * @var array
	 */
	protected static $applications = array();

	/** @var ApiContract  */
	private static $api;

	/**
	 * LanguageBatchBo constructor.
	 * @param ApiContract $api
	 */
	public function __construct(ApiContract $api)
	{
		self::$api = $api;
	}

	/**
	 * Starts the language file generation.
	 *
	 * @return void
	 */
	public static function generateLanguageFiles()
	{
		// The applications where we need to translate.
		self::$applications = Config::get('system.translated_applications');

		echo "\nGenerating language files\n";
		foreach (self::$applications as $application => $languages) {
			echo "[APPLICATION: " . $application . "]\n";
			foreach ($languages as $language) {
				echo "\t[LANGUAGE: " . $language . "]";
				try {
					if (self::getLanguageFile($application, $language)) {
						echo " OK\n";
					}
				} catch (LanguageException $e) {
					throw new \Exception('Unable to generate language file!');
				}
			}
		}
	}

	/**
	 * Gets the language file for the given language and stores it.
	 *
	 * @param string $application   The name of the application.
	 * @param string $language      The identifier of the language.
	 *
	 * @throws CurlException   If there was an error during the download of the language file.
	 *
	 * @return bool   The success of the operation.
	 */
	protected static function getLanguageFile($application, $language)
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
			throw new LanguageException('Error during getting language file: (' . $application . '/' . $language . ')');
		}		

		// If we got correct data we store it.
		$destination = self::getLanguageCachePath($application) . $language . '.php';
		// If there is no folder yet, we'll create it.
		var_dump($destination);
		if (!is_dir(dirname($destination))) {
			mkdir(dirname($destination), 0755, true);
		}

		$result = file_put_contents($destination, $languageResponse['data']);

		return (bool)$result;
	}

	/**
	 * Gets the directory of the cached language files.
	 *
	 * @param string $application   The application.
	 *
	 * @return string   The directory of the cached language files.
	 */
	protected static function getLanguageCachePath($application)
	{
		return Config::get('system.paths.root') . '/cache/' . $application. '/';
	}

	/**
	 * Gets the language files for the applet and puts them into the cache.
	 *
	 * @throws Exception   If there was an error.
	 *
	 * @return void
	 */
	public static function generateAppletLanguageXmlFiles()
	{
		// List of the applets [directory => applet_id].
		$applets = array(
			'memberapplet' => 'JSM2_MemberApplet',
		);

		echo "\nGetting applet language XMLs..\n";

		foreach ($applets as $appletDirectory => $appletLanguageId) {
			echo " Getting > $appletLanguageId ($appletDirectory) language xmls..\n";

			try {
				$languages = self::getAppletLanguages($appletLanguageId);
			} catch (LanguageException $e) {
				throw new \Exception($e->getMessage());
			}

			if (empty($languages)) {
				throw new \Exception('There is no available languages for the ' . $appletLanguageId . ' applet.');
			}
			else {
				echo ' - Available languages: ' . implode(', ', $languages) . "\n";
			}
			$path = Config::get('system.paths.root') . '/cache/flash';
			foreach ($languages as $language) {
				$xmlContent = self::getAppletLanguageFile($appletLanguageId, $language);
				$xmlFile    = $path . '/lang_' . $language . '.xml';
				if (strlen($xmlContent) == file_put_contents($xmlFile, $xmlContent)) {
					echo " OK saving $xmlFile was successful.\n";
				}
				else {
					throw new \Exception('Unable to save applet: (' . $appletLanguageId . ') language: (' . $language
						. ') xml (' . $xmlFile . ')!');
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
	protected static function getAppletLanguages($applet)
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
	protected static function getAppletLanguageFile($applet, $language)
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
