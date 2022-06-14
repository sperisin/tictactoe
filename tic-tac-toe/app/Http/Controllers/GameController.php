<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Field;
use Carbon\Carbon;
use Illuminate\Http\Request;


class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = [];
        // pagination
        $perPage = $request['perPage'];
        $page = $request['page'];
        // filters
        $beforeAfterDate = ($request['beforeAfter'] === 'after') ? '>' : '<';
        $startDateReq = $request['startDate'] ?? date('Y-m-d H:i:s');
        $startDate = Carbon::createFromFormat('Y-m-d', $startDateReq);
        $games = Game::where('created_at', $beforeAfterDate, $startDate);
        if ($this->checkInput($request['userId'])) {
            $games = $games->where('player1_id', $request['userId']);
            $games = $games->orWhere('player2_id', $request['userId']);
        }
        if ($this->checkInput($request['status'])) {
            $games = $games->where('status', $request['status']);
        }

        // order by and paginate
        $games = $games->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        foreach ($games as $key => $value) {
            $response[$key]['player1'] = $value->userRelationForPlayer1->username;
            $response[$key]['player2'] = $value->userRelationForPlayer2->username;
            $response[$key]['winner'] = $value->userRelationForWinner->username;
            $response[$key]['created_at'] = $value->created_at;
            $response[$key]['status'] = $value->status;
        }
        if (!is_null($response)) {
            return response()->json($response);
        } else {
            return response()->json([], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required'
        ]);
        $game = Game::create(['player1_id' => $request['userId'], 'status' => 'open']);

        return response()->json($game);
    }

    /**
     * Join game which is open.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request)
    {
        $gameToJoin = Game::where('id', $request['id'])->first();
        if ($gameToJoin->status !== 'open') {
            return response()->json('Status of the game is not \'open\'');
        } else {
            // $gameToJoin->player2_id = $request['userId'];
            // $gameToJoin->status = 'pending';
            // //$gameToJoin->save();
            // DB::table('games')->where('id', $gameToJoin->id)->update(['player2_id' => $gameToJoin->player2_id, 'status' => $gameToJoin->status]);
            Game::where('id', $gameToJoin->id)->update(['player2_id' => (int) $request['userId'], 'status' => 'pending']);
            Field::create(['game_id' => $gameToJoin->id]);
            return response()->json($gameToJoin);
        }
    }

    /**
     * Show fields for game.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function fields(Request $request)
    {
        $fields = Field::where('game_id', $request['gameId'])->first();

        return response()->json($fields);
    }

    /**
     * Play move.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $possibleFields = ['field11', 'field12', 'field13', 'field21', 'field22', 'field23', 'field31', 'field32', 'field33'];
        $fields = Field::where('game_id', $request['gameId'])->first();
        $fieldForMove = $request['field'];

        if (in_array($fieldForMove, $possibleFields)) {
            Field::where('id', $fields->id)->update([$fieldForMove => (int) $request['playerId']]);
            return response()->json($fields);
        } else {
            return response()->json('Invalid field');
        }
    }

    /**
     * Helper function to check if input is really entered.
     *
     * @param  mixed $input
     * @return bool
     */
    private function checkInput($input)
    {
        if (!isset($input) || is_null($input)) {
            return false;
        }
        return true;
    }
}
