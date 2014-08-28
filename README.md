thrift-php
==========
#QQ群：62893237

php 端的多进程thrift rpc，正在开发中... 

##一、安装thrift
待更新

##二、编写thrift脚本

create file `User.thrift`
```thrift
namespace php ThriftService.User
status User {
	1:i32 id;
	2:string name;
	3:string sex;
	4:i32 age;
}
	
service UserService {
	User getUser(1:i32 UserId),
	bool addUser(User user),
	i32 getUserCount(),
	list<User> getUsers()
}
```

> 
   * bool：布尔值，true 或 false，对应 Java 的 boolean
   * i32：32 位有符号整数，对应 Java 的 int
   * string：utf-8编码的字符串，对应 Java 的 String
   * struct：定义公共的对象，类似于 C 语言中的结构体定义，在 Java 中是一个 JavaBean
   * list：对应 Java 的 ArrayList
   * service：对应服务的类


##三、生成php脚本

```shell
thrift -r -gen php User.thrift
```

##四、使用thrift-php

```php
require_once PHPTHRIFT . '/ThriftService/User/UserService.php';
require_once PHPTHRIFT . '/ThriftService/User/Types.php';
use ThriftRpc\Cron\ThriftForPhp\ThriftClient;
class UserController {
     private $client = null;
     public function __construct() {
         $c = new ThriftClient('localhost', 8090, 20000);
         $this->client = $c->getClient('\\ThriftService\\User\\UserServiceClient', 'nonblock', 'compact');
     }
     public function addUser() {
         $user = new \ThriftService\User\User();
         $user->id = 1;
         $user->name = 'tom';
         $user->age = 18;
         $user->sex = '男';
         echo $this->client->addUser($user);
     }
     public function getUser() {
         $uid = $_GET['uid'];
         print_r($this->client->getUser($uid));
     }
     public function getUserSize() {
         echo $this->client->getUserCount();
     }
     public function getUsers() {
         print_r($this->client->getUsers());
     }
}
```