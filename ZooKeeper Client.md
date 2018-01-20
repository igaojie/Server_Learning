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