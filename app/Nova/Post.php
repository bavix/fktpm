<?php

namespace App\Nova;

use App\Nova\Actions\AccountToBlacklist;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;

class Post extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'description',
        'content',
        'user_name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            \Laravel\Nova\Fields\Image::make('Image', 'Image.path'),

            BelongsTo::make('Category'),

            Text::make('Title')
                ->required()
                ->rules('max:255'),

            Text::make('Description')
                ->hideFromIndex()
                ->required()
                ->rules('max:600'),

            Markdown::make('Content')
                ->required(),

            Boolean::make('Active'),

            Text::make('Instagram Code')
                ->required()
                ->rules('max:255'),

            Text::make('User Name')
                ->rules('max:255'),

            DateTime::make('Created At')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->readonly(true),

            DateTime::make('Updated At')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->readonly(true),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [new AccountToBlacklist()];
    }

}
