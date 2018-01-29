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

当创建znode的时候你还可以请求在路径的最后追加一个单调递增的计数器。这个计数器在父节点是唯一的。计数器有一个%010d --的格式，它是10位数用0做填充(计数器用这个方法格式化简化排序)，也就是：0000000001。查看Queue Recipe使用这个特性的例子。注释：计数器的序列号由父节点通过一个int类型维护，计数器当超过2147483647的时候将会溢出(-2147483647将会导致)。

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

// 设置/node_2节点最多有2个节点
[zk: 127.0.0.1:2182(CONNECTED) 39] create /node_2 123
Created /node_2
[zk: 127.0.0.1:2182(CONNECTED) 40] setquota -n 2 /node_

node_1   node_2
[zk: 127.0.0.1:2182(CONNECTED) 40] setquota -n 2 /node_2
Comment: the parts are option -n val 2 path /node_2
[zk: 127.0.0.1:2182(CONNECTED) 41] create /node_

node_1   node_2
[zk: 127.0.0.1:2182(CONNECTED) 41] create /node_2/node_2_1 123
Created /node_2/node_2_1
[zk: 127.0.0.1:2182(CONNECTED) 42] create /node_2/node_2_1 123
Node already exists: /node_2/node_2_1
[zk: 127.0.0.1:2182(CONNECTED) 43] create /node_2/node_2_2 123
Created /node_2/node_2_2
[zk: 127.0.0.1:2182(CONNECTED) 44] create /node_2/node_2_3 123
Created /node_2/node_2_3
[zk: 127.0.0.1:2182(CONNECTED) 45] create /node_2/node_2_4 123
Created /node_2/node_2_4
[zk: 127.0.0.1:2182(CONNECTED) 46]


//查看配额信息 奇不奇怪？惊不惊喜？明明限制了配额，为什么还能创建子节点呢？ 仅仅在zookeeper.out里写了个预警而已。

// 我是brew install zookeeper的，日志文件在/usr/local/var/log/zookeeper/zookeeper.log 里。
->tail -f /usr/local/var/log/zookeeper/zookeeper.log
//个数有三个了 limit为2 仅仅提醒一下 
2018-01-22 16:16:59 DataTree [WARN] Quota exceeded: /node_2 count=3 limit=2
2018-01-22 16:16:59 DataTree [WARN] Quota exceeded: /node_2 count=3 limit=2
2018-01-22 16:16:59 DataTree [WARN] Quota exceeded: /node_2 count=3 limit=2
2018-01-22 16:17:01 DataTree [WARN] Quota exceeded: /node_2 count=4 limit=2
2018-01-22 16:17:01 DataTree [WARN] Quota exceeded: /node_2 count=4 limit=2
2018-01-22 16:17:01 DataTree [WARN] Quota exceeded: /node_2 count=4 limit=2
2018-01-22 16:17:04 DataTree [WARN] Quota exceeded: /node_2 count=5 limit=2
2018-01-22 16:17:04 DataTree [WARN] Quota exceeded: /node_2 count=5 limit=2
2018-01-22 16:17:04 DataTree [WARN] Quota exceeded: /node_2 count=5 limit=2

// 现在直接删掉/node_2节点 继续为/node_2新增节点 看看设么效果？
//直接删掉节点 而没有删除配额信息，那么配额信息会一直存在，并且不能重新设置配额。否则会报错：Command failed: java.lang.IllegalArgumentException: /node_2 has a parent /zookeeper/quota/node_2 which has a quota

//查看配额信息
[zk: 127.0.0.1:2182(CONNECTED) 46] listquota /node_2
absolute path is /zookeeper/quota/node_2/zookeeper_limits
Output quota for /node_2 count=2,bytes=-1
Output stat for /node_2 count=5,bytes=15


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
[zk: 127.0.0.1:2182(CONNECTED) 0] delquota -n /node_1
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
### watch 
```
// 为/node_2添加监视 如果有
[zk: 127.0.0.1:2182(CONNECTED) 5] ls /node_2 true
[a_20000000009, a_20000000008, a_20000000019, a_20000000016, a_20000000015, a_20000000007, a_20000000018, a_20000000006, a_20000000017, a_20000000012, a_20000000011, a_20000000014, a_20000000013, a_20000000010, a_20000000020, node_2_1, node_2_18, node_2_2, node_2_3, node_2_4, node_2_5]
[zk: 127.0.0.1:2182(CONNECTED) 6]
WATCHER::

WatchedEvent state:SyncConnected type:NodeChildrenChanged path:/node_2

```

