<?php
	
	$memcache = new Memcache;
	$memcache->connect('127.0.0.1', 11211);
	var_dump($memcache->get('gf1uqu57mnbbkesaejs6mcfrl0'));
	