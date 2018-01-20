# ZooKeeper
## 概述
ZooKeeper是源代码开放的分布式协调服务。是一个高性能的分布式数据一致性解决方案，将复杂的、容易出错的分布式一致性服务封装起来，构成一个高效可靠的原语集，并提供一系列的简单易用的接口给用户使用。

1. 源代码开放
2. 分布式协调服务，解决分布式数据一致性问题
   1. 顺序一致性（一个客户端发起一个事务请求，最终按照发起的顺序被应用到zk）
   2. 原子性（所有事务请求的处理结果在集群中任意一台服务器处理结果一致）
   3. 单一视图
   4. 可靠性
   5. 实时性
3. 高性能
4. 可以调用zookeeper提供的接口来解决一些分布式应用中的实际问题

### 应用场景
1. 数据发布/订阅
    1. 推模式
    2. 拉模式
    3. zk采用两种方式相结合。
2. 负载均衡
3. 命名服务
   提供名称的服务，例如数据库表格ID 
   1. 自动增长ID -- 局限在单库单表 不能分布式使用
   2. UUID---可以在分布式使用，但是没有规律不便于理解。
   3. 可以通过zk来生成一个顺序增长的可以在集群环境下使用的易于理解的ID
4. 分布式协调/通知
   1. 心跳检测

### 优势
1. 源代码开放
2. 已经被证实高性能 易用稳定的工业级产品
3. 有着广泛应用 Hadoop HBase Storm Solr


## 基本概念
* 集群角色
  1. Leader服务器是整个ZooKeeper集群工作机制的核心
  2. Follower服务器是ZooKeeper集群状态的跟随者
  3. Observer服务器充当一个观察者的角色
  4. Leader Follower 设计模式 和 Observer观察者模式
* 会话
  1. 客户端和ZooKeeper的连接，ZooKeeper中的会话叫做Session，客户端与服务器建立一个TCP的长连接来维持一个Session，客户端在启动的时候首先与服务器建立一个TCP连接，通过这个连接，客户端能够通过心跳检测与服务器保持有效的会话，也能向ZK服务器发送请求并获得响应。
* 数据节点
  1. 集群中的一台机器可以成为一个节点
  2. 数据模型中的数据单元为Znode，分为持久节点和临时节点。
* 版本
  1. version--当前数据节点数据内容的版本号
  2. cversion--当前数据节点子节点的版本号
  3. aversion--当前数据节点ACL变更版本号
  4. 悲观锁 和 乐观锁
     1. 悲观锁又叫悲观并发锁，是数据库中一种非常严格的锁策略，具有强烈的排他性，能够避免不同事物对同一个数据并发更新造成的数据不一致，在上一个事务未完成之前，下一个事物不能访问相同的数据资源，适合数据更新竞争非常激烈的场景
     2. 相比悲观锁，乐观锁的使用场景更多，悲观锁认为事务访问相同的数据的时候一定会出现相互的干扰，简单粗暴排他性访问。乐观锁认为不同事务访问相同资源很少出现相互干扰的情况，因此在事务处理期间不需要进行并发控制。当然乐观锁也是锁，还是会有并发的控制。
* watcher
  1. 事件监听器
     ZK允许用户在制定的节点上注册一些watcher，当数据节点发生变化的时候，zk服务器会把这个变化通知给感兴趣的客户端。
* ACL权限控制
  Access Control Lists
  1. CREATE:创建子节点的权限 
  2. READ：获取节点数据和子节点列表的权限
  3. WRITE：更新节点数据的权限
  4. DELETE：删除子节点的权限
  5. ADMIN：设置节点ACL的权限

