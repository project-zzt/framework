<?php

const HTTP_100_CONTINUE = 100;
const HTTP_101_SWITCHING_PROTOCOLS = 101;
const HTTP_102_PROCESSING = 102;
const HTTP_103_EARLY_HINTS = 103;
const HTTP_200_OK = 200;
const HTTP_201_CREATED = 201;
const HTTP_202_ACCEPTED = 202;
const HTTP_203_NON_AUTHORITATIVE_INFORMATION = 203;
const HTTP_204_NO_CONTENT = 204;
const HTTP_205_RESET_CONTENT = 205;
const HTTP_206_PARTIAL_CONTENT = 206;
const HTTP_207_MULTI_STATUS = 207;          // RFC4918
const HTTP_208_ALREADY_REPORTED = 208;      // RFC5842
const HTTP_226_IM_USED = 226;

const HTTP_300_MULTIPLE_CHOICES = 300;
const HTTP_301_MOVED_PERMANENTLY = 301;
const HTTP_302_FOUND = 302;
const HTTP_303_SEE_OTHER = 303;
const HTTP_304_NOT_MODIFIED = 304;
const HTTP_305_USE_PROXY = 305;
const HTTP_306_RESERVED = 306;
const HTTP_307_TEMPORARY_REDIRECT = 307;
const HTTP_308_PERMANENTLY_REDIRECT = 308;  // RFC7238

const HTTP_400_BAD_REQUEST = 400;
const HTTP_401_UNAUTHORIZED = 401;
const HTTP_402_PAYMENT_REQUIRED = 402;
const HTTP_403_FORBIDDEN = 403;
const HTTP_404_NOT_FOUND = 404;
const HTTP_405_METHOD_NOT_ALLOWED = 405;
const HTTP_406_NOT_ACCEPTABLE = 406;
const HTTP_407_PROXY_AUTHENTICATION_REQUIRED = 407;
const HTTP_408_REQUEST_TIMEOUT = 408;
const HTTP_409_CONFLICT = 409;
const HTTP_410_GONE = 410;
const HTTP_411_LENGTH_REQUIRED = 411;
const HTTP_412_PRECONDITION_FAILED = 412;
const HTTP_413_REQUEST_ENTITY_TOO_LARGE = 413;
const HTTP_414_REQUEST_URI_TOO_LONG = 414;
const HTTP_415_UNSUPPORTED_MEDIA_TYPE = 415;
const HTTP_416_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
const HTTP_417_EXPECTATION_FAILED = 417;
const HTTP_421_MISDIRECTED_REQUEST = 421;                                         // RFC7540
const HTTP_422_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
const HTTP_423_LOCKED = 423;                                                      // RFC4918
const HTTP_424_FAILED_DEPENDENCY = 424;                                           // RFC4918
const HTTP_425_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
const HTTP_426_UPGRADE_REQUIRED = 426;                                            // RFC2817
const HTTP_428_PRECONDITION_REQUIRED = 428;                                       // RFC6585
const HTTP_429_TOO_MANY_REQUESTS = 429;                                           // RFC6585
const HTTP_431_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
const HTTP_451_UNAVAILABLE_FOR_LEGAL_REASONS = 451;                               // RFC7725

const HTTP_500_INTERNAL_SERVER_ERROR = 500;
const HTTP_501_NOT_IMPLEMENTED = 501;
const HTTP_502_BAD_GATEWAY = 502;
const HTTP_503_SERVICE_UNAVAILABLE = 503;
const HTTP_504_GATEWAY_TIMEOUT = 504;
const HTTP_505_VERSION_NOT_SUPPORTED = 505;
const HTTP_506_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
const HTTP_507_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
const HTTP_508_LOOP_DETECTED = 508;                                               // RFC5842
const HTTP_510_NOT_EXTENDED = 510;                                                // RFC2774
const HTTP_511_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585
