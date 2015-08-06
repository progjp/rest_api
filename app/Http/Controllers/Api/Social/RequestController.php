<?php
/**
 * Request Controller.
 */
namespace App\Http\Controllers\Api\Social;

use App\Http\Controllers\Controller;
use App\User;

/**
 * Class RequestController
 * @package App\Http\Controllers\Api\V1
 */
class RequestController extends Controller
{
    /**
     * Index action.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->currentUser->requestsFrom()->get());
    }

    /**
     * Confirm action.
     *
     * @param $id
     */
    public function confirm($id)
    {
        $user = User::findOrFail($id);
        $this->currentUser->requestsFrom()->detach($user);
        $this->currentUser->friends()->save($user);
    }

    /**
     * Reject action.
     *
     * @param $id
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $this->currentUser->requestsFrom()->detach($user);
    }
}