### Acl权限控制
```
传统的文件系统中，ACL分为两个维度，一个是属组，一个是权限，子目录/文件默认继承父目录的ACL。而在Zookeeper中，node的ACL是没有继承关系的，是独立控制的。Zookeeper的ACL，可以从三个维度来理解：一是scheme; 二是user; 三是permission，通常表示为scheme:id:permissions, 下面从这三个方面分别来介绍：
1.（1）scheme: scheme对应于采用哪种方案来进行权限管理，zookeeper实现了一个pluggable的ACL方案，可以通过扩展scheme，来扩展ACL的机制。zookeeper-3.4.4缺省支持下面几种scheme:

world: 它下面只有一个id, 叫anyone, world:anyone代表任何人，zookeeper中对所有人有权限的结点就是属于world:anyone的
auth: 它不需要id, 只要是通过authentication的user都有权限（zookeeper支持通过kerberos来进行authencation, 也支持username/password形式的authentication)
digest: 它对应的id为username:BASE64(SHA1(password))，它需要先通过username:password形式的authentication
ip: 它对应的id为客户机的IP地址，设置的时候可以设置一个ip段，比如ip:192.168.1.0/16, 表示匹配前16个bit的IP段
super: 在这种scheme情况下，对应的id拥有超级权限，可以做任何事情(cdrwa)

另外，zookeeper-3.4.4的代码中还提供了对sasl的支持，不过缺省是没有开启的，需要配置才能启用，具体怎么配置在下文中介绍。

sasl: sasl的对应的id，是一个通过sasl authentication用户的id，zookeeper-3.4.4中的sasl authentication是通过kerberos来实现的，也就是说用户只有通过了kerberos认证，才能访问它有权限的node.
（2）id: id与scheme是紧密相关的，具体的情况在上面介绍scheme的过程都已介绍，这里不再赘述。

（3）permission: zookeeper目前支持下面一些权限：

CREATE(c): 创建权限，可以在在当前node下创建child node
DELETE(d): 删除权限，可以删除当前的node
READ(r): 读权限，可以获取当前node的数据，可以list当前node所有的child nodes
WRITE(w): 写权限，可以向当前node写数据
ADMIN(a): 管理权限，可以设置当前node的permission
```

```
//world：默认方式，相当于全世界都能访问
[zk: 127.0.0.1:2182(CONNECTED) 26] create /aaa abc
Created /aaa
[zk: 127.0.0.1:2182(CONNECTED) 27] getAcl /aaa
'world,'anyone
: cdrwa


//创建节点 /a
[zk: 127.0.0.1:2182(CONNECTED) 13] create /a data
Created /a
// 为/a节点设置权限
// ip：使用Ip地址认证
[zk: 127.0.0.1:2182(CONNECTED) 14] setAcl /a ip:127.0.0.1:cdrw
cZxid = 0x300000128
ctime = Fri Jan 26 11:17:12 CST 2018
mZxid = 0x300000128
mtime = Fri Jan 26 11:17:12 CST 2018
pZxid = 0x300000128
cversion = 0
dataVersion = 0
aclVersion = 1
ephemeralOwner = 0x0
dataLength = 4
numChildren = 0
//获取 /a 权限
[zk: 127.0.0.1:2182(CONNECTED) 16] getAcl /a
'ip,'127.0.0.1
: cdrw
[zk: 127.0.0.1:2182(CONNECTED) 17]


//auth：代表已经认证通过的用户(cli中可以通过addauth digest user:pwd 来添加当前上下文中的授权用户)

[zk: 127.0.0.1:2182(CONNECTED) 21] addauth digest a:123

[zk: 127.0.0.1:2182(CONNECTED) 24] create /aa aa auth:a:123:r
Created /aa
[zk: 127.0.0.1:2182(CONNECTED) 25] getAcl /aa
'digest,'a:BTiKABvL7rKsT7fa2hBWBjsdtLk=
: r


//digest: 它对应的id为username:BASE64(SHA1(password))，它需要先通过username:password形式的authentication
ShaodeMacBook-Pro:~ ShaoGaoJie$ echo -n user1:pwd1 | openssl dgst -binary -sha1 | openssl base64
a9l5yfb9zl8WCXjVmi5/XOC0Ep4=

[zk: 127.0.0.1:2182(CONNECTED) 7] create /acl06 acl06
Created /acl06

[zk: 127.0.0.1:2182(CONNECTED) 8] setAcl /acl06 digest:user1:a9l5yfb9zl8WCXjVmi5/XOC0Ep4=:r
cZxid = 0x30000013f
ctime = Fri Jan 26 13:37:04 CST 2018
mZxid = 0x30000013f
mtime = Fri Jan 26 13:37:04 CST 2018
pZxid = 0x30000013f
cversion = 0
dataVersion = 0
aclVersion = 1
ephemeralOwner = 0x0
dataLength = 5
numChildren = 0
[zk: 127.0.0.1:2182(CONNECTED) 9]
[zk: 127.0.0.1:2182(CONNECTED) 9]

[zk: 127.0.0.1:2182(CONNECTED) 9] get /acl06
Authentication is not valid : /acl06
[zk: 127.0.0.1:2182(CONNECTED) 10] addauth digest user1:pwd1
[zk: 127.0.0.1:2182(CONNECTED) 11] get /acl06       acl06
cZxid = 0x30000013f
ctime = Fri Jan 26 13:37:04 CST 2018
mZxid = 0x30000013f
mtime = Fri Jan 26 13:37:04 CST 2018
pZxid = 0x30000013f
cversion = 0
dataVersion = 0
aclVersion = 1
ephemeralOwner = 0x0
dataLength = 5
numChildren = 0


```

## 客户端
### java
```
ZkClient

Curator
```

## PHP_SWOOLE安装
```
1. Mac OS php56 安装swoole扩展
brew info homebrew/php/php56-zookeeper

2. Centos php56 安装Swoole扩展
[root@10.70.1.232 home]# wget https://pecl.php.net/get/zookeeper-0.4.0.tgz

[root@10.70.1.232 home]#tar zxvf zookeeper-0.4.0.tgz

#cd zookeeper-0.4.0
/data1/xinsrv/php/bin/phpize
./configure -–with-php-config=xxxx/php-config
#make && make install
#php --ini
extension=zookeeper.so

/etc/init.d/php-fpm restart即可。
```

### 场景分析
#### 1. master 选举

#### 2. 数据的发布与订阅
#### 3. 负载均衡


# ETCD
