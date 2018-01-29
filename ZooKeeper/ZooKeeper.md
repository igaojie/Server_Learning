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
    zkServer start /usr/local/etc/zookeeper/zk1.cfg
    zkServer start /usr/local/etc/zookeeper/zk2.cfg
    zkServer start /usr/local/etc/zookeeper/zk3.cfg
 
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

### zoo.cfg 配置参数说明
* tickTime：这个时间是作为 Zookeeper 服务器之间或客户端与服务器之间维持心跳的时间间隔，也就是每个 tickTime 时间就会发送一个心跳。默认 tickTime=2000
* dataDir：顾名思义就是 Zookeeper 保存数据的目录，默认情况下，Zookeeper 将写数据的日志文件也保存在这个目录里。
* clientPort：这个端口就是客户端连接 Zookeeper 服务器的端口，Zookeeper 会监听这个端口，接受客户端的访问请求。
* initLimit：这个配置项是用来配置 Zookeeper 接受客户端（这里所说的客户端不是用户连接 Zookeeper 服务器的客户端，而是 Zookeeper 服务器集群中连接到 Leader 的 Follower 服务器）初始化连接时最长能忍受多少个心跳时间间隔数。当已经超过 5 个心跳的时间（也就是 tickTime）长度后 Zookeeper 服务器还没有收到客户端的返回信息，那么表明这个客户端连接失败。总的时间长度就是 5*2000=10 秒 默认：initLimit=10
* syncLimit：这个配置项标识 Leader 与 Follower 之间发送消息，请求和应答时间长度，最长不能超过多少个 tickTime 的时间长度，总的时间长度就是 5*2000=10 秒  默认 syncLimit=5
* server.A=B：C：D：其中 A 是一个数字，表示这个是第几号服务器；B 是这个服务器的 ip 地址；C 表示的是这个服务器与集群中的 Leader 服务器交换信息的端口；D 表示的是万一集群中的 Leader 服务器挂了，需要一个端口来重新进行选举，选出一个新的 Leader，而这个端口就是用来执行选举时服务器相互通信的端口。如果是伪集群的配置方式，由于 B 都是一样，所以不同的 Zookeeper 实例通信端口号不能一样，所以要给它们分配不同的端口号。

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


## centos安装 ZooKeeper
```
[root@10.70.1.232 ~]#yum install zookeeper
...
...
...
Is this ok [y/N]: y
Downloading Packages:
Running rpm_check_debug
ERROR with rpm_check_debug vs depsolve:
libc.so.6(GLIBC_2.14)(64bit) is needed by xinsrv-libzookeeper-3.4.11-1.el7.centos.x86_64
** Found 2 pre-existing rpmdb problem(s), 'yum check' output follows:
mysql-devel-5.1.73-8.el6_8.x86_64 has missing requires of mysql = ('0', '5.1.73', '8.el6_8')
mysql-server-5.1.73-8.el6_8.x86_64 has missing requires of mysql = ('0', '5.1.73', '8.el6_8')
Your transaction was saved, rerun it with:
 yum load-transaction /tmp/yum_save_tx-2018-01-29-10-20vl__ma.yumtx
[root@10.70.1.232 ~]#

//报错 
libc.so.6(GLIBC_2.14)(64bit) is needed by xinsrv-libzookeeper-3.4.11-1.el7.centos.x86_64

[root@10.70.1.232 ~]#yum info glibc
Loaded plugins: fastestmirror, priorities
Loading mirror speeds from cached hostfile
 * base: ftp.sjtu.edu.cn
 * epel: mirrors.ustc.edu.cn
 * extras: ftp.sjtu.edu.cn
 * updates: mirrors.tuna.tsinghua.edu.cn
169 packages excluded due to repository priority protections
Installed Packages
Name        : glibc
Arch        : i686
Version     : 2.12 // ZooKeeper需要 2.14版本 而本机是2.12 所以报错了。
Release     : 1.209.el6_9.2
Size        : 13 M
Repo        : installed
From repo   : updates
Summary     : The GNU libc libraries
URL         : http://sources.redhat.com/glibc/
License     : LGPLv2+ and LGPLv2+ with exceptions and GPLv2+
Description : The glibc package contains standard libraries which are used by
            : multiple programs on the system. In order to save disk space and
            : memory, as well as to make upgrading easier, common system code is
            : kept in one place and shared between programs. This particular package
            : contains the most important sets of shared libraries: the standard C
            : library and the standard math library. Without these two libraries, a
            : Linux system will not function.

Name        : glibc
Arch        : x86_64
Version     : 2.12
Release     : 1.209.el6_9.2
Size        : 13 M
Repo        : installed
From repo   : updates
Summary     : The GNU libc libraries
URL         : http://sources.redhat.com/glibc/
License     : LGPLv2+ and LGPLv2+ with exceptions and GPLv2+
Description : The glibc package contains standard libraries which are used by
            : multiple programs on the system. In order to save disk space and
            : memory, as well as to make upgrading easier, common system code is
            : kept in one place and shared between programs. This particular package
            : contains the most important sets of shared libraries: the standard C
            : library and the standard math library. Without these two libraries, a
            : Linux system will not function.

[root@10.70.1.232 ~]#
//系统版本
[root@10.70.1.232 ~]#cat /etc/redhat-release
CentOS release 6.7 (Final)

//升级glibc 参考下边的[升级glibc]
//继续 ZooKeeper安装

[root@10.70.1.232 home]#yum install zookeeper
....
....
....
Installed:
  xinsrv-libzookeeper.x86_64 0:3.4.11-1.el7.centos

Complete!

[root@10.70.1.232 home]#cd /data1/xinsrv/zookeeper/
bin/                      conf/                     docs/                     lib/                      README_packaging.txt      src/                      zookeeper-3.4.8.jar.md5
build.xml                 contrib/                  ivysettings.xml           LICENSE.txt               README.txt                zookeeper-3.4.8.jar       zookeeper-3.4.8.jar.sha1
CHANGES.txt               dist-maven/               ivy.xml                   NOTICE.txt                recipes/                  zookeeper-3.4.8.jar.asc

[root@10.70.1.232 home]#cd /data1/xinsrv/zookeeper/bin/
README.txt    zkCleanup.sh  zkCli.cmd     zkCli.sh      zkEnv.cmd     zkEnv.sh      zkServer.cmd  zkServer.sh
[root@10.70.1.232 home]#cd /data1/xinsrv/zookeeper/bin/zkServer.sh
-bash: cd: /data1/xinsrv/zookeeper/bin/zkServer.sh: Not a directory
[root@10.70.1.232 home]# /data1/xinsrv/zookeeper/bin/zkServer.sh
ZooKeeper JMX enabled by default
Using config: /data1/xinsrv/zookeeper/bin/../conf/zoo.cfg
Usage: /data1/xinsrv/zookeeper/bin/zkServer.sh {start|start-foreground|stop|restart|status|upgrade|print-cmd}

//启动ZooKeeper服务
[root@10.70.1.232 home]# /data1/xinsrv/zookeeper/bin/zkServer.sh start
ZooKeeper JMX enabled by default
Using config: /data1/xinsrv/zookeeper/bin/../conf/zoo.cfg
Starting zookeeper ... STARTED
[root@10.70.1.232 home]#ps -ef | grep zookeeper.out
root     30411  2403  0 11:28 pts/1    00:00:00 grep zookeeper.out
[root@10.70.1.232 home]#ps -ef | grep zookeeper
root     30394     1  5 11:28 pts/1    00:00:00 java -Dzookeeper.log.dir=. -Dzookeeper.root.logger=INFO,CONSOLE -cp /data1/xinsrv/zookeeper/bin/../build/classes:/data1/xinsrv/zookeeper/bin/../build/lib/*.jar:/data1/xinsrv/zookeeper/bin/../lib/slf4j-log4j12-1.6.1.jar:/data1/xinsrv/zookeeper/bin/../lib/slf4j-api-1.6.1.jar:/data1/xinsrv/zookeeper/bin/../lib/netty-3.7.0.Final.jar:/data1/xinsrv/zookeeper/bin/../lib/log4j-1.2.16.jar:/data1/xinsrv/zookeeper/bin/../lib/jline-0.9.94.jar:/data1/xinsrv/zookeeper/bin/../zookeeper-3.4.8.jar:/data1/xinsrv/zookeeper/bin/../src/java/lib/*.jar:/data1/xinsrv/zookeeper/bin/../conf: -Dcom.sun.management.jmxremote -Dcom.sun.management.jmxremote.local.only=false org.apache.zookeeper.server.quorum.QuorumPeerMain /data1/xinsrv/zookeeper/bin/../conf/zoo.cfg
root     30415  2403  0 11:28 pts/1    00:00:00 grep zookeeper



```

