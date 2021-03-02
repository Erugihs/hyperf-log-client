# suntekcorps log client
基于 hyperf/rpc-client 2.0 的客户端代码
```
composer require suntekcorps/log-client
```

## config 
在/config/autoload目录里面创建文件 services.php
添加以下内容
```php
return [
    'consumers' => [
        [
            'name' => 'LogServiceProvider',
            'service' => \STK\Client\Log\Base\LogServiceProviderInterface::class,
            'protocol' => 'jsonrpc',
            'registry' => [
                'protocol' => 'consul',
                'address' => env('CONSUL_URI', 'http://190.168.0.201:8500'),
            ],
            'options' => [
                'connect_timeout' => 5.0,
                'recv_timeout' => 5.0,
                'settings' => [
                    'open_eof_split' => true,
                    'package_eof' => "\r\n",
                    'package_max_length' => 1024 * 1024 * 2,
                ],
            ],
        ]
    ],
];
```

## 使用 
新建类继承 STK\Client\Log\LogClient, 并定义 $table 与 $casts
```php
use STK\Client\Log\LogClient;

class TestModel extends LogClient
{
    //表名
    public $table = 'test_table';
    //字段
    public $casts = [
        '_id' => 'object',
        'test_key_1' => 'string',
        'test_key_2' => 'int',
    ];
}
```