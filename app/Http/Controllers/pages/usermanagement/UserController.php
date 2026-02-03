<?php

namespace App\Http\Controllers\pages\usermanagement;

use App\Http\Controllers\Controller;
use App\Services\usermanagement\UserServiceService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceService $userService
    ) {}

    public function index()
    {
      return view('content.pages.usermanagement.index');
    }

    public function datatable(Request $request)
    {
        return $this->userService->datatable($request);
    }

    public function update(Request $request, int $id)
    {
        return $this->userService->update($request, $id);
    }
}
