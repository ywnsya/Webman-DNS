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