## 安装
### brew install zookeeper
```
ShaodeMacBook-Pro:~ ShaoGaoJie$ brew search zookeeper
==> Searching local taps...
homebrew/php/php53-zookeeper             homebrew/php/php54-zookeeper             homebrew/php/php55-zookeeper             homebrew/php/php56-zookeeper             zookeeper
==> Searching taps on GitHub...
==> Searching blacklisted, migrated and deleted formulae...
ShaodeMacBook-Pro:~ ShaoGaoJie$ brew install zookeeper
==> Downloading https://homebrew.bintray.com/bottles/zookeeper-3.4.10.high_sierra.bottle.1.tar.gz
######################################################################## 100.0%
==> Pouring zookeeper-3.4.10.high_sierra.bottle.1.tar.gz
==> Caveats
To have launchd start zookeeper now and restart at login:
  brew services start zookeeper
Or, if you don't want/need a background service you can just run:
  zkServer start
==> Summary
🍺  /usr/local/Cellar/zookeeper/3.4.10: 241 files, 31.4MB


## 启动
ShaodeMacBook-Pro:~ ShaoGaoJie$ zkServer
ZooKeeper JMX enabled by default
Using config: /usr/local/etc/zookeeper/zoo.cfg
Usage: ./zkServer.sh {start|start-foreground|stop|restart|status|upgrade|print-cmd}

配置文件为 /usr/local/etc/zookeeper/zoo.cfg

ShaodeMacBook-Pro:~ ShaoGaoJie$
ShaodeMacBook-Pro:~ ShaoGaoJie$
ShaodeMacBook-Pro:~ ShaoGaoJie$ zkServer start
ZooKeeper JMX enabled by default
Using config: /usr/local/etc/zookeeper/zoo.cfg
Starting zookeeper ... STARTED

1. 这个时候Mac弹框提示 【您需要安装 JDK 才能使用“java”命令行工具。点按“更多信息…”来访问 Java 开发工具包下载网站。】点击 更多信息 去下载。
2. 下载安装，这就不一一赘述了。
3. 安装完毕之后，打开https://java.com/zh_CN/download/installed.jsp可以进行验证。

ShaodeMacBook-Pro:~ ShaoGaoJie$ java --version
No Java runtime present, requesting install.

4.http://www.oracle.com/technetwork/java/javase/downloads/jdk9-downloads-3848520.html 下载jdk。 


5. 再次启动
ShaodeMacBook-Pro:~ ShaoGaoJie$ java --version
java 9.0.4
Java(TM) SE Runtime Environment (build 9.0.4+11)
Java HotSpot(TM) 64-Bit Server VM (build 9.0.4+11, mixed mode)
```

### 单机Server模式运行
```
ShaodeMacBook-Pro:~ ShaoGaoJie$ zkServer start
ZooKeeper JMX enabled by default
Using config: /usr/local/etc/zookeeper/zoo.cfg
Starting zookeeper ... STARTED
ShaodeMacBook-Pro:~ ShaoGaoJie$ ps -ef | grep zook
  501 47328     1   0  5:33下午 ttys022    0:01.70 /usr/bin/java -Dzookeeper.log.dir=. -Dzookeeper.root.logger=INFO,CONSOLE -cp /usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../build/classes:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../build/lib/*.jar:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../lib/slf4j-log4j12-1.6.1.jar:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../lib/slf4j-api-1.6.1.jar:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../lib/netty-3.10.5.Final.jar:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../lib/log4j-1.2.16.jar:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../lib/jline-0.9.94.jar:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../zookeeper-3.4.10.jar:/usr/local/Cellar/zookeeper/3.4.10/libexec/bin/../src/java/lib/*.jar:/usr/local/etc/zookeeper: -Dcom.sun.management.jmxremote -Dcom.sun.management.jmxremote.local.only=false org.apache.zookeeper.server.quorum.QuorumPeerMain /usr/local/etc/zookeeper/zoo.cfg

通过nc 或者 telnet 访问2181端口 判断zookeeper服务是否启动成功
ShaodeMacBook-Pro:~ ShaoGaoJie$ echo ruok | nc localhost 2181
imok

ShaodeMacBook-Pro:~ ShaoGaoJie$ echo conf | nc localhost 2181
clientPort=2181------zookeeper监听客户端连接的端口默认是2181
dataDir=/usr/local/var/run/zookeeper/data/version-2   ------持久化数据存放的目录
dataLogDir=/usr/local/var/run/zookeeper/data/version-2
tickTime=2000---------zookeeper中基本时间单元，单位是毫秒
maxClientCnxns=60
minSessionTimeout=4000
maxSessionTimeout=40000
serverId=0
ShaodeMacBook-Pro:~ ShaoGaoJie$ netstat -an | grep 2181
tcp46      0      0  *.2181                 *.*                    LISTEN
tcp4       0      0  127.0.0.1.54671        127.0.0.1.2181         TIME_WAIT
ShaodeMacBook-Pro:~ ShaoGaoJie$


通过telnet 来验证是否启动。
ShaoGaoJie@ShaodeMacBook-Pro ~> telnet 127.0.0.1 2181
Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
stat----输入 stat命令
Zookeeper version: 3.4.10-39d3a4f269333c922ed3db283be479f9deacaa0f, built on 03/23/2017 10:13 GMT
Clients:
 /127.0.0.1:58630[0](queued=0,recved=1,sent=0)

Latency min/avg/max: 0/0/0
Received: 8
Sent: 7
Connections: 1
Outstanding: 0
Zxid: 0x0
Mode: standalone------当前模式 单机模式
Node count: 4
Connection closed by foreign host.

```

