# yii2-seasLog extension

使用SeasLog高效日志扩展替换Yii2框架的日志模块，使其提高写日志效率。只需配置就可以实现。

 SeasLog扩展<https://github.com/SeasX/SeasLog/>

## Requirements

- Yii2
- PHP >=5.4
- ext-seaslog installed

## Installation
```shell
composer require wxxiong6/yii-seaslog
```

## Usage

main.php

```php
    'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'default' => [
                    'logVars' => [],
                    'class' => 'wxxiong6\yii\seaslog\Yii2SeasLog',
                    'levels' => ['trace', 'info', 'error', 'warning'],
                    'logFile' => 'backend/runtime/logs/',
                    'logVars' => [],
                ],
            ],
        ],
```

为了跟yii2日志格式一致,修改php.ini seaslog日志格式

```ini
seaslog.default_template = %T %M
```

## Changelog

##### Release 1.0 - Changelog

- Official stable release
