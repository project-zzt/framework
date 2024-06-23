<?php

declare(strict_types=1);

namespace zzt\Http;

class Response
{
	private function __construct(
		public readonly string $body, 
		public readonly int $status, 
		public readonly array $headers,
	)
	{
	}

	public static function new(string $body, array $headers = [], int $status = 200): self
	{
		return new self($body, $status, $headers);
	}
}
