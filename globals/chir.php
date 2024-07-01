<?php

declare(strict_types=1);

use zzt\Chirphp\Chirphp;

enum ChirpColor
{
  case BLUE;
  case RED;
  case GREEN;
  case YELLOW;
  case ORANGE;
  case DEFAULT;
}

function chirp(...$args): void
{
  if (! ZZT_DEBUG) return;

  if (count($args) === 0) {
    return;
  }

  Chirphp::getInstance()->submit($args);
}
