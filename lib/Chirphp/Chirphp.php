<?php

declare(strict_types=1);

namespace zzt\Chirphp;

use ChirpColor;
use Exception;
use zzt\Core\Application;

final class Chirphp
{
	private static ?self $instance = null;
	private static ?ChirpConfig $config = null;

	private function __construct()
	{
		//TODO: Get this working
		exec('./chirper.php', $output, $res);
	}

	public static function getInstance(): self
	{
		if (self::$instance === null) {
			throw new Exception("Chirphp not initialized. Something went wrong on.");
		}

		return self::$instance;
	}

	public static function new(?ChirpConfig $config): self
	{
		if (self::$instance === null) {
			self::$instance = new self();
			self::$config = $config;
		}

		return self::$instance;
	}

	public function submit(array $args): void
	{
		$lastColor = ChirpColor::DEFAULT;
		$output = new Output();

		foreach ($args as $arg) {
			if ($output->argument !== null && $output->color !== null) {
				$output = new Output($lastColor);
			}

			switch (true) {
				case $arg instanceof ChirpColor:
					$output->color = $lastColor = $arg;
					break;
				case is_string($arg):
					$output->argument = $arg;
					break;
			}
		}

		$this->sendOutputs($output);
	}

	private function sendOutputs(Output $output): void
	{
		$log = fopen('/var/www/html/framework/cli/chirp_log.txt', 'a');
		if (!$log) {
			//TODO: Throw file not found exception
		}

		$line = $output->timestamp . ';' . $output->color->name . ';' . $output->argument . "\n";
		fwrite($log, $line);
		fclose($log);
	}
}

class Output
{
	public mixed $argument = null;
	public ?ChirpColor $color = null;
	public readonly int $timestamp;

	public function __construct()
	{
		$this->timestamp = time();
	}
}
