<?php

namespace App\Services;

class SeoService
{

    /**
     * @param string|\Illuminate\Database\Eloquent\Model $content
     * @param bool $toArray
     *
     * @return string|array
     */
    public function keywords($content = null, $toArray = false)
    {
        if (is_object($content) && \method_exists($content, 'tags')) {
            $mixed = [];
            foreach ($content->tags as $tag) {
                $mixed[] = $tag->name;
            }
        } else {
            $trim = trim($content);
            $data = preg_replace('~[^а-яё\w/]+~ui', ',', $trim);
            $mixed = explode(',', $data);
            $mixed = array_filter($mixed, static function ($str) {
                return strlen($str) > 1;
            });
        }

        $data = array_unique($mixed);

        if ($toArray) {
            return $data;
        }

        return implode(', ', $data);
    }

}