#### 伪集群模式
```
1. 复制三份zoo.cnf
   cp zoo.cfg zk1.cfg
   cp zoo.cfg zk2.cfg
   cp zoo.cfg zk3.cfg
2. 分别修改三个配置文件的dataDir 和 clientPort 以及集群内的机器。
   1. 修改zk1.cnf
   
   # The number of milliseconds of each tick
tickTime=2000
# The number of ticks that the initial
# synchronization phase can take
initLimit=10
# The number of ticks that can pass between
# sending a request and getting an acknowledgement
syncLimit=5
# the directory where the snapshot is stored.
# do not use /tmp for storage, /tmp here is just
# example sakes.
dataDir=/usr/local/var/run/zookeeper/data/zk1------- dataDir
# the port at which the clients will connect
clientPort=2181------------------------------------端口
# the maximum number of client connections.
# increase this if you need to handle more clients
#maxClientCnxns=60
#
# Be sure to read the maintenance section of the
# administrator guide before turning on autopurge.
#
# http://zookeeper.apache.org/doc/current/zookeeperAdmin.html#sc_maintenance
#
# The number of snapshots to retain in dataDir
#autopurge.snapRetainCount=3
# Purge task interval in hours
# Set to "0" to disable auto purge feature
#autopurge.purgeInterval=1
# 配置集群内的机器
server.1=127.0.0.1:2188:3188
server.2=127.0.0.1:2189:3189
server.3=127.0.0.1:2190:3190
   2. 修改zk2.cnf
   clientPort=2182
   dataDir=/usr/local/var/run/zookeeper/data/zk2
   
   server.1=127.0.0.1:2188:3188
   server.2=127.0.0.1:2189:3189
   server.3=127.0.0.1:2190:3190

   3. 修改zk3.cnf
   clientPort=2183
   dataDir=/usr/local/var/run/zookeeper/data/zk3
   
   server.1=127.0.0.1:2188:3188
   server.2=127.0.0.1:2189:3189
   server.3=127.0.0.1:2190:3190 
   
3. 启动
    zkServer stop /usr/local/etc/zookeeper/zk1.cfg
    zkServer stop /usr/local/etc/zookeeper/zk2.cfg
    zkServer stop /usr/local/etc/zookeeper/zk3.cfg
 
4. 检测是否启动成功
   ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper> telnet 127.0.0.1 2181
	Trying 127.0.0.1...
	Connected to localhost.
	Escape character is '^]'.
	stats
	Zookeeper version: 3.4.10-39d3a4f269333c922ed3db283be479f9deacaa0f, built on 03/23/2017 10:13 GMT
	Clients:
	 /127.0.0.1:61210[0](queued=0,recved=1,sent=0)
	
	Latency min/avg/max: 0/0/0
	Received: 2
	Sent: 1
	Connections: 1
	Outstanding: 0
	Zxid: 0x100000000
	Mode: follower---------------角色：Follower
	Node count: 4
	Connection closed by foreign host.
	ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper


    ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper> telnet 127.0.0.1 2182
		Trying 127.0.0.1...
		Connected to localhost.
		Escape character is '^]'.
		stats
		Zookeeper version: 3.4.10-39d3a4f269333c922ed3db283be479f9deacaa0f, built on 03/23/2017 10:13 GMT
		Clients:
		 /127.0.0.1:61214[0](queued=0,recved=1,sent=0)
		
		Latency min/avg/max: 0/0/0
		Received: 3
		Sent: 2
		Connections: 1
		Outstanding: 0
		Zxid: 0x0
		Mode: follower---------------角色 Follower
		Node count: 4
		Connection closed by foreign host.
		ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper>
		
		
		ShaoGaoJie@ShaodeMacBook-Pro /u/l/e/zookeeper> telnet 127.0.0.1 2183
		Trying 127.0.0.1...
		Connected to localhost.
		Escape character is '^]'.
		stats
		Zookeeper version: 3.4.10-39d3a4f269333c922ed3db283be479f9deacaa0f, built on 03/23/2017 10:13 GMT
		Clients:
		 /127.0.0.1:61215[0](queued=0,recved=1,sent=0)
		
		Latency min/avg/max: 0/0/0
		Received: 3
		Sent: 2
		Connections: 1
		Outstanding: 0
		Zxid: 0x100000000
		Mode: leader------------------------角色：Leader
		Node count: 4
		Connection closed by foreign host.

```

