<?php
	//连接
	$zookeeper = new Zookeeper("127.0.0.1:2181,127.0.0.1:2182,127.0.0.1:2183",'globalWatcher',5000);
$zookeeper->get('/redis','redisWatcher');
$zookeeper->get('/rabbit','rabbitWatcher');
function globalWatcher(){
    echo "global watcher\n";
}
function redisWatcher($param1,$param2){
    echo "redis watcher\n";
    $GLOBALS['zookeeper']->get('/redis','redisWatcher');
}
function rabbitWatcher($param1,$param2){
    echo "rabbit watcher\n";
    $GLOBALS['zookeeper']->get('/rabbit','rabbitWatcher');
}

while (true) {
	echo ".";
    echo "\n";
    sleep(2);
}

?>