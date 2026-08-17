<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('author:id,name')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'title'      => $item->title,
                    'slug'       => $item->slug,
                    'excerpt'    => \Str::limit(strip_tags($item->content), 150),
                    'content'    => $item->content,
                    'image'      => $item->image,
                    'image_url'  => $item->image
                        ? (str_starts_with($item->image, '/') ? 'http://localhost:8000/storage' . $item->image : 'http://localhost:8000/storage/' . $item->image)
                        : null,
                    'author'     => $item->author?->name ?? 'Sehati Peduli',
                    'created_at' => $item->created_at,
                    'date'       => $item->created_at->locale('id')->isoFormat('D MMMM YYYY'),
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $news,
        ]);
    }

    public function show($slug)
    {
        $item = News::with('author:id,name')
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => [
                'id'         => $item->id,
                'title'      => $item->title,
                'slug'       => $item->slug,
                'excerpt'    => \Str::limit(strip_tags($item->content), 150),
                'content'    => $item->content,
                'image'      => $item->image,
                'image_url'  => $item->image
                    ? (str_starts_with($item->image, '/') ? 'http://localhost:8000/storage' . $item->image : 'http://localhost:8000/storage/' . $item->image)
                    : null,
                'author'     => $item->author?->name ?? 'Sehati Peduli',
                'created_at' => $item->created_at,
                'date'       => $item->created_at->locale('id')->isoFormat('D MMMM YYYY'),
            ],
        ]);
    }
}
