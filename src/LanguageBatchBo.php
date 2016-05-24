<?php

namespace Language;

use Contracts\PhpLanguageFactoryContract;
use Contracts\XmlLanguageFactoryContract;
use Exceptions\GenerateFileException;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	/** @var XmlLanguageFactoryContract  */
	private static $xmlFactory;

	/** @var PhpLanguageFactoryContract  */
	private static $phpFactory;

	/**
	 * LanguageBatchBo constructor.
	 * @param PhpLanguageFactoryContract $phpFactory
	 * @param XmlLanguageFactoryContract $xmlFactory
	 */
	public function __construct(PhpLanguageFactoryContract $phpFactory, XmlLanguageFactoryContract $xmlFactory)
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
