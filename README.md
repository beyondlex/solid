### 智能硬件平台

#### Install

将项目clone到本地后复制根目录.env.example文件到.env，修改.env文件中的配置为本机环境的配置（数据库、Redis等）

执行composer install加载依赖包：

```sh
composer install
```

执行migration生成数据到数据库：（需先在本地创建一个空的数据库并使.env的配置指向该库）

```sh
php artisan migrate
```

执行命令生成Passport相关数据：

```sh
php artisan passport:install
```
#### Get started

在/routes/api.php文件中添加接口路由

**配置说明**

可用的配置值写在.env.example文件上，再通过/config目录下的相关文件进行加载

比如权石的相关配置值在.env文件的#iot部分的##Pstone下，再通过/config/application.php中的
devices.locks.pstone进行加载。


**一些命令**

生成一条设备分类数据：

```
php artisan db:seed --class=DeviceCategorySeeder

```

生成一条设备数据：

```
php artisan db:seed --class=DeviceSeeder
```









