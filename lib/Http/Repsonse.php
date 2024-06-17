<?php

declare(strict_types=1);

namespace zzt\Http;

readonly class Response
{
  private function __construct(
    public array $headers,
    public int $status,
    public string $body,
  ) {
  }

  public static function new(string $body, int $status = 200, array $headers = []): Response
  {
    return new self($headers, $status, $body);
  }

  public function send(): void
  {
    http_response_code($this->status);

    foreach ($this->headers as $name => $value) {
      header("$name: $value");
    }

    echo $this->body;
  }
}