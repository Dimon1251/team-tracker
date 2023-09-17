<div align="center">
<img src="https://avatars1.githubusercontent.com/u/33844443" height="100px" alt="CorpSoft Logo">
    <h1 align="center">README e2web</h1>
</div>

### Installing using Docker


> You need to have [docker](http://www.docker.com) (1.17.0+) and
[docker-compose](https://docs.docker.com/compose/install/) (1.14.0+) installed.

## You can install the application using the following commands:

### Firstly you need to clone the project and do some basic setup of the .env file:

```sh
git clone git@github.com:Dimon1251/team-tracker.git
cd team-tracker
cp .env.example .env
```

### You need to configure the env and change the variables in the values below, with ports in the range 49152 to 65535:
```sh
APP_SERVICE=web
APP_PORT=50000 # port on which the project will be available locally
FORWARD_DB_PORT=50001
FORWARD_REDIS_PORT=50002
FORWARD_MEILISEARCH_PORT=50003
FORWARD_MAILHOG_PORT=50004
FORWARD_MAILHOG_DASHBOARD_PORT=50005
VITE_PORT=50006
```

> In `.env` file your need to set your HOST_UID=****.
> You can get your UID by the following command in the terminal: `id -u <username>`


### Second you need install Sail using the Composer package manager and after configuring a shell alias using the following command:
_If your existing local development environment allows you to install Composer dependencies_
```sh
composer require laravel/sail --dev
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

_Alias sail only available in the terminal where you entered them_
<br>
_Once the shell alias has been configured, you may execute Sail commands._
<br>
_You can add alias global to phpstorm terminal or other terminal_


### To start all of the Docker containers in the background, you may start Sail in "detached" mode:

```sh
sail up -d
```
_It may take some time to download the required images._

_To stop all of the containers run:_  `sail stop`

### When done, you need to execute the following commands:

```sh
sail composer install
sail artisan key:generate
sail artisan migrate
sail artisan db:seed
sail artisan storage:link
sail npm install
sail npm run dev
sail artisan queue:work
```

#### After this steps, you can access your app from [http://localhost:xxxxx](http://localhost:xxxxx).
