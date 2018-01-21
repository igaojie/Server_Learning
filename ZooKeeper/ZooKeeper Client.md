# ZooKeeper Client
## zkcli
### zkcli -timeout 0 -r -server ip:port
```
ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper> zkcli
Connecting to localhost:2181
Welcome to ZooKeeper!
JLine support is enabled

WATCHER::

WatchedEvent state:SyncConnected type:None path:null
[zk: localhost:2181(CONNECTED) 0]
[zk: localhost:2181(CONNECTED) 0]
[zk: localhost:2181(CONNECTED) 0]

> zkcli -timeout 0 -r -server 127.0.0.1:2181
Connecting to 127.0.0.1:2181
Welcome to ZooKeeper!
JLine support is enabled
[zk: 127.0.0.1:2181(CONNECTING) 0]

```

### 命令
#### 查询指令 ls ls2 get stat 
```
ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper> zkcli -timeout 5000  -server 127.0.0.1:2181
Connecting to 127.0.0.1:2181
Welcome to ZooKeeper!
JLine support is enabled

WATCHER::

WatchedEvent state:SyncConnected type:None path:null

//连接成功 CONNECTED 输入 h查看有哪些命令？
[zk: 127.0.0.1:2181(CONNECTED) 0] h
ZooKeeper -server host:port cmd args
	stat path [watch]
	set path data [version]
	ls path [watch]
	delquota [-n|-b] path
	ls2 path [watch]
	setAcl path acl
	setquota -n|-b val path
	history
	redo cmdno
	printwatches on|off
	delete path [version]
	sync path
	listquota path
	rmr path
	get path [watch]
	create [-s] [-e] path data acl
	addauth scheme auth
	quit
	getAcl path
	close
	connect host:port
[zk: 127.0.0.1:2181(CONNECTED) 1] ls

// ls 列出path 下的节点信息
[zk: 127.0.0.1:2181(CONNECTED) 2] ls /
[zookeeper]
[zk: 127.0.0.1:2181(CONNECTED) 3] ls /zookeeper
[quota]
[zk: 127.0.0.1:2181(CONNECTED) 4] ls /zookeeper/quota
[]

//查询某个节点的状态信息
[zk: 127.0.0.1:2181(CONNECTED) 5] stat /zookeeper
cZxid = 0x0 //事务ID 该节点被创建时的事务ID 是被哪个事务创建的。
ctime = Thu Jan 01 08:00:00 CST 1970 //事务创建的时间
mZxid = 0x0 //更新时的事务ID
mtime = Thu Jan 01 08:00:00 CST 1970 //更新时间
pZxid = 0x0 //该节点的子节点列表最后一次被修改的事务ID（为该节点创建子节点时和从该节点删除某节点时会触发子节点列表发生改变，数据内容改变不计算在内）
cversion = -1   //子节点版本号
dataVersion = 0 //数据版本号
aclVersion = 0 //acl版本号
ephemeralOwner = 0x0 //创建该临时节点的事务ID 如果是持久节点，这个地方为0
dataLength = 0  //当前节点所存放的数据长度
numChildren = 1 //当前节点含有的子节点的个数
[zk: 127.0.0.1:2181(CONNECTED) 6]


//向节点写数据
[zk: 127.0.0.1:2181(CONNECTED) 7] set /zookeeper 123
cZxid = 0x0
ctime = Thu Jan 01 08:00:00 CST 1970
mZxid = 0x100000006
mtime = Sat Jan 20 17:29:09 CST 2018
pZxid = 0x0
cversion = -1
dataVersion = 1
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 3
numChildren = 1

//从节点获取数据
[zk: 127.0.0.1:2181(CONNECTED) 8] get /zookeeper
123
cZxid = 0x0
ctime = Thu Jan 01 08:00:00 CST 1970
mZxid = 0x100000006
mtime = Sat Jan 20 17:29:09 CST 2018
pZxid = 0x0
cversion = -1
dataVersion = 1
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 3
numChildren = 1
[zk: 127.0.0.1:2181(CONNECTED) 9]


// ls2 既能列出节点下所有子节点 也能列出stats的状态信息
[zk: 127.0.0.1:2181(CONNECTED) 10] ls2 /zookeeper
[quota]
cZxid = 0x0
ctime = Thu Jan 01 08:00:00 CST 1970
mZxid = 0x100000006
mtime = Sat Jan 20 17:29:09 CST 2018
pZxid = 0x0
cversion = -1
dataVersion = 1
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 3
numChildren = 1
[zk: 127.0.0.1:2181(CONNECTED) 11]


```

#### 创建指令 create

