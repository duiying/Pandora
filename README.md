<h1 align="center"> Pandora </h1>
<p align="center">自定义的组件化PHP框架</p>


### 框架目录
```
Pandora
|----app                                应用目录
|--------console                        后台应用目录
|--------web                            WEB应用目录
|------------controllers                控制器目录
|------------models                     模型类目录
|----config                             配置文件目录
|--------config.php                     框架配置文件
|----framework                          框架核心目录
|--------base                           框架基础目录
|------------Application.php            基础应用类
|------------Component.php              基础组件类
|------------Controller.php             基础控制器
|------------Model.php                  基础模型类
|--------component                      组件目录
|--------console                        框架后台目录
|--------web                            框架WEB目录
|------------Application.php            WEB应用类
|------------Controller.php             WEB控制器
|--------Pandora.php                    框架核心类
|----public                             框架入口目录
|--------web                            WEB入口目录
|----runtime                            runtime
|--------cache                          缓存文件目录
|------------index.php                  入口文件
```

### 安装
安装
```bash
git clone git@github.com:duiying/Pandora.git
cd Pandora
composer update
```
数据库配置 config/config.php
```sql
-- 新建数据库
CREATE DATABASE IF NOT EXISTS `pandora`;

-- 选择数据库
USE `pandora`;

-- 新建测试数据表
CREATE TABLE IF NOT EXISTS `user` (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    age INT(11),
    PRIMARY KEY(id)
);

-- 插入测试数据
INSERT INTO `user` (name, age) VALUES('duiying', 23), ('wangyaxian', 23);
```

### 规范
目录规范
```
1. web目录存放WEB相关代码，console目录存放后台脚本相关代码
```
代码规范
```
1. 变量名采用驼峰式命名方式
2. 类名首字母大写
```

### 执行流程分析
WEB
```
1. 入口文件：public/web/index.php。
2. index.php中执行\pandora\web\Application中的run方法，\pandora\web\Application继承\pandora\base\Application。
3. \pandora\base\Application中的run方法首先初始化框架核心类(读取配置)，然后调用handle方法处理请求。
4. \pandora\web\Application中的handle方法分发路由。
```

### 如何引入并使用组件
```
1. 在config/config.php文件中定义了组件信息，包括组件的类名和属性。
2. 使用Pandora::component('组件名称')的方式使用组件，此时\pandora\Pandora.php中的component方法会读取组件信息并返回组件的对象。
```

### ORM的实现思路
```
1. 基础模型类：\pandora\base\Model.php，自定义的模型类比如\app\web\models\User.php继承基础模型类。
2. 通过PDO查出相关记录，并通过基础模型类下的arr2Model方法转为Model。
```



