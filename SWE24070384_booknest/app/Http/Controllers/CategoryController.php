<?php
/**
 * Student Name : Najmi
 * Student ID   : SWE24070384
 */

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->orderBy('id')->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $books = $category->books()->orderBy('id')->get();

        return view('categories.show', compact('category', 'books'));
    }
}
