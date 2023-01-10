<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Book;
class ReservationController extends Controller
{
    public function index()
{
    $reservations = Reservation::all();
    return response()->json($reservations);
}
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer|exists:users,id',
        'book_id' => 'required|integer|exists:books,id',
        'reservation_date' => 'required|date',
        'return_date' => 'required|date'
    ]);
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }
    $reservation = new Reservation();
    $reservation->user_id = $request->input('user_id');
    $reservation->book_id = $request->input('book_id');
    $reservation->reservation_date = $request->input('reservation_date');
    $reservation->return_date = $request->input('return_date');
    $reservation->save();
    $book = Book::find($request->input('book_id'));
    $book->stock--;
    $book->save();
    return response()->json(['reservation' => $reservation, 'book' => $book], 201);
}

}
