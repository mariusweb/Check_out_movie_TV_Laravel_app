# Movie app



## Starting
Open movie_tv_app2 in terminal and write
```bash
cd app
composer install
npm install
npm run dev
```
### ENV
Copy exemple.env to .env
in .env add TMDB_TOKEN= from [TMDB](https://www.themoviedb.org/documentation/api)
You will have to create account in [TMDB](https://www.themoviedb.org/documentation/api)

### Docker
Open movie_tv_app2 in terminal and write
```bash
docker compose up -d --build
docker exec -it movie_tv_app2_web_1 bash
php artisna storage:link
php artisna scheduale:work
```

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
