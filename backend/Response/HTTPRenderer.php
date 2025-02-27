<?php

interface HTTPRenderer
{
  public function getFields(): array;
  public function getContents(): string;
}
