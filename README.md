# 幂等器

## 安装

```
composer require limingxinleo/idempotent
```

## 使用

### Hyperf 框架

以下代码会在 2s 内返回相同的数据

```php
<?php

use Hyperf\Utils\ApplicationContext;
use Idempotent\Idempotent;

$container = ApplicationContext::getContainer();
$id = 'create_order:1';
$result = $container->get(Idempotent::class)->run($id, static function(){
    sleep(2);
    return uniqid();
});

var_dump($result);
```
