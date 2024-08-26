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
        $book = Book::orderBy('created_at', 'asc')->paginate(10);
        return response()->json($book);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $dataLimit = $request->validate([
                'title' => 'required|max:150',
                'author' => 'required|max:100',
                'summary' => 'required|max:500',
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
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book->only(['title', 'author', 'summary', 'gender', 'release_year']));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id)->update([
            'title' => $request->title,
            'author' => $request->author,
            'summary' => $request->summary,
            'gender' => $request->gender,
            'release_year' => $request->release_year
        ]);
        return response()->json(['message' => 'Livro Editado!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Book::find($id)->delete();
        return response()->json(['message' => 'Livro excluído!']);
    }
}
