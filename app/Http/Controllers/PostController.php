<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index')
                         ->with('success', 'Poste créé avec succès.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')
                         ->with('success', 'Poste mis à jour avec succès.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success', 'Poste supprimé avec succès.');
    }

    public function toggleStatus(Post $post)
    {
        // Basculer le statut entre "Actif" et "Inactif"
        $post->status = $post->status === 'Actif' ? 'Inactif' : 'Actif';
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Le statut du poste a été mis à jour.');
    }
}
