<?php

namespace Response\Render;

use Response\HTTPRenderer;

class BinaryRenderer implements HTTPRenderer
{
  private string $content;
  private array $headers;

  public function __construct(string $content, array $headers = [])
  {
    $this->content = $content;
    $this->headers = $headers;
  }

  public function getContent(): string
  {
    return $this->content;
  }

  public function getFields(): array
  {
    return $this->headers;
  }
}
