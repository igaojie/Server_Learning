<?php
	//error_reporting(0);
	$zookeeper = new Zookeeper('127.0.0.1:2181');
	$path = '/path/to/node';

	$aclArray = array(
	  array(
	    'perms'  => Zookeeper::PERM_ALL,
	    'scheme' => 'world',
	    'id'     => 'anyone',
	  )
	);

	$realPath = $zookeeper->create($path, null, $aclArray);

	if ($realPath)
	  echo $realPath;
	else
	  echo 'ERR';

	$r = $zookeeper->delete($path);
	if ($r)
	  echo 'SUCCESS';
	else
	  echo 'ERR';
?>