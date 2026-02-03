<?php

namespace App\Services\usermanagement;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserServiceService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    public function list()
    {
        return $this->userRepository->findAll();
    }

    public function find(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function datatable(Request $request)
    {

        $query = $this->userRepository->datatableQuery();

        $query->orderBy('name', 'ASC');

        return DataTables::of($query)
            ->addIndexColumn()

            ->filter(function ($query) use ($request) {

                if ($search = $request->input('search.value')) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                    });
                }
            })

            ->addColumn('action', function ($row) {
              $btnEdit = '
                      <button type="button" class="btn btn-sm btn-primary btn-row-edit"
                              data-id="' . $row->id . '"
                              title="Edit">
                          <i class="icon-base bx bx-edit icon-md"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-warning btn-row-reset-password"
                              data-id="' . $row->id . '"
                              title="Reset Password">
                          <i class="icon-base bx bx-key icon-md"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-danger btn-row-delete"
                              data-id="' . $row->id . '"
                              title="Delete">
                          <i class="icon-base bx bx-trash icon-md"></i>
                      </button>
                      ';

              return '
              <div class="inline">
                  ' . $btnEdit . '
              </div>
              ';
            })


            ->rawColumns(['action'])

            ->make(true);
    }

    public function update(array $data, int $id)
    {
        $reqData = array_merge($data, [
            'updated_at' => now(),
        ]);

        $user = $this->userRepository->update($id, $reqData);
        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->userRepository->delete($id);
        return $user;
    }

}
