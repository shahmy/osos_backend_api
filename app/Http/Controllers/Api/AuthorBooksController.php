<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorBookStoreRequest;
use App\Http\Resources\BookCollection;

class AuthorBooksController extends Controller
{
    public function index(Request $request, Author $author)
    {

        try {

            $this->authorize('view', $author);

            $books = $author
            ->books()
            ->latest()
            ->paginate();
        
            if($books->isEmpty()){
                return response()->json([
                    'message' => 'No books found',
                    'books' => []
                ], 404);
            }

            return response()->json([
                'message' => 'success',
                'books' => new BookCollection($books)
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'You are not authorized to view any books',
                'books' => []
            ], 403);
        }
        
    }

    public function store(Request $request, Author $author)
    {

        try{

            $this->authorize('create', Book::class);

            $validated = $request->validate([
                'isbn' => ['nullable', 'string'],
                'title' => ['required', 'max:255', 'string'],
                'description' => ['nullable', 'string'],
                'price' => ['nullable', 'numeric'],
                'cover_image' => ['image', 'max:1024', 'nullable'],
            ]);

            if ($request->hasFile('cover_image')) {

                $validated['cover_image'] = $request
                    ->file('cover_image')
                    ->store('cover_image/public');
                    $image = "data:image/png;base64,".base64_encode(file_get_contents($request->file('cover_image')->path()));
                    $validated['cover_image'] = $image;
            }

    //$validated['cover_image'] = base64_encode(file_get_contents($request->file('cover_image')->pat‌​h()));

            
            $book = $author->books()->create($validated);

            return response()->json([
                'message' => 'Book created successfully',
                'book' => new BookResource($book)
            ], 201);


        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'books' => []
            ], 500);
        }
    }
}
