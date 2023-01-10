<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function all()
    {
        return $this->book->all();
    }

    public function find($id)
    {
        return $this->book->find($id);
    }

    public function create(array $data)
    {
        return $this->book->create($data);
    }

    public function update(array $data, $id)
    {
        $book = $this->book->find($id);
        return $book->update($data);
    }
};
