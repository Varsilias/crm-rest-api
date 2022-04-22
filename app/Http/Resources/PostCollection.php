<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Post;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "posts" => $this->collection,
            "metadata" => [
                "current_page" => $request->query('page') === null ? 1 : (int) $request->query('page'),
                "from" => 1,
                "to" => (round(Post::count() / 10) + 1),
                "current_url" => $request->query('page') === null ? $request->url() : "{$request->url()}?=page{$request->query('page')}",
                "base_url" => $request->url(),
                "per_page" => 10,
                "total" => Post::count()
            ],         
        ];
    }

    
}



// "links": {
//     "first": "http://localhost:8000/api/v1/posts?page=1",
//     "last": "http://localhost:8000/api/v1/posts?page=4",
//     "prev": null,
//     "next": "http://localhost:8000/api/v1/posts?page=2"
// },
// "meta": {
//     "current_page": 1,
//     "from": 1,
//     "last_page": 4,
//     "links": [
//         {
//             "url": null,
//             "label": "&laquo; Previous",
//             "active": false
//         },
//         {
//             "url": "http://localhost:8000/api/v1/posts?page=1",
//             "label": "1",
//             "active": true
//         },
//         {
//             "url": "http://localhost:8000/api/v1/posts?page=2",
//             "label": "2",
//             "active": false
//         },
//         {
//             "url": "http://localhost:8000/api/v1/posts?page=3",
//             "label": "3",
//             "active": false
//         },
//         {
//             "url": "http://localhost:8000/api/v1/posts?page=4",
//             "label": "4",
//             "active": false
//         },
//         {
//             "url": "http://localhost:8000/api/v1/posts?page=2",
//             "label": "Next &raquo;",
//             "active": false
//         }
//     ],
//     "path": "http://localhost:8000/api/v1/posts",
//     "per_page": 10,
//     "to": 10,
//     "total": 33