<?php
/**
 * Connection Controller.
 */
namespace App\Http\Controllers\Api\Social;

use App\Http\Controllers\Controller;

/**
 * Class ConnectionController
 * @package App\Http\Controllers\Api\V1
 */
class ConnectionController extends Controller
{
    /**
     * Index action.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->currentUser->friendsOfFriends(\Input::get('level', 1)));
    }
}
