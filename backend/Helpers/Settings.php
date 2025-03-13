<?php

namespace Helpers;

use Exceptions\ReadAndParseEnvException;

class Settings
{
  const ENV_PATH = '.env';

  /**
   * @throws ReadAndParseEnvException
   */

  function env(string $pair): string
  {
    $config = parse_ini_file(dirname(__FILE__, 2) . '/' . self::ENV_PATH);

    if ($config === false) {
      throw new ReadAndParseEnvException();
    }
    return $config[$pair];
  }
}
