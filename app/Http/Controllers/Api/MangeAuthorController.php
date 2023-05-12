<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MangeAuthorController extends Controller
{
    public function changeAuthorStatus($id, Request $request)
    {
        $this->authorize('view-any', Author::class);

        $author = Author::find($id);
        $author->status = $request->status;
        $author->save();
        return response()->json(
            ['success' => 'Status change successfully.'
        ],200);
    }
}
