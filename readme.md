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
./artisan scout:import "App\Models\Album"
./artisan scout:import "App\Models\Page"
./artisan scout:import "App\Models\Poll"
./artisan scout:import "App\Models\Post"

# mysql
./artisan scout:mysql-index "App\Models\Album"
./artisan scout:mysql-index "App\Models\Page"
./artisan scout:mysql-index "App\Models\Poll"
./artisan scout:mysql-index "App\Models\Post"

cd public
npm i
```

# if test
```bash
./artisan db:seed --class=TestSeeder
```
