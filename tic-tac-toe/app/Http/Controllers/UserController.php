<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::create(['username' => $request['username'], 'password' => $request['password'], 'gamesplayed' => (int) 0]);

        return response()->json($user);
    }

    /**
     * Login user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $userToLogin = User::where('username', $request->username)->first();
        if (Hash::check($request->password, $userToLogin->password)) {
            return response()->json($userToLogin);
        } else {
            return response('Login failed', 404);
        }
    }

    /**
     * Display the specified user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $user = User::where('id', $request['id'])->first();
        $noOfGamesWon = Game::where('winner', $user->id)->count();
        if ($user->gamesplayed === 0) {
            return response()->json('User has not played any games');
        }
        $winPercentage = round($noOfGamesWon / $user->gamesplayed, 4) * 100;
        $response = [
            'username' => $user->username,
            'noOfGamesPlayed' => $user->gamesplayed,
            'winPercentage' => $winPercentage
        ];

        return response()->json($response);
    }
}
