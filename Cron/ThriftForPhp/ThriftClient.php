<?php
/**
 * 文件说明
 * @Author: zhangzy
 * @time: 六  8/23 12:04:25 2014
 *
 **/
namespace ThriftRpc\Cron\ThriftForPhp;
use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Protocol\TJsonProtocol;
use Thrift\Protocol\TCompactProtocol;

class ThriftClient {
	private $transport = null;
	private $protocol = null;
	private $host = null;
	private $port = null;
	private $timeout = 3000;
	private $client = null;
	public function __construct($host = 'localhost', $port = 8090, $timeout = 3000) {
		$this->host = $host;
		$this->port = $port;
		$this->timeout = $timeout;
	}

	/**
	 * 设置服务端的传输服务模型
	 */
	private function setTransport($transport = '') {
		if($transport == 'block') {
			$this->setBlockingTransport();
		} else if($transport == 'nonblock'){
			$this->setNonBlockingTransport();
		} else {
			$this->setBlockingTransport();
		}
		return $this;
	}

	/**
	 * 设置阻塞的服务模型
	 */
	private function setBlockingTransport() {
		$this->transport = new TSocket($this->host, $this->port, $this->timeout);
		$this->transport->open();		
	}

	/**
	 * 设置非阻塞服务模型
	 */
	private function setNonBlockingTransport() {
		$this->transport = new TFramedTransport(new TSocket($this->host, $this->port, $this->timeout));
		$this->transport->open();
	}

	/**
	 * 设置数据的传输协议
	 */
	private function setProtocol($protocol = '') {
		if($protocol == 'json') {
			$this->setJsonProtocol();
		} else if($protocol == 'compact') {
			$this->setCompactProtocol();
		} else {
			$this->setBinaryProtocol();
		}
	}

	/**
	 * 设置二进制传输协议
	 */
	private function setBinaryProtocol() {
		$this->protocol = new TBinaryProtocol($this->transport);
	}

	/**
	 * 设置json格式的传输协议
	 */
	private function setJsonProtocol() {
		$this->protocol = new TJsonProtocol($this->transport);
	}

	private function setCompactProtocol() {
		$this->protocol = new TCompactProtocol($this->transport);
	}


	public function getClient($client, $transport = '', $protocol = '') {
		$class = $this->getClass();
		if(empty($this->client[$class][$transport][$protocol])) {
			$this->setTransport($transport);
			$this->setProtocol($protocol);
			$this->client[$class][$protocol][$transport] = new $client($this->protocol, $this->protocol);
		}
		return $this->client[$class][$protocol][$transport];
	}

	private function getClass() {
		return get_class($this);
	}


}
