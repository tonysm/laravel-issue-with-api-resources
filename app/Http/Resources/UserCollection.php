<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function includeArticlesCount(bool $shouldInclude)
    {
        if (! $shouldInclude) return $this;

        $counts = Collection::wrap($this->collection)
            ->loadCount('articles')
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->articles_count];
            });

        return $this->additional([
            'included' => [
                'articles' => $counts,
            ],
        ]);
    }
}
