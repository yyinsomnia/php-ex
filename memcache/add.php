<?php
	$memcache = new Memcache;
	$memcache->connect('127.0.0.1', 11211);
	$memcache->set('uid', 3002, 0, 1440);
	
	sleep(10);
	
	$memcache->get('uid');