### 升级glibc

```
[root@10.70.1.232 home]#vim glibc.sh
#! /bin/sh
# update glibc to 2.17 for CentOS 6
wget http://copr-be.cloud.fedoraproject.org/results/mosquito/myrepo-el6/epel-6-x86_64/glibc-2.17-55.fc20/glibc-2.17-55.el6.x86_64.rpm
wget http://copr-be.cloud.fedoraproject.org/results/mosquito/myrepo-el6/epel-6-x86_64/glibc-2.17-55.fc20/glibc-common-2.17-55.el6.x86_64.rpm
wget http://copr-be.cloud.fedoraproject.org/results/mosquito/myrepo-el6/epel-6-x86_64/glibc-2.17-55.fc20/glibc-devel-2.17-55.el6.x86_64.rpm
wget http://copr-be.cloud.fedoraproject.org/results/mosquito/myrepo-el6/epel-6-x86_64/glibc-2.17-55.fc20/glibc-headers-2.17-55.el6.x86_64.rpm
sudo rpm -Uvh glibc-2.17-55.el6.x86_64.rpm \
glibc-common-2.17-55.el6.x86_64.rpm \
glibc-devel-2.17-55.el6.x86_64.rpm \
glibc-headers-2.17-55.el6.x86_64.rpm --force --nodeps

//赋予执行权限
#chmod u+x ./glibc.sh
//执行
#./glibc.sh


(--force --nodeps) 如果报错 加上 --force --nodeps 即可。
warning: glibc-2.17-55.el6.x86_64.rpm: Header V3 RSA/SHA1 Signature, key ID 73ec361c: NOKEY
error: Failed dependencies:
	glibc-common = 2.12-1.209.el6_9.2 is needed by (installed) glibc-2.12-1.209.el6_9.2.i686



```

## 参考
1. [CentOS 6.x 如何升级 glibc 2.17](http://movingon.cn/2017/05/05/CentOS-6-x-如何升级-glibc-2-17/)
2. [分享Centos6.5升级glibc过程](https://cnodejs.org/topic/56dc21f1502596633dc2c3dc)
3. [使用源代码将 Glibc 升级到 2.6](https://www.ibm.com/developerworks/cn/linux/l-cn-glibc-upd/index.html)