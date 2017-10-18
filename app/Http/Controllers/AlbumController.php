<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends PostController
{

    protected $model       = Album::class;
    protected $withModel   = ['image', 'tagged'];
    protected $isCategory  = false;
    protected $route       = 'album';
    protected $title       = 'blocks.albums';
    protected $description = 'blocks.listAlbums';

}
