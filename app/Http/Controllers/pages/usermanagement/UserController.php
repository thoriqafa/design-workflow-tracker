<?php

namespace App\Http\Controllers\pages\usermanagement;

use App\Http\Controllers\Controller;
use App\Services\usermanagement\UserServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function show(int $id)
    {
        $data = $this->userService->find($id);

        return response()->json($data);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:50',
        ]);

        $user = $this->userService->update($request->all(), $id);

        return redirect()
                ->route('usermanagement.index')
                ->with('success', 'User berhasil diupdate.');
    }

    public function resetPassword(int $id)
    {
        $user = $this->userService->update([
            'password' => Hash::make('bmi123456'),
        ], $id);
        return redirect()
                ->route('usermanagement.index')
                ->with('success', 'Password berhasil direset ke "bmi123456".');
    }

    public function destroy(int $id)
    {
        $this->userService->delete($id);
        return redirect()
                ->route('usermanagement.index')
                ->with('success', 'User berhasil dihapus.');
    }
}
