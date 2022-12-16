<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        $currentPage = intval($request->page);
        $paginator   = User::paginate(columns: ['id']);

        $redirectToPage = match (true) {
            $currentPage < 1                      => 1,
            $currentPage > $paginator->lastPage() => $paginator->lastPage(),
            default                               => $currentPage,
        };

        return redirect()->route('users.index', ['page' => $redirectToPage]);
    }
}
