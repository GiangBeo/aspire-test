<?php

namespace App\Http\Controllers;

use App\Component\UserComponent;
use App\Http\Requests\CreateUser;

class UserController extends Controller
{
    /**
     * @var UserComponent
     */
    private $userComponent;

    /**
     * @param  UserComponent $userComponent
     */
    public function __construct(
        UserComponent $userComponent
    )
    {
        $this->userComponent = $userComponent;
    }

    public function createUser(CreateUser $request)
    {

        $this->userComponent->createUser(
            $request->input('email'),
            $request->input('password'),
            $request->input("name")
        );
        return response()->json(['success' => 'Success'], 200);
    }
}
