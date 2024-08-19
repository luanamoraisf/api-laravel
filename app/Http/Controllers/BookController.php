<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {        
        $dataLimit = $request->validate([
                'title' => 'required|max:150',
                'author' => 'required|max:100',
                'summary' => 'required|max:255',
            ]); 


        $book = new Book();
        $book->title = $dataLimit['title'];
        $book->author = $dataLimit['author'];
        $book->summary = $dataLimit['summary'];
        $book->gender = $request->gender;
        $book->release_year = $request->release_year;
        
        $book->save();

        return response()->json(['message' => 'Livro cadastrado!'], 200);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
