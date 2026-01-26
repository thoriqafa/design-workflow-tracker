<?php

namespace App\Services\workprogress;

use App\Repositories\WorkProgressRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class WorkMonitoringService
{
    public function __construct(
        protected WorkProgressRepository $workProgressRepository,
    ) {}

    public function list()
    {
        return $this->workProgressRepository->getAll();
    }

    public function find(int $id)
    {
        return $this->workProgressRepository->find($id);
    }

    public function datatable(Request $request)
    {
        $user = auth()->user();

        $query = $this->workProgressRepository->datatableQuery();

        if ($user->role === 'staff') {
            $query->where('tx_work_progress.created_by', $user->id);
        }

        $query->orderBy('tx_work_progress.id', 'ASC');

        return DataTables::of($query)
            ->addIndexColumn()

            ->filter(function ($query) use ($request) {
                if ($request->status_work !== null && $request->status_work !== '') {
                    $query->where('tx_work_progress.status_work', $request->status_work);
                }

                if ($request->tanggal !== null && $request->tanggal !== '') {
                    $range = explode(' to ', $request->tanggal);
                    if (count($range) === 2) {
                        $start = Carbon::createFromFormat('Y-m-d', $range[0])->startOfDay();
                        $end = Carbon::createFromFormat('Y-m-d', $range[1])->endOfDay();
                        $query->whereBetween('tx_work_progress.created_at', [$start, $end]);
                    }
                }

                if ($search = $request->input('search.value')) {
                    $query->where(function ($q) use ($search) {
                        $q->where('tx_work_progress.supplier', 'like', "%{$search}%")
                        ->orWhere('tx_work_progress.item', 'like', "%{$search}%")
                        ->orWhere('tx_work_progress.no_approval', 'like', "%{$search}%")
                        ->orWhere('creator.name', 'like', "%{$search}%");
                    });
                }
            })

            ->addColumn('status', function ($row) {
                if ($row->status_work == 0) {
                    return '<span class="badge bg-secondary">Not Started</span>';
                } elseif ($row->status_work == 1) {
                    return '<span class="badge bg-warning">In Progress</span>';
                } else {
                    return '<span class="badge bg-success">Finished</span>';
                }
            })


            ->rawColumns(['status'])
            ->make(true);
    }

    public function getRawData(Request $request)
    {
        $user = auth()->user();

        // Ambil query dasar dari repository
        $query = $this->workProgressRepository->datatableQuery();

        // Terapkan batasan role (staff hanya lihat milik sendiri)
        if ($user->role === 'staff') {
            $query->where('tx_work_progress.created_by', $user->id);
        }

        // Ambil parameter DataTables
        $search = $request->input('search.value') ?? $request->input('search');
        $start = (int) ($request->input('start') ?? 0);
        $length = (int) ($request->input('length') ?? 10);

        // Terapkan pencarian global (sesuai kolom yang bisa di-search)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tx_work_progress.supplier', 'like', "%{$search}%")
                ->orWhere('tx_work_progress.item', 'like', "%{$search}%")
                ->orWhere('tx_work_progress.no_approval', 'like', "%{$search}%")
                ->orWhere('creator.name', 'like', "%{$search}%");
            });
        }

        // Ambil hanya data yang sesuai dengan halaman saat ini
        return $query->get();
        // return $query->skip($start)->take($length)->get();
    }
}