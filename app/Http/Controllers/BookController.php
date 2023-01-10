<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookRepository;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index()
    {
        return $this->bookRepository->all();
    }

    public function show($id)
    {
        return $this->bookRepository->find($id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return $this->bookRepository->create($data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return $this->bookRepository->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->bookRepository->delete($id);
    }
    public function reserve($id)
{
    $book = Book::find($id);
    if ($book->stock > 0) {
        $book->decrement('stock');
        $reservation = new Reservation();
        $reservation->user_id = auth()->user()->id;
        $reservation->book_id = $book->id;
        $reservation->reservation_date = now();
        $reservation->save();
        return redirect()->route('books.index')->with('success', 'Book reserved successfully');
    } else {
        return redirect()->route('books.index')->with('error', 'Book is not available');
    }
}
   /*  public function index()
{
    $books = Book::all();
    return response()->json($books);
}

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'description' => 'required|string',
        'stock' => 'required|integer'
    ]);
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }
    $book = new Book();
    $book->title = $request->input('title');
    $book->author = $request->input('author');
    $book->description = $request->input('description');
    $book->stock = $request->input('stock');
    $book->save();
    return response()->json(['book' => $book], 201);
} */

 public function search($title)
    {
        return Product::where('title','like','%'.$title.'%')->get();
    }
}