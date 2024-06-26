<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h1 align="center" style="font-weight: bold;">SaveurKid 💻</h1>

<p align="center">
<a href="#technologies">Technologies</a>
<a href="#getting-started">Getting Started</a>
<a href="#api-endpoints">API Endpoints</a>
<a href="#collaborators">Collaborators</a>
<a href="#contribute">Contribute</a> 
</p>

<p align="center">Simple description of what your project does or how to use it.</p>

<p align="center">
<a href="https://github.com/Ahmadhamd-i/master">📱 Visit this Project</a>
</p>
 
<h2 id="technologies">💻 Technologies</h2>

- Laravel
- PHP
- MySQL
- Composer
- PHPUnit
- Docker (optional)

<h2 id="getting-started">🚀 Getting Started</h2>

Here you describe how to run your project locally.

<h3>Prerequisites</h3>

Here you list all prerequisites necessary for running your project. For example:

- [PHP 7.4+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [NodeJS](https://nodejs.org/)
- [Git](https://git-scm.com/)

<h3>Cloning</h3>

How to clone your project

```bash
git clone https://github.com/Ahmadhamd-i/master
```

<h3>Config .env variables</h3>

Use the `.env.example` as a reference to create your configuration file `.env` with your database credentials and other necessary configurations.

```ini
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

<h3>Installing Dependencies</h3>

Install the PHP dependencies using Composer:

```bash
cd master
composer install
```

Install the Node.js dependencies using npm:

```bash
npm install
```

<h3>Starting</h3>

How to start your project

```bash
php artisan migrate
php artisan serve
```

<h2 id="api-endpoints">📍 API Endpoints</h2>

Here you can list the main routes of your API, and what are their expected request bodies.

| Route               | Description                                          
|----------------------|-----------------------------------------------------
| <kbd>GET /api/users</kbd>     | Retrieves user info. See [response details](#get-users-detail)
| <kbd>POST /api/authenticate</kbd>     | Authenticates user into the API. See [request details](#post-auth-detail)

<h3 id="get-users-detail">GET /api/users</h3>

**RESPONSE**
```json
{
  "id": 1,
  "name": "Ahmad Hamdy",
  "email": "ahmad@example.com"
}
```

<h3 id="post-auth-detail">POST /api/authenticate</h3>

**REQUEST**
```json
{
  "email": "ahmad@example.com",
  "password": "password"
}
```

**RESPONSE**
```json
{
  "token": "OwoMRHsaQwyAgVoc3OXmL1JhMVUYXGGBbCTK0GBgiYitwQwjf0gVoBmkbuyy0pSi"
}
```

<h3>API Documentation</h3>

For detailed API documentation, visit the links below:

- [Web API Documentation](https://documenter.getpostman.com/view/34327794/2sA3Bt29ir)
- [Parent App API Documentation](https://documenter.getpostman.com/view/34651516/2sA3XTf1JE)
- [Supervisor App API Documentation](https://documenter.getpostman.com/view/29147808/2sA3XTf1JF)

<h2 id="collaborators">🤝 Collaborators</h2>

<p>Special thank you to all the people who contributed to this project.</p>
<table>
<tr>
<td align="center">
<a href="https://github.com/Ahmadhamd-i">
<img src="https://avatars.githubusercontent.com/u/152027176?v=4" width="100px;" alt="Ahmad Hamdy Profile Picture"/><br>
<sub>
<b>Ahmad Hamdy</b>
</sub>
</a>
</td>
</tr>
</table>
 
<h2 id="contribute">📫 Contribute</h2>

Here you will explain how other developers can contribute to your project. For example, explaining how to create their branches, which patterns to follow, and how to open a pull request.

1. `git clone https://github.com/Ahmadhamd-i/master.git`
2. `git checkout -b feature/NAME`
3. Follow commit patterns
4. Open a Pull Request explaining the problem solved or feature made, if exists, append screenshot of visual modifications and wait for the review!

<h3>Documentations that might help</h3>

[📝 How to create a Pull Request](https://www.atlassian.com/br/git/tutorials/making-a-pull-request)

[💾 Commit pattern](https://gist.github.com/joshbuchea/6f47e86d2510bce28f8e7f42ae84c716)
```





## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
#   G _ P - S a v e - Y o u r - K i d 
 
 
