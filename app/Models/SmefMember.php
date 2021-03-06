<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Model;

class SmefMember extends Model
{
    use ScopeRowStatusTrait;

    protected $guarded = ['id'];
    public $timestamps = false;

    public const ROW_STATUS_ACTIVE = 1;
    public const ROW_STATUS_INACTIVE = 0;

    public const ROW_STATUS_PENDING = 2;
    public const ROW_STATUS_REJECTED = 3;

    public const FORM_FILL_UP_BY_OWN = 1;
    public const FORM_FILL_UP_BY_UDC_ENTREPRENEUR = 2;
    public const FORM_FILL_UP_BY_CHAMBER_OR_ASSOCIATION = 3;
    public const FORM_FILL_UP_BY_SMEF_CLUSTER = 4;

    public const FORM_FILL_UP_LIST = [
        self::FORM_FILL_UP_BY_OWN => "Fill up by Self(আপনার নিজের মাধ্যমে)",
        self::FORM_FILL_UP_BY_UDC_ENTREPRENEUR => "Fill up by UDC",
        self::FORM_FILL_UP_BY_SMEF_CLUSTER => "Fill up by Smef Cluster(এসএমই ক্লাস্টার)",
        self::FORM_FILL_UP_BY_CHAMBER_OR_ASSOCIATION => "Fill up by Chamber or Association (চেম্বার/অ্যাসোসিয়েশন)"
    ];

    public const STATUS_INITIAL_STATE = 0;
    public const STATUS_ACCEPT = 1;
    public const STATUS_REJECTED = 2;


    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHERS = 3;


    public const PROPRIETORSHIP_SOLE_PROPRIETORSHIP = 1;
    public const PROPRIETORSHIP_PARTNERSHIP_PROPRIETORSHIP = 2;
    public const PROPRIETORSHIP_JOIN_PROPRIETORSHIP = 3;

    public const PROPRIETORSHIP_LIST = [
        self::PROPRIETORSHIP_SOLE_PROPRIETORSHIP => 'Sole Proprietorship (একক মালিকানা)',
        self::PROPRIETORSHIP_PARTNERSHIP_PROPRIETORSHIP => 'Partnership Proprietorship (অংশীদারি মালিকানা)',
        self::PROPRIETORSHIP_JOIN_PROPRIETORSHIP => 'Join Proprietorship (যৌথ মালিকানা)',
    ];

    public const TRADE_LICENSING_AUTHORITY_CITY_CORPORATION_KEY = 1;
    public const TRADE_LICENSING_AUTHORITY_MUNICIPALITY = 2;
    public const TRADE_LICENSING_AUTHORITY_UNION_COUNCIL = 3;

    public const TRADE_LICENSING_AUTHORITY = [
        self::TRADE_LICENSING_AUTHORITY_CITY_CORPORATION_KEY => 'City Corporation (সিটি কর্পোরেশন)',
        self::TRADE_LICENSING_AUTHORITY_MUNICIPALITY => 'Municipality (পৌরসভা)',
        self::TRADE_LICENSING_AUTHORITY_UNION_COUNCIL => 'Union Council (ইউনিয়ন পরিষদ)',
    ];
    const OTHER_SECTOR_KEY = "other_sector";
    public const SECTOR = [
        1 => 'পাটজাত',
        2 => 'চামড়া',
        3 => 'হস্তশিল্প',
        4 => 'ফ্যাশন',
        5 => 'হালকা প্রকৌশল',
        6 => 'পোশাক',
        7 => 'ডিজাইন',
        8 => 'কৃষি প্রক্রিয়াজাত',
        9 => 'আইটি',
        10 => 'হারবাল',
        11 => 'প্লাস্তিক',
        12 => 'সিনথেটিকস',
        13 => 'ইলেক্ট্রিক্যাল',
        14 => 'ইলেক্ট্রনিক',
        15 => 'লাইট ইঞ্জিনিয়ারিং',
        16 => 'জুয়েলারি',
        17 => 'হস্তশিল্প (বিভিন্ন প্রকার)',
        18 => 'খাদ্য ও পানীয়',
        self::OTHER_SECTOR_KEY => 'অন্যন্য'
    ];