```
create [-s] [-e] path data acl

create
 [-s] 当前创建的节点为顺序节点
 [-e] 当前创建的节点为临时节点
 path 创建节点的完整武警
 data 数据
 acl 权限

```
```
[zk: 127.0.0.1:2181(CONNECTED) 20] create /node_1 node_1_1_content
Created /node_1
[zk: 127.0.0.1:2181(CONNECTED) 21] get /node_1
node_1_1_content
cZxid = 0x10000000a
ctime = Sat Jan 20 17:37:13 CST 2018
mZxid = 0x10000000a
mtime = Sat Jan 20 17:37:13 CST 2018
pZxid = 0x10000000a
cversion = 0
dataVersion = 0
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 16
numChildren = 0
[zk: 127.0.0.1:2181(CONNECTED) 22] create /node_1/node_1_1 node_1_1_content
Created /node_1/node_1_1
[zk: 127.0.0.1:2181(CONNECTED) 23] ls2 /node_1
[node_1_1]
cZxid = 0x10000000a
ctime = Sat Jan 20 17:37:13 CST 2018
mZxid = 0x10000000a
mtime = Sat Jan 20 17:37:13 CST 2018
pZxid = 0x10000000b
cversion = 1
dataVersion = 0
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 16
numChildren = 1
[zk: 127.0.0.1:2181(CONNECTED) 24] create /node_1/node_1_2 node_1_2_content
Created /node_1/node_1_2
[zk: 127.0.0.1:2181(CONNECTED) 25] ls2 /node_1
[node_1_1, node_1_2]
cZxid = 0x10000000a
ctime = Sat Jan 20 17:37:13 CST 2018
mZxid = 0x10000000a
mtime = Sat Jan 20 17:37:13 CST 2018
pZxid = 0x10000000c
cversion = 2
dataVersion = 0
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 16
numChildren = 2
[zk: 127.0.0.1:2181(CONNECTED) 26]



```
##### 如果创建的节点是临时节点 -e参数 那么会话结束以后，临时节点会自动被删除掉。
```

// -e 参数 创建临时节点
[zk: 127.0.0.1:2181(CONNECTED) 26] create /node_3 node_3_content -e
-e does not have the form scheme:id:perm
Acl is not valid : null--- -e写后边会被系统认为是写权限 所以报错。
[zk: 127.0.0.1:2181(CONNECTED) 27] create -e /node_3 node_3_content
Created /node_3
[zk: 127.0.0.1:2181(CONNECTED) 28] ls2 /node_

node_1   node_3
[zk: 127.0.0.1:2181(CONNECTED) 28] ls2 /node_3
[]
cZxid = 0x10000000d
ctime = Sat Jan 20 17:44:02 CST 2018
mZxid = 0x10000000d
mtime = Sat Jan 20 17:44:02 CST 2018
pZxid = 0x10000000d
cversion = 0
dataVersion = 0
aclVersion = 0
ephemeralOwner = 0x16112b828490002
dataLength = 14
numChildren = 0

// 如果给临时节点写子节点，则会被提示 临时节点不能有子节点
[zk: 127.0.0.1:2181(CONNECTED) 29] create -e /node_3/node_3_1 123
Ephemerals cannot have children: /node_3/node_3_1

现在退出来 断开连接。再回来看看
[zk: 127.0.0.1:2181(CONNECTED) 30] quit
Quitting...

//重新连接
ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper> zkcli -timeout 5000  -server 127.0.0.1:2181
Connecting to 127.0.0.1:2181
Welcome to ZooKeeper!
JLine support is enabled

WATCHER::

WatchedEvent state:SyncConnected type:None path:null
[zk: 127.0.0.1:2181(CONNECTED) 0]
//临时节点已经没了。
[zk: 127.0.0.1:2181(CONNECTED) 0] ls /node_3
Node does not exist: /node_3
[zk: 127.0.0.1:2181(CONNECTED) 1]

```

##### 顺序节点
```
[zk: 127.0.0.1:2181(CONNECTED) 1] create  -s /node_3 123
Created /node_30000000002
[zk: 127.0.0.1:2181(CONNECTED) 2] create  -s /node_4 123
Created /node_40000000003

//分布式计数器
[zk: 127.0.0.1:2181(CONNECTED) 4] create  -s /node_3 123
Created /node_30000000004
[zk: 127.0.0.1:2181(CONNECTED) 5] create  -s /node_3 123
Created /node_30000000005
[zk: 127.0.0.1:2181(CONNECTED) 6] create  -s /node_3 123
Created /node_30000000006
```

