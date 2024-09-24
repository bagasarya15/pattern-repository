<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Interfaces\Master\UserInterface;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function index(Request $request)
    {
        return $this->userInterface->index($request);
    }

    public function store(StoreRequest $request)
    {
        return $this->userInterface->store($request);
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->userInterface->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->userInterface->destroy($id);
    }
}
