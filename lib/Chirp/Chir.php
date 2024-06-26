<?php

declare(strict_types=1);

namespace zzt\Chirp;

use ChirpColor;

final class Chirphp
{
	private static ?self $instance;
	private static ?ChirpConfig $config;

	private function __construct()
	{
	}

	public static function getInstance(): self
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function new(?ChirpConfig $config): self
	{
		self::$config = $config;
		return self::getInstance();	
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
	public ?mixed $argument;
	public readonly int $timestamp;

	public function __construct(public ChirpColor $color)
	{
		$this->timestamp = time();
	}
}