### 修改指令 set
```
[zk: 127.0.0.1:2181(CONNECTED) 3] set /node_30000000005 999
cZxid = 0x100000014
ctime = Sat Jan 20 17:48:52 CST 2018
mZxid = 0x10000001a
mtime = Sat Jan 20 17:51:04 CST 2018
pZxid = 0x100000014
cversion = 0
dataVersion = 2
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 3
numChildren = 0
[zk: 127.0.0.1:2181(CONNECTED) 4] get /node_30000000005
999
cZxid = 0x100000014
ctime = Sat Jan 20 17:48:52 CST 2018
mZxid = 0x10000001a
mtime = Sat Jan 20 17:51:04 CST 2018
pZxid = 0x100000014
cversion = 0
dataVersion = 2--------------------------数据版本号发生变化 自增1 只要执行set 不管数据是否发生变化
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 3
numChildren = 0
[zk: 127.0.0.1:2181(CONNECTED) 5]



// set命令后边加上数据版本号 如果跟之前一致 会自增 。否则报错。 版本号无效 这个特性跟乐观锁相似。
[zk: 127.0.0.1:2181(CONNECTED) 5] set /node_30000000005 999 2
cZxid = 0x100000014
ctime = Sat Jan 20 17:48:52 CST 2018
mZxid = 0x10000001b
mtime = Sat Jan 20 17:53:03 CST 2018
pZxid = 0x100000014
cversion = 0
dataVersion = 3
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 3
numChildren = 0
[zk: 127.0.0.1:2181(CONNECTED) 6] set /node_30000000005 999 2
version No is not valid : /node_30000000005

```

### 删除指令
```
只能删除没有子节点的节点。
[zk: 127.0.0.1:2181(CONNECTED) 9] delete /node_30000000002

后边也可以跟一个版本号 用法类似。

//如果有子节点 需要通过rmr 来删除。
rmr /node_xx

```


### 配额
```
setquota -n|-b val path

setquota 
-n|-b -n 子节点个数 -b 限制数据值长度
val 含义随着上面的参数不同而不同
path 节点路径

// 设置/node_1节点最多有2个节点
[zk: 127.0.0.1:2182(CONNECTED) 2] setquota -n 2 /node_1
Comment: the parts are option -n val 2 path /node_1


[zk: 127.0.0.1:2182(CONNECTED) 3] create /node_1/node_1_2 123
Node already exists: /node_1/node_1_2
[zk: 127.0.0.1:2182(CONNECTED) 4] create /node_1/node_1_3 123
Created /node_1/node_1_3
[zk: 127.0.0.1:2182(CONNECTED) 5] create /node_1/node_1_4 123
Created /node_1/node_1_4
[zk: 127.0.0.1:2182(CONNECTED) 6] ls /node_1
[node_1_1, node_1_2, node_1_3, node_1_4]
[zk: 127.0.0.1:2182(CONNECTED) 7] create /node_1/node_1_4/node_1_4_1 123
Created /node_1/node_1_4/node_1_4_1

[zk: 127.0.0.1:2182(CONNECTED) 8] ls /node_1
[node_1_1, node_1_2, node_1_3, node_1_4]
[zk: 127.0.0.1:2182(CONNECTED) 9]
[zk: 127.0.0.1:2182(CONNECTED) 9]
[zk: 127.0.0.1:2182(CONNECTED) 9]


//查看配额信息 奇不奇怪？惊不惊喜？明明限制了配额，为什么还能创建子节点呢？ 仅仅在zookeeper.out里写了个预警而已。
[zk: 127.0.0.1:2182(CONNECTED) 10] listquota /node_1
absolute path is /zookeeper/quota/node_1/zookeeper_limits
Output quota for /node_1 count=2,bytes=-1
Output stat for /node_1 count=6,bytes=57



[zk: 127.0.0.1:2182(CONNECTED) 13] ls2 /node_1
[node_1_1, node_1_2, node_1_3, node_1_4]
cZxid = 0x10000000a
ctime = Sat Jan 20 17:37:13 CST 2018
mZxid = 0x10000000a
mtime = Sat Jan 20 17:37:13 CST 2018
pZxid = 0x100000029
cversion = 4
dataVersion = 0
aclVersion = 0
ephemeralOwner = 0x0
dataLength = 16
numChildren = 4




// 删除配额限制
[zk: 127.0.0.1:2182(CONNECTED) 0] delquota -n /node_

node_1             node_30000000005   node_40000000003   node_30000000006
[zk: 127.0.0.1:2182(CONNECTED) 0] delquota -n /node_1
[zk: 127.0.0.1:2182(CONNECTED) 1] listquota /node_

node_1             node_30000000005   node_40000000003   node_30000000006
[zk: 127.0.0.1:2182(CONNECTED) 1] listquota /node_1
absolute path is /zookeeper/quota/node_1/zookeeper_limits
Output quota for /node_1 count=-1,bytes=-1
Output stat for /node_1 count=9,bytes=66

```

### history redo
```
[zk: 127.0.0.1:2182(CONNECTED) 3] history 100
0 - delquota -n /node_1
1 - listquota /node_1
2 - history
3 - history 100
[zk: 127.0.0.1:2182(CONNECTED) 4]
[zk: 127.0.0.1:2182(CONNECTED) 4]
[zk: 127.0.0.1:2182(CONNECTED) 4] redo -2
Command index out of range
[zk: 127.0.0.1:2182(CONNECTED) 5] redo 2
0 - delquota -n /node_1
1 - listquota /node_1
2 - history
3 - history 100
4 - redo -2
5 - history
[zk: 127.0.0.1:2182(CONNECTED) 6]

```