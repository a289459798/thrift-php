<?php
/**
 * 文件说明
 * @Author: zhangzy
 * @time: 六  8/23 12:14:14 2014
 *
 **/
namespace ThriftRpc\ThriftController;
require_once PHPTHRIFT . '/ThriftService/User/UserService.php';
require_once PHPTHRIFT . '/ThriftService/User/Types.php';
use ThriftRpc\Cron\Thrift\ThriftClient;
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
