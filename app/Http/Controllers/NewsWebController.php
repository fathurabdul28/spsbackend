<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsWebController extends Controller
{

    public function index()
    {
        $news = News::with('author')->latest()->paginate(15);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'slug'    => 'required|string|unique:news,slug',
            'content' => 'required',
            'image'   => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'slug', 'content']);
        $data['author_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('news.index')->with('status', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'slug'    => 'required|string|unique:news,slug,' . $news->id,
            'content' => 'required',
            'image'   => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'slug', 'content']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('news.index')->with('status', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('status', 'Berita berhasil dihapus.');
    }
}
