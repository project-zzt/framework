<?php

declare(strict_types=1);

namespace {{APP_NAME}}\{{MODULE_NAME}};

use zzt\di;
use zzt\globals\output;
use zzt\Http;

// Execute request
return function (Http\Request $request): Http\Response {
	// Template output	
	// $params = ['test' => 'testing'];
  // return output\template('{{MODULE_NAME}}.latte', $params);

	// Json output	
	// return output\json('');
};
