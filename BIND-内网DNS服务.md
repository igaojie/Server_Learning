# BIND-内网DNS服务
伯克利互联网名称服务 (Berkeley Internet Name Daemon，简称 BIND) 是 DNS 协议的一个参考实现。

## 安装
### install bind on mac
```
brew install bind

//启动服务
brew services start bind

//启动进程查看
$ ps -ef | grep named | grep -v grep
  501 20679     1   0  4:31下午 ??         0:00.06 /usr/local/opt/bind/sbin/named -f -c /usr/local/etc/named.conf
```
## 配置文件

/usr/local/etc/named.conf 