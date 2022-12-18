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
        
        if($type=='PTR'){
        $send['detail']='dns.laysense.com';
        $send['ttl']=30;
        $send['type']='PTR';
        }
        if($type=='A'){
            $send['type']='A';
            $send['detail'][1]='119.29.29.29';
            $send['detail'][2]='8.8.8.8';
            $send['ttl']=30;
        };
        if($type=='AAAA'){
            $ipv6=new IPv6;
            $send['type']='AAAA';
            $send['detail'][1]=bin2hex($ipv6->ip2bin("fe80::2c5f")); #此操作可以还原被简化的IPv6地址 协议内不再对IPv6地址进行处理，请按照本方式传递16进制无":"的完整16位IPv6
            $send['detail'][2]=bin2hex($ipv6->ip2bin("2001:0:2851:b9d0:2c5f:f0d9:21be:4b96"));
            $send['ttl']=600;
        }        

        #此处无需修改
        $send['id']=$id;
        $send['query']=$query;
        $return=json_encode($send);
        return $return;
    }
}