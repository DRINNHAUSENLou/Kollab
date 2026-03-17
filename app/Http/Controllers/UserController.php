<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }

    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $projetId = $request->get('projet_id');

        $query = \App\Models\User::query()
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
            });

        if ($projetId) {
            $membreIds = \App\Models\MembreProjet::where('id_projet', $projetId)
                ->pluck('id_utilisateur')
                ->toArray();
            $query->whereNotIn('id', $membreIds);
        }

        $users = $query->limit(10)->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
