#!/usr/bin/env bash
cd ..
./artisan scout:mysql-index "App\Models\Album"
./artisan scout:mysql-index "App\Models\Page"
./artisan scout:mysql-index "App\Models\Poll"
./artisan scout:mysql-index "App\Models\Post"
