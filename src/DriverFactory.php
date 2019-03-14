<?php
	namespace Ako\Shorturl;

    use Ako\Shorturl\Drivers\LocalDriver;

    class DriverFactory
	{
		/**
		 * @param string $driver
		 *
		 * @return LocalDriver
		 */
		public function make (string $driver)
		{
			switch ($driver) {
				case "local":
					return new LocalDriver;
				default:
					return new LocalDriver;
			}
		}
	}