<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\FilteredBooksRequest;
use App\Services\Book\CreateBookService;
use App\Services\Book\GetBooksService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * @param  BookRequest  $bookRequest
     * @param  CreateBookService  $createBookService
     * @return JsonResponse
     */
    public function createBook(BookRequest $bookRequest, CreateBookService $createBookService):JsonResponse
    {
        $response = $createBookService->createBook($bookRequest);
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }

    /**
     * @param  FilteredBooksRequest  $filteredBooksRequest
     * @param  GetBooksService  $getBooksService
     * @return JsonResponse
     */
    public function getBooks(
        FilteredBooksRequest $filteredBooksRequest,
        GetBooksService $getBooksService
    ):JsonResponse
    {
        $response = $getBooksService->getBooks($filteredBooksRequest);

        return response()->json(
            ['message' => $response->message, 'error' => $response->error, 'data' => ['books' => $response->data]],
            $response->statusCode
        );
    }
}
