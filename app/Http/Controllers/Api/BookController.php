<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\BookResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Http\Requests\BookStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    public function index()
    {

        try{

            $this->authorize('view-any', Book::class);

            $books = Book::with('author')
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

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'books' => []
            ], 500);
        }
    }

    public function store(BookStoreRequest $request): BookResource
    {
        $this->authorize('create', Book::class);

        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('public');
        }

        $book = Book::create($validated);

        return new BookResource($book);
    }

    public function show(Request $request, Book $book): BookResource
    {
        $this->authorize('view', $book);

        return new BookResource($book);
    }

    public function update(BookUpdateRequest $request, Book $book): BookResource
    {
        $this->authorize('update', $book);

        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::delete($book->cover_image);
            }

            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('cover_image/public');
        }

        $book->update($validated);

        return new BookResource($book);
    }

    public function destroy(Request $request, Book $book): Response
    {
        $this->authorize('delete', $book);

        if ($book->cover_image) {
            Storage::delete($book->cover_image);
        }

        $book->delete();

        return response()->noContent();
    }
}
