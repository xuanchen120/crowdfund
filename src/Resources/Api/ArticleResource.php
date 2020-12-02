<?php

namespace App\Api\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'article_id'  => $this->id,
            'category'    => $this->category->title ?? '',
            'title'       => $this->title,
            'cover'       => $this->cover_url,
            'description' => $this->description ?? '',
            'clicks'      => $this->clicks ?? 0,
            'content'     => $this->content,
            'created_at'  => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

}
