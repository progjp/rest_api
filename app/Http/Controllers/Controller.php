<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @var User
     */
    protected $currentUser;

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (Auth::guest()) {
            \Auth::login(User::first());
        }

        $this->currentUser = \Auth::user();
    }
}
