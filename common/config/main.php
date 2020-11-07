<?php
return [
    'name' => 'RageFrame',
    'version' => '2.6.57',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-cn',
    'timeZone' => 'Asia/Shanghai',
    'bootstrap' => [
        'queue', // 队列系统
        'common\components\Init', // 加载默认的配置
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . env('DB_HOST') . ';port=' . env('DB_PORT') . ';dbname=' . env('DB_NAME') . '',
            'username' => env('DB_USER'),
            'password' => env('DB_PASS'),
            'charset' => env('DB_CHARSET'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'attributes' => [
                PDO::ATTR_STRINGIFY_FETCHES => false, // 提取的时候将数值转换为字符串
                PDO::ATTR_EMULATE_PREPARES => false, // 启用或禁用预处理语句的模拟
            ],
            // 'enableSchemaCache' => true, // 是否开启缓存, 请了解其中机制在开启，不了解谨慎
            // 'schemaCacheDuration' => 3600, // 缓存时间
            // 'schemaCache' => 'cache', // 缓存名称
            // 断线重连，主要用于 websocket
            // 'commandMap' => [
            //     'mysql' => 'common\replaces\Command'
            // ],
        ],
        /** ------ redis配置 ------ **/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => env('REDIS_HOST'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT'),
            'database' => 0,
        ],
        /** ------ websocket redis配置 ------ **/
        'websocketRedis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => env('REDIS_HOST'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT'),
            'database' => 1,
        ],
        /** ------ 缓存 ------ **/
        'cache' => [
            /**
             * 文件缓存一定要有，不然有可能会导致缓存数据获取失败的情况
             *
             * 注意如果要改成非文件缓存请删除，否则会报错
             */
//            'class' => 'yii\caching\FileCache',
//            'cachePath' => '@backend/runtime/cache'
            'class' => 'yii\redis\Cache',
            'redis' => 'redis',         // 连接组件或它的配置
            'keyPrefix' => 'live_'   // 唯一键前缀
        ],
        // session写入缓存配置
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => 'redis',
        ],
        /** ------ 格式化时间 ------ **/
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('MAIL_HOST'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),  // 密码或客户端授权码
                'port' => env('MAIL_PORT'),
                'encryption' => env('MAIL_ENCRYPTION')
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [env('MAIL_ADMIN') => env('MAIL_ADMIN')]
            ]
        ],
        /** ------ 服务层 ------ **/
        'services' => [
            'class' => 'services\Application',
        ],
        /** ------ 网站碎片管理 ------ **/
        'debris' => [
            'class' => 'common\components\Debris',
        ],
        /** ------ 访问设备信息 ------ **/
        'mobileDetect' => [
            'class' => 'Detection\MobileDetect',
        ],
        /** ------ 队列设置 ------ **/
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'redis' => 'redis', // 连接组件或它的配置
            'channel' => 'queue', // Queue channel key
            'as log' => 'yii\queue\LogBehavior',// 日志
        ],
        /** ------ 公用支付 ------ **/
        'pay' => [
            'class' => 'common\components\Pay',
        ],
        /** ------ 上传组件 ------ **/
        'uploadDrive' => [
            'class' => 'common\components\UploadDrive',
        ],
        /** ------ 快递查询 ------ **/
        'logistics' => [
            'class' => 'common\components\Logistics',
        ],
        /** ------ 二维码 ------ **/
        'qr' => [
            'class' => '\Da\QrCode\Component\QrCodeComponent',
            // ... 您可以在这里配置组件的更多属性
        ],
        /** ------ 微信SDK ------ **/
        'wechat' => [
            'class' => 'common\components\Wechat',
            'userOptions' => [],  // 用户身份类参数
            'sessionParam' => 'wechatUser', // 微信用户信息将存储在会话在这个密钥
            'returnUrlParam' => '_wechatReturnUrl', // returnUrl 存储在会话中
            'rebinds' => [
                'cache' => 'common\components\WechatCache',
            ]
        ],
    ],
];
