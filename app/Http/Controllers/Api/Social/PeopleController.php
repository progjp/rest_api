<?php
/**
 * People Controller.
 */
namespace App\Http\Controllers\Api\Social;

use App\Http\Controllers\Controller;
use App\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class PeopleController
 * @package App\Http\Controllers\Api\V1
 */
class PeopleController extends Controller
{
    /**
     * Send friend request.
     *
     * @param $id
     */
    public function add($id)
    {
        /**
         * @var User $user
         */
        $user = User::findOrFail($id);
        if ($user->friends()->get()->contains($this->currentUser)) {
            throw new BadRequestHttpException('Already added as friend');
        }

        if ($user->requestsFrom()->get()->contains($this->currentUser)) {
            throw new BadRequestHttpException('Request already sent');
        }

        $user->requestsFrom()->save($this->currentUser);
    }
}
