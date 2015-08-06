<?php
/**
 * Friend Controller.
 */
namespace App\Http\Controllers\Api\Social;

use App\Http\Controllers\Controller;

/**
 * Class FriendController
 * @package App\Http\Controllers\Api\Social
 */
class FriendController extends Controller
{
    /**
     * Index action.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->currentUser->friends()->get());
    }
}
