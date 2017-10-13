#!/usr/bin/env bash
cd ..
./artisan scout:import "App\Models\Album"
./artisan scout:import "App\Models\Page"
./artisan scout:import "App\Models\Poll"
./artisan scout:import "App\Models\Post"
