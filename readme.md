# build

```bash
chmod 777 bootstrap
chmod 777 bootstrap/cache
chmod 777 storage/logs
chmod a+x storage/logs/laravel.log
chmod 777 storage/purifier
chmod 777 storage/framework/cache
chmod 777 storage/framework/sessions
chmod 777 storage/framework/views
chmod 777 public/upload -R

composer upd

./artisan admin:install
./artisan migrate
./artisan db:seed

# elsaticsearch
./artisan scout:import "App\Models\Post"
./artisan scout:import "App\Models\Tag"

# mysql
./artisan scout:mysql-index "App\Models\Post"
./artisan scout:mysql-index "App\Models\Tag"

cd public
npm i
```

# nginx
```nginx
location /stream {
    alias .../storage/app/share/file;
    add_header Content-Disposition 'inline; filename="$args"';
    internal;
}
```
