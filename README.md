<!-- ![Logo of the project]() -->
# Pomodoro-Timer | Toto Tomato Timer
> A pomodoro-timer webapp based on symfony 6. | This project is work in progress

This Webapp is meant as a scholar project to learn the [Symfony](https://symfony.com/doc/current/index.html) (v6) php frameworks as well as the [Pomodoro-Technique](https://en.wikipedia.org/wiki/Pomodoro_Technique) Timer 
It uses Symfony with Twig for the backend and templating parts, Webpack/Encore as package manager for Assets, Stimulus and Turbo-UX for the Javascript driven parts 

## Installing / Getting started

### Requirements

Docker / Docker Compose
: You may use the provided `docker-compose.*.yml` files for plain docker environments. They are as they are provided by the symfony project, neither edited nor tested so far

DDEV (recommended)
: "DDEV is an open source tool that makes it dead simple to get local PHP development environments up and running within minutes." DDEV is based on docker and 
yields most of the tools needed to develop this app such as php, node, npm, nvm, yarn and much more.
For further Information on setting up DDEV, please consult the [DDEV documentation](https://ddev.readthedocs.io/en/stable/users/install/) as a starting point for both [Docker](https://docs.docker.com/) installation and the [DDEV](https://ddev.readthedocs.io/en/stable/) install process. 
 
### Setup
If you set up docker, docker-compose and ddev properly for your environment / OS you are ready to go:
Make sure to read the section [Initial Configuration](#Inititial Configuration) first
```shell
mkdir /your/projects-root/my-pomodoro-timer
cd /your/projects-root/my-pomodoro-timer
git clone https://github.com/thorsten-weber/pomodoro-timer.git ./
```
This will set up a project folder as you like, make sure to replace the path accordingly to your needs.
Change your working path to the former created directory
And clone the source code to this directory,

After cloning the repo finished you are ready to run the app
YOu may or may not want to change the `.ddev/config.yaml`, The checked out version will set up your environment with php 8.1 and MySQL Database
For details on changes to this file, refer to the [config documentation](https://ddev.readthedocs.io/en/stable/users/configuration/config_yaml/) of DDEV

You may want to change the project-name (i.e. in case of conflicts). You can use `ddev config` and follow the instructions.
You must leave the later 2 options as they are, and just set a new name for your project.

```shell
ddev start
ddev composer install
ddev yarn install 
ddev php bin/console doctrine:migrations:migrate
ddev yarn dev
ddev launch 
```
The command chain above will
* start the ddev environment (and in the very first run set up the environment for the project)
* install the needed libs and dependencies for the php parts of the app
* install the node_modules for the app
* Set up the database tables as needed by symfony entities
* build the assets for frontend rendering (css, js etc.), by omitting the `dev` flag/ argument, production ready assets will be build
* launch the app into your browser

### Initial Configuration

Projects initial configuration
env-variables
: You will need to create a local `.env` file named `.env.local`. This is mandatory to get the db connection set up correctly and to make sure you are able to call the sound via the 'Freesound-API'.

```dotenv
# Override database
DATABASE_URL="mysql://db:db@ddev-<PROJECT_NAME>-db.ddev-pomodoro_default:3306/db?serverVersion=8.0&charset=utf8mb4"

FREESOUND_CLIENT_KEY="YOUR_API_KEY"
FRESSOUND_CLIENT_ID="YOUR_API_ID"
```


## Developing

To start developing on this, setup this project as shown in Installation / Getting started
start it as described, now run

```shell
ddev yarn watch
```
This will start the webpack / encore watcher process. This will rebuild assets, CSS and JS as soon as changes in files are saved
For now you need to reload the app / browser on your own, to make built changes visible.
Changes on the php backend code will take effect immediately after saving the file and reloading the app.


## Contributing
If you'd like to contribute, please fork the repository and use a feature
branch. Pull requests are warmly welcome.

Make sure your IDE / Editor knows [Editorconfig](https://editorconfig.org/)
For the `php` Code use [PSR-12](https://www.php-fig.org/psr/psr-12/)
In the JavaScript files try to keep the already existing Style, changes may be discussed. 
Linting may be introduced as a result of these discussions


## Links

- Project homepage: https://github.com/thorsten-weber/pomodoro-timer
- Repository: https://github.com/thorsten-weber/pomodoro-timer/
- Issue tracker: https://github.com/thorsten-weber/pomodoro-timer/issues
    - In case of sensitive bugs like security vulnerabilities, please contact
      thorsten.weber.rm@gmail.com directly instead of using issue tracker. We value your effort
      to improve the security and privacy of this project!


## Licensing

"The code in this project is licensed under MIT license." 
See also [License.md](License.md)
