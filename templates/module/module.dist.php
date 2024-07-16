<?php

declare(strict_types=1);

namespace {{APP_NAME}}\{{MODULE_NAME}};

use zzt\globals\router;

// Home route
router\register(router\Type::GET, '/', '/handlers/{{MODULE_NAME}}.php');
