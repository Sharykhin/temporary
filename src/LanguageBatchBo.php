<?php

namespace Language;

use Language\Contracts\LanguageFactoryContract;
use Language\Exceptions\GenerateFileException;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	/** @var LanguageFactoryContract  */
	private static $xmlFactory;

	/** @var LanguageFactoryContract  */
	private static $phpFactory;

	/**
	 * LanguageBatchBo constructor.
	 * @param LanguageFactoryContract $phpFactory
	 * @param LanguageFactoryContract $xmlFactory
	 */
	public function __construct(LanguageFactoryContract $phpFactory, LanguageFactoryContract $xmlFactory)
	{
		self::$xmlFactory = $xmlFactory;
		self::$phpFactory = $phpFactory;
	}

	/**
	 * Starts the language file generation.
	 *
	 * @return void
	 */
	public static function generateLanguageFiles()
	{
		$phpLanguageGenerator = self::$phpFactory->create();
		try {
			$phpLanguageGenerator->generateFile();
		} catch (GenerateFileException $e) {
			echo "An error was occurred: " . $e->getMessage();
		}

	}

	/**
	 * Gets the language files for the applet and puts them into the cache.
	 *
	 * @throws \Exception   If there was an error.
	 *
	 * @return void
	 */
	public static function generateAppletLanguageXmlFiles()
	{
		$xmlLanguageGenerator = self::$xmlFactory->create();
		try {
			$xmlLanguageGenerator->generateFile();
		} catch (GenerateFileException $e) {
			throw new \Exception($e->getMessage(), $e->getCode(), $e);
		}
	}	
}
