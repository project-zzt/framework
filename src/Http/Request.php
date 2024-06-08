<?php

declare(strict_types=1);

namespace zzt\Http;

class Request
{
	private function __constructor()
	{
	}

	public static function fromGlobals(): self
	{
		return new self();
	}
}
