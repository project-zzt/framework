<?php

declare(strict_types=1);

use zzt\Chirp\Chir;

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
  if (count($args) === 0) {
    return;
  }
  Chir::getInstance()->submit($args);
}
