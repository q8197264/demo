oauth2-server-php
=================

[![Build Status](https://travis-ci.org/bshaffer/oauth2-server-php.svg?branch=develop)](https://travis-ci.org/bshaffer/oauth2-server-php)

[![Total Downloads](https://poser.pugx.org/bshaffer/oauth2-server-php/downloads.png)](https://packagist.org/packages/bshaffer/oauth2-server-php)

View the [complete documentation](http://bshaffer.github.io/oauth2-server-php-docs/)

一、接口框架目录结构 --样例

      |-common                  公共目录函数
      |   |---common.func.php   公共函数:如有添加，函数名前必加接口前缀，防与其它接口内函数重名：例如：function DemoXxx(){...}
      |
src-  |-config                  配置文件目录
      |   |---config.php        默认配置文件：配置一些目录常量与 默认加载的公共函数文件
      |
      |-core                    框架核心文件
      |    |---autload.php      自动加载类:可配置实例化一个目录下的类时，自动加载的目录，开发人员可通过配置$root_dir数组元素，自行添加需自动加载类文件的目录
      |    |---router.php       url路由
      |-------------------------------------- 以上目录无须改动  ------------------------------------
      |-db                              数据库连接
      |   |---DemoDB.php   【须改名】        数据库驱动（必须加接口前缀，防止多接口调用时重名）：含mysql ,redis ,继承此类即可使用，与CI框架兼容
      |
      |
      |-Exception                       错误异常类 (非必要)
      |   |---DemoException【须改名】        错误异常类:封装了日志写入，并且加上了错误文件与行数的提示
      |
      |-lib                             样例：业务逻辑目录 : 放入开发人员自行开发的功能,例如一些业务处理
      |   |---DemoCore.php 【须改名】         实现业务封装的直接处理类(可多个，如增删改查业务分别存一个文件)：实现业务逻辑处理，须继承或调用DemoData类
      |   |---DemoData.php 【须改名】         可直接继承DemoDB类，操作数据库：负责sql的执行（数据库的CURD）不建议进行任何判断与逻辑
      |
      |
      |-sy_demo.php        【须改名】    入口文件：外部访问的接口