<?php

declare(strict_types=1);

namespace zzt\Chirphp;

use ChirpColor;
use Exception;

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

	public function submit(...$args): void
	{
		$outputs = [];
		$lastColor = ChirpColor::DEFAULT;
		$output = new Output($lastColor);

		foreach ($args as $arg) {
			if ($output->argument !== null) {
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
			$outputs[] = $output;
		}

		$this->sendOutputs($outputs);
	}

	private function sendOutputs(array $outputs): void
	{
		//TODO: Send to either console or debug template
	}
}

class Output
{
	public mixed $argument = null;
	public readonly int $timestamp;

	public function __construct(public ChirpColor $color)
	{
		$this->timestamp = time();
	}
}
