<?php
/**
 * 使用wireshark抓包，每一次请求都是新的tcp链接
 * 本地client port都会递增
 * 这种写法server开启keep alive没有用
 */	
	
for ($i = 0; $i < 100; $i++) {
	file_get_contents("http://m.iautos.cn/");
	sleep(1);
}