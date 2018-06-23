<img src=".github/fans-banner.png" alt="phpwind Fans" align="center" width="100%" />
<p align="center">
<a href="https://shang.qq.com/wpa/qunwpa?idkey=4bdc6869a010f9371c81047847960e9d89ce0585e23308a4f00f99ecb27c48f7" title="加入 phpwind Fans 群"><img src="https://pub.idqqimg.com/wpa/images/group.png" alt="QQ群:30568679"></a>
<a href="https://www.codacy.com/app/shiweidu/phpwind?utm_source=github.com&utm_medium=referral&utm_content=medz/phpwind&utm_campaign=badger" title="代码质量"><img src="https://api.codacy.com/project/badge/Grade/83b5eff7e9ed4b11977207ddc2820bfb"/></a>
<a href="https://styleci.io/repos/72900085" title="StyleCI"><img src="https://styleci.io/repos/72900085/shield?branch=master" alt="StyleCI Shield"></a>
<a href="https://travis-ci.org/medz/phpwind" title="TravisCI"><img src="https://travis-ci.org/medz/phpwind.svg?branch=master"></a>
</p>

## 关于 Fans

使用 PHP 和 MySQL 开发的高性能社区系统。

> phpwind Fans 版本是原本暂定的 phpwind 10 版本而来，基于官方最新的 phpwind 9.0.1 开发，同步官方所有代码的基础上进行改良和长期维护。

## 安装 Fans

为了简化安装，目前 Fans 开发版添加了 Docker 支持，你只需要在你的电脑或者服务器上安装 `Docker` 和 `Docker Compose` 你就可以简单的完成部署：

1. 下载 2.0 的程序
2. Fans 程序下，有一份 `.env.example` 的文件，复制一份命名为 `.env` 文件 👉 [.env 配置说明](#env-配置说明)
3. 在 Fans 目录下运行 `docker-compose build`，此命令用于编译容器。
4. 在 Fans 目录下运行 `docker-compose up -d`
5. 执行 `docker-compose exec --user={你配置的 DOCKER_CONTAINER_USER}` workspace bash
6. 执行 php fans key:generate && php fans jwt:secret && php fans migrate --seed

> 好了，安装完成！！！

### `.env` 配置说明

| 配置项 | 说明 |
|:----|----|
| `APP_URL` | 你的网站地址，如果你修改了这个，那么请你也修改 `.docker/nginx/project.wen.conf` 内容 |
| `DB_HOST` | 如果使用 Docker 那么请不要修改这个值，否则连接不上数据库 |
| `DB_DOCKER_CONTAINER_[USER\|GROUP]` | 容器工作区用户和组名称
| `DOCKER_HOST_IP` | 你的宿主机 ip，正式环境推荐配置！内网 IP |
| `DOCKER_PHP_INSTALL_XDEBUG` | 是否安装 xdebug？默认安装 |
| `DOCKER_HTTP_PORT` | 对外提供的端口，默认 `8090`，正常使用应该设置为 `80` |

## 赞助捐赠

**Fans** 项目是免费开源的一个项目，个人维护需要付出很多精力，如果你喜欢 Fans 或者想鼓励维护者，请捐赠来鼓励维护者吧。

[捐赠](https://github.com/medz/phpwind/issues/265)

# License

Fans 版本包根据 Apache-2 许可证发布，请参阅完整的 [许可证文本](LICENSE)。
