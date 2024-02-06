# Webman DNS

Webman的DNS服务器插件，可以实现Webman启动时运行一个DNS服务器
请不要用于生产环境。

> 注意：默认为udp53端口，需要ROOT权限

[Github](https://github.com/ywnsya/webman-dns)

[LaysenseRepo](https://git.laysense.com/enoch/Webman-Dns)

---

## 支持的DNS类型：

* A
* AAAA
* CNAME
* SOA
* PTR
* MX
* TXT

最新版本已经增加了CNAME+A和CNAME+AAAA方式
0.1.0版本之后，版本号跟随WorkermanDNS,同时支持Flag类型

---

## 安装

在确保已经安装webman后执行

```shell
composer require laysense/dns
```

## 配置

> 配置文件位于 /config/plugin/laysense/dns/process.php

```php
<?php
return [
    'Dns' => [
        'handler' => process\DnsProcess::class,
        'listen'  => 'Dns://0.0.0.0:53',  #使用的端口,53端口需要root权限
        'transport'  => 'udp',
        'count' => cpu_count() * 4        #线程数量
    ],
];
```

## 使用

> 为了方便您的使用，本插件(不要脸地)导入了一个Controller
>
> 位于 /app/controller/DnsController.php
>
> 【如果这影响到了您的项目和您的开发习惯，请修改/process/DnsProcess.php 文件】
>
> 安装前请先保障文件不冲突

> 本DNS插件只提供了一个DNS请求和响应的接口，其余的数据库、DNS查询、多级缓存、递归等需要您自行实现

该Controller名存实亡，其实就是一个class

```php
<?php

namespace app\controller;
include_once base_path().'/vendor/laysense/dns/src/resource/ipv6.php';
use dnstools\ipv6;      #用于IPv6相关
/**
 * $ipv6=new IPv6;
 * $ipv6->ip2bin($ip);
 */

class DnsController
{
    public function DNS($type,$name,$rip,$id,$query)
    {
        #输出信息
        #echo "\n Type:$type \n Domain: $name\n Client IP: $rip \n";


        #此处请根据业务需要，通过判断$name和$rip返回正确的数据
        #详情请参见 https://github.com/ywnsya/workerman-dns 尤其是 https://github.com/ywnsya/Workerman-DNS/blob/master/start.php 中的用法
    
        $send['detail']='dns.laysense.com';
        $send['ttl']=30;
        $send['type']='PTR';


        #此处无需修改
        $send['id']=$id;
        $send['query']=$query;
        $return=json_encode($send);
        return $return;
    }
}
```

具体的使用方式请参照 [Workerman-DNS](https://git.laysense.com/Laysense/Workerman-DNS/src/branch/master/readme.md) ([Github](https://github.com/ywnsya/workerman-dns)) 下的start.php与readme.md


## 赞助(我不要脸)

![1671360565549](image/readme/1671360565549.png)
