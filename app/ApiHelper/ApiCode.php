<?php


namespace App\ApiHelper;


class ApiCode
{



    public const SUCCESS = 200;

    public const CREATED = 201;

    public const SOMETHING_WENT_WRONG = 250;

    public const INVALID_CREDENTIALS = 251; // phone not exists, password not match

    public const USER_INACTIVE = 258; // GLOBAL OR FOR SPECIFIC ACCOUNT

    public const CAN_PROVIDE_PASSWORD = 259; // Phone exists and active


    public const PHONE_CODE_NOT_EXPIRED_YET = 260;

    public const CAN_CHANGE_PASSWORD = 261;


    public const OUT_OF_STOCK = 266;

    public const BRANCH_EXISTS = 267;

    public const REACHED_THE_LIMIT = 268;

    public const SERVICE_EXISTS = 269;

    public const SERVICES_DISABLED = 270;

    public const PRODUCT_EXISTS = 262;

    public const USER_EXISTS = 263;
    public const USER_EXISTS_IN_ACCOUNT = 264;
    public const USER_NOT_EXISTS = 265;

    public const VALIDATION_ERROR = 252;

    public const PHONE_ALREADY_VERIFIED = 253;

    public const INVALID_PHONE_VERIFICATION = 254;


    public const USER_MUST_VERIFY_PHONE_NUMBER = 256;

    public const PHONE_VERIFIED_SUCCESSFUL = 256;

    public const PHONE_CODE_NOT_MATCH = 257;

    public const USER_DEACTIVATED = 258;

    public const DON_NOT_HAVE_PERMISSIONS = 271;
    public const ALREADY_STARTED = 272;
    public const ALREADY_ENDED = 273;
    public const NOT_HAVE_ANY_STARTED_DAY = 274;
    public const YOU_HAVE_PENDING_TRANSACTIONS = 275;
    public const THERE_IS_NO_ACTIVE_BUSINESS_DAY = 276;
    public const INACTIVE_ACCOUNT = 277;
    public const ADDS_ON_EXPIRED = 278;

    public const ADMIN_ACCOUNT = 279;
    public const VERIFY_DEMO = 280;
    public const SERVER_ERROR = 281;
    public const PRODUCT_EXISTS_IN_ACCOUNT = 282;
    public const HYPER_PAY_CANCELED = 283;
    public const TRANSACTION_DUPLICATED = 284;
    public const CATEGORIES_CONTENT_CONFLICT = 285;
    public const INVALID_REFUNDED_QUANTITY = 286;

    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const NOTFOUND = 404;




    public const  INITIATED = "INITIATED";
    public const IN_PROGRESS = "IN_PROGRESS";
    public const ABANDONED = "ABANDONED";
    public const CANCELLED = "CANCELLED";
    public const FAILED = "FAILED";
    public const DECLINED = "DECLINED";
    public const RESTRICTED = "RESTRICTED";
    public const CAPTURED = "CAPTURED";
    public const VOID = "VOID";
    public const TIMEDOUT = "TIMEDOUT";
    public const  UNKNOWN = "UNKNOWN";
}
