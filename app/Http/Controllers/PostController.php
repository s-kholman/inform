<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrudOneRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    private const TITLE = [
        'title' => 'Справочник - Должности',
        'label' => 'Введите наименование должности',
        'route' => 'post'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $value = Post::orderby('name')->get();

        return view('crud.one_index', ['const' => self::TITLE, 'value'=>$value]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrudOneRequest $request)
    {
        $validated = $request->validated();
        Post::create([
            'name' => $validated['name']
        ]);

        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('crud.one_edit', ['const' => self::TITLE, 'value'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CrudOneRequest $request, Post $post)
    {
        $validated = $request->validated();
        $post->update(['name' => $validated['name']]);
        return redirect()->route(self::TITLE['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route(self::TITLE['route'].'.index');
    }
}