    public const REGISTERED_AUTHORITY = [
        1 => 'জয়েন্ট-স্টক কোম্পানি',
        2 => 'সমবায় অধিদপ্তর',
        3 => 'এনজিও বিষয়ক ব্যুরো',
        4 => 'সমাজসেবা অধিদপ্তর',
        5 => 'মহিলা বিষয়ক অধিদপ্তর',
        6 => 'যুব উন্নয়ন অধিদপ্তর',
        7 => 'বিটিআরসি',
        8 => 'স্বাস্থ্য অধিদপ্তর',
        9 => 'বাংলাদেশ ক্ষুদ্র ও কুটির শিল্প কর্পোরেশন(বিসিক)',
    ];
    const OTHER_AUTHORITY_KEY = 'other_authority';
    public const AUTHORIZED_AUTHORITY = [
        1 => 'কলকারখানা ও প্রতিষ্ঠান পরিদর্শন অধিদপ্তর',
        2 => 'বাংলাদেশ পরিবেশ অধিদপ্তর',
        3 => 'বাংলাদেশ ফায়ার সার্ভিস ও সিভিল ডিফেন্স অধিদপ্তর',
        4 => 'আমদানি ও রপ্তানি প্রধান নিয়ন্ত্রকের অধিদপ্তর',
        5 => 'ঔষধ প্রশাসন অধিদপ্তর',
        6 => 'বাংলাদেশ এনার্জি রেগুলেটরি কমিশন',
        7 => 'বিস্ফোরক পরিদপ্তর',
        self::OTHER_AUTHORITY_KEY => 'অন্যন্য'
    ];

    public const SPECIALIZED_AREA = [
        1 => 'বাংলাদেশ রপ্তানি প্রক্রিয়াকরণ অঞ্চল (EPZ)',
        2 => 'বাংলাদেশ অর্থনৈতিক অঞ্চল (BEZA)',
        3 => 'বিসিক শিল্প নগরী',
        4 => 'বেসরকারি ইকোনমিক জোন',
    ];

    public const IMPORT_EXPORT_TYPE = [
        1 => 'Direct',
        2 => 'InDirect'
    ];

    public const PERMANENT_WORKER_KEY = 'permanent_worker';
    public const TEMPORARY_WORKER_KEY = 'temporary_worker';
    public const SEASONAL_WORKER_KEY = 'seasonal_worker';
    public const WORKER_TYPE = [
        self::PERMANENT_WORKER_KEY => 'Permanent worker (স্থায়ী কর্মী)',
        self::TEMPORARY_WORKER_KEY => 'Temporary worker (অস্থায়ী কর্মী)',
        self::SEASONAL_WORKER_KEY => 'Seasonal worker (মৌসুমী কর্মী)'
    ];
    public const MANPOWER_TYPE_MALE = 'male';
    public const MANPOWER_TYPE_FEMALE = 'female';
    public const MANPOWER_TYPE = [
        self::MANPOWER_TYPE_MALE,
        self::MANPOWER_TYPE_FEMALE
    ];

    public const BANK_ACCOUNT_PERSONAL = 'personal';
    public const BANK_ACCOUNT_INDUSTRY = 'industry';
    public const BANK_ACCOUNT_TYPE = [
        self::BANK_ACCOUNT_PERSONAL => 'Personal account (ব্যক্তিগত হিসাব)',
        self::BANK_ACCOUNT_INDUSTRY => 'industry accounts (প্রতিষ্ঠানের হিসাব)'
    ];

    public const LAND_TYPE = [
        1 => 'Own Land',
        2 => 'Rent'
    ];

    public const BUSINESS_TYPE = [
        1 => 'ম্যানুফ্যাকচারিং',
        2 => 'সার্ভিস',
        3 => 'ট্রেডিং(দেশ পণ্য/বিদেশী বিদেশী)',
    ];

    public const YES_NO = [
        0 => 'না',
        1 => 'হ্যাঁ',
    ];

    public const APPLICATION_TYPE_NEW = "NEW_APPLICATION";
    public const APPLICATION_TYPE_RENEW = "RENEW_APPLICATION";
    public const APPLICATION_TYPE = [
        self::APPLICATION_TYPE_NEW => "New Application",
        self::APPLICATION_TYPE_RENEW => "Renew Application"
    ];

    public const PAYMENT_GATEWAY_PAGE_URL_PREFIX = "member-registration-payment-method";

    protected $casts = [
        'registered_authority' => 'array',
        'authorized_authority' => 'array',
        'specialized_area' => 'array',
        'salaried_manpower' => 'array',
        'export_type' => 'array',
        'import_type' => 'array',
        'bank_account_type' => 'array',
    ];

}
