<?php

namespace App\Models;

use Carbon\Carbon;
use PHPUnit\Util\Json;

/**
 * Class PaymentTransactionHistory
 * @property int id
 * @property string invoice
 * @property string mer_trnx_id
 * @property string trnx
 * @property int payment_purpose_related_id
 * @property int payment_purpose_code
 * @property int payment_gateway_type
 * @property string customer_identity_code
 * @property string customer_name
 * @property string customer_mobile
 * @property string customer_email
 * @property double amount
 * @property double paid_amount
 * @property string trnx_currency
 * @property json request_payload
 * @property json response_message
 * @property int status
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class PaymentTransactionHistory extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;

    public const CURRENCY_BDT = "BDT";
    /** Payment Status */
    public const PAYMENT_SUCCESS = 1;
    public const PAYMENT_PENDING = 2;
    public const PAYMENT_CANCEL = 3;
    public const PAYMENT_FAIL = 4;

    /** Payment Gateway Type */
    public const EK_PAY_LABEL = "ek_pay";
    public const SSLCOMMERZ_LABEL = "ssl_commerz";
    public const DBBL_MOBILE_BANKING = "dbbl_mobile_banking";
    public const BKASH = "bkash";
    public const PORT_WALLET = "port_wallet";

    public const PAYMENT_GATEWAY_EK_PAY = 1;
    public const PAYMENT_GATEWAY_SSLCOMMERZ = 2;
    public const PAYMENT_GATEWAY_DBBL_MOBILE_BANKING = 3;
    public const PAYMENT_GATEWAY_BKASH = 4;
    public const PAYMENT_GATEWAY_PORT_WALLET = 5;

    public const PAYMENT_GATEWAYS = [
        self::EK_PAY_LABEL => self::PAYMENT_GATEWAY_EK_PAY,
        self::SSLCOMMERZ_LABEL => self::PAYMENT_GATEWAY_SSLCOMMERZ,
        self::DBBL_MOBILE_BANKING => self::PAYMENT_GATEWAY_DBBL_MOBILE_BANKING,
        self::BKASH => self::PAYMENT_GATEWAY_BKASH,
        self::PORT_WALLET => self::PAYMENT_GATEWAY_PORT_WALLET
    ];

    /** Payment purpose code */
    public const PAYMENT_PURPOSE_NASCIB_MEMBER_REGISTRATION = 1;
    public const PAYMENT_PURPOSE_ASCIB_MEMBER_REGISTRATION_LABEL = "Nascib Member Registration";

    public const PAYMENT_PURPOSES = [
        self::PAYMENT_PURPOSE_NASCIB_MEMBER_REGISTRATION => self::PAYMENT_PURPOSE_ASCIB_MEMBER_REGISTRATION_LABEL
    ];

    public const SSL_COMMERZ_SHIPPING_METHOD_NO = 'NO';
    public const SSL_COMMERZ_SHIPPING_METHOD_YES = 'YES';
    public const SSL_COMMERZ_PRODUCT_PROFILE_GENERAL = 'general';
    public const SSL_COMMERZ_PRODUCT_PROFILE_PHYSICAL_GOODS = 'physical-goods';
    public const SSL_COMMERZ_PRODUCT_PROFILE_NON_PHYSICAL_GOODS = 'non-physical-goods';
    public const SSL_COMMERZ_PRODUCT_PROFILE_AIRLINE_TICKETS = 'airline-tickets';
    public const SSL_COMMERZ_PRODUCT_PROFILE_TRAVEL_VERTICAL = 'travel-vertical';
    public const SSL_COMMERZ_PRODUCT_PROFILE_TELECOM_VERTICAL = 'telecom-vertical';
    public const SSL_COMMERZ_INVOICE_SIZE = 36;

    public const PAYMENT_TYPE_COURSE_ENROLLMENT = 1;
    public const TRANSACTION_COMPLETED_SUCCESSFULLY = 1020;
    public const TRANSACTION_COMPLETED_FAIL = 1021;
    public const TRANSACTION_COMPLETED_CANCEL = 1022;

    protected $casts = [
        "request_payload" => 'array',
        "response_message" => "array"
    ];
}