### 命令
|Category|Command|Description|
|:--|:--|:--|
|Server status| ruok |Tests if server is running in a non-error state. The server will respond with imok if it is running. Otherwise it will not respond at all.A response of "imok" does not necessarily indicate that the server has joined the quorum, just that the server process is active and bound to the specified client port. Use "stat" for details on state wrt quorum and client connection information.|
|| conf |Print details about serving configuration.|
|| envi |Print details about serving environment|
||srvr|Lists full details for the server.|
|| stat |Lists brief details for the server and connected clients.|
|| srst |Reset server statistics.|
|Client connections|dump||
||cons|List full connection/session details for all clients connected to this server. Includes information on numbers of packets received/sent, session id, operation latencies, last operation performed, etc.|
||crst|Reset connection/session statistics for all connections.|
|Watches|wchs| Lists brief information on watches for the server.|
||wchc|Lists detailed information on watches for the server, by session. This outputs a list of sessions(connections) with associated watches (paths). Note, depending on the number of watches this operation may be expensive (ie impact server performance), use it carefully.|
||wchp|Lists detailed information on watches for the server, by path. This outputs a list of paths (znodes) with associated sessions. Note, depending on the number of watches this operation may be expensive (ie impact server performance), use it carefully.|
|Monitoring|mntr|Outputs a list of variables that could be used for monitoring the health of the cluster.|

#### 命令案例
```
$ echo mntr | nc localhost 2181
zk_version	3.4.10-39d3a4f269333c922ed3db283be479f9deacaa0f, built on 03/23/2017 10:13 GMT
zk_avg_latency	0
zk_max_latency	0
zk_min_latency	0
zk_packets_received	4
zk_packets_sent	3
zk_num_alive_connections	1
zk_outstanding_requests	0
zk_server_state	standalone
zk_znode_count	4
zk_watch_count	0
zk_ephemerals_count	0
zk_approximate_data_size	27
zk_open_file_descriptor_count	23
zk_max_file_descriptor_count	10240
ShaodeMacBook-Pro:~ ShaoGaoJie$
ShaodeMacBook-Pro:~ ShaoGaoJie$
```