<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCollection;
use App\Models\Book;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function listBooks(Request $request){

        $search = $request->get('search', '');

        $books = Book::with('author')
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('author', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
        })
        ->whereHas('author', function ($query) {
            $query->where('status', 1);
        })
        ->latest()
        ->paginate(10);

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

    }
}
