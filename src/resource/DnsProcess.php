<?php
namespace process;
use Workerman\Connection\TcpConnection;
use app\controller\DnsController;

class DnsProcess
{

    public function onMessage($connection, $data)
    {
        $data=json_decode($data);
        $type=$data->type; #查询类型
        $name=$data->name; #查询内容(一般是域名，PTR时为倒序IP)
        $rip=$connection->getRemoteIp(); #客户端IP
        if(isset($data->addR->csubnet->ip)){
            $ip=$data->addR->csubnet->ip;
        }else{
            $ip=$rip;
        }
        #输出信息
        #echo "\n Type:$type \n Domain: $name\n Client IP: $rip \n";

        $dns=new DnsController;
        $return=$dns->DNS($type,$name,$rip,$ip,$data->id,$data->query,$data->traffic);
        $connection->send($return);
    }

}