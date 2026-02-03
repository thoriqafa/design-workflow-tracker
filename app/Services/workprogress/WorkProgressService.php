<?php

namespace App\Services\workprogress;

use App\Helpers\Helpers;
use App\Repositories\WorkProgressRepository;
use App\Repositories\WorkProgressColorReviewRepository;
use App\Repositories\WorkProgressTextReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class WorkProgressService
{
    public function __construct(
        protected WorkProgressRepository $workProgressRepository,
        protected WorkProgressColorReviewRepository $workProgressColorReviewRepository,
        protected WorkProgressTextReviewRepository $workProgressTextReviewRepository,
    ) {}

    public function list()
    {
        return $this->workProgressRepository->getAll();
    }

    public function find(int $id)
    {
        return $this->workProgressRepository->find($id);
    }

    public function countByStatusWork(int $statusWork): int
    {
        return $this->workProgressRepository->countByStatusWork($statusWork);
    }

    public function countAllByStatus(): array
    {
        return $this->workProgressRepository->countAllByStatus();
    }

    public function datatable(Request $request)
    {
        $user = auth()->user();

        $query = $this->workProgressRepository->datatableQuery();
        $start = now()->startOfDay();
        $end   = now()->endOfDay();

        $query->whereBetween('tx_work_progress.created_at', [$start, $end]);

        // dd(
        //     $query->toSql(),
        //     $query->getBindings(),
        //     $query->limit(5)->get()
        // );


        if ($user->role === 'staff') {
            $query->where('tx_work_progress.created_by', $user->id);
        }

        $query->orderBy('tx_work_progress.id', 'DESC');

        return DataTables::of($query)
            ->addIndexColumn()

            ->filter(function ($query) use ($request) {
                // if ($request->status !== null && $request->status !== '') {
                //     $query->where('tx_work_progress.status', $request->status);
                // }

                // if ($request->tanggal !== null && $request->tanggal !== '') {
                //     $range = explode(' to ', $request->tanggal);
                //     if (count($range) === 2) {
                //         $start = Carbon::createFromFormat('Y-m-d', $range[0])->startOfDay();
                //         $end = Carbon::createFromFormat('Y-m-d', $range[1])->endOfDay();
                //         $query->whereBetween('tx_work_progress.created_at', [$start, $end]);
                //     }
                // }

                // if ($search = $request->input('search.value')) {
                //     $query->where(function ($q) use ($search) {
                //         $q->where('tx_work_progress.supplier', 'like', "%{$search}%")
                //         ->orWhere('tx_work_progress.item', 'like', "%{$search}%")
                //         ->orWhere('tx_work_progress.no_approval', 'like', "%{$search}%")
                //         ->orWhere('creator.name', 'like', "%{$search}%");
                //     });
                // }
            })

            ->addColumn('status', function ($row) {
                if ($row->start_time == null && $row->end_time == null) {
                    return '<span class="badge bg-secondary">Not Started</span>';
                } elseif ($row->start_time != null && $row->end_time == null) {
                    return '<span class="badge bg-warning">In Progress</span>';
                }

                return '<span class="badge bg-success">Finished</span>';
            })

            ->addColumn('action', function ($row) {
                $btnEdit = '
                        <button type="button" class="btn btn-sm btn-primary btn-row-edit"
                                data-id="' . $row->id . '"
                                title="Edit">
                            <i class="icon-base bx bx-edit icon-md"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-row-approval"
                                data-id="' . $row->id . '"
                                title="Approval">
                            <i class="icon-base bx bx-task icon-md"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-row-remark"
                                data-id="' . $row->id . '"
                                title="Remark">
                            <i class="icon-base bx bx-message-square-dots icon-md"></i>
                        </button>
                        ';
                if ($row->start_time == null && $row->end_time == null) {
                    return '
                    <div class="inline">
                        <button type="button"
                                class="btn btn-sm btn-success btn-row-start"
                                data-id="' . $row->id . '"
                                title="Start">
                            <i class="icon-base bx bx-play icon-md"></i>
                        </button>

                        ' . $btnEdit . '
                    </div>
                    ';
                } elseif ($row->start_time != null && $row->end_time == null) {
                    return '
                    <div class="inline">
                        <button type="button"
                                class="btn btn-sm btn-warning btn-row-finish"
                                data-id="' . $row->id . '"
                                data-start-time="' . $row->start_time . '"
                                title="Finish">
                            <i class="icon-base bx bx-check-circle icon-md"></i>
                        </button>

                        ' . $btnEdit . '
                    </div>
                    ';
                }

                return '
                <div class="inline">
                    ' . $btnEdit . '
                </div>
                ';
            })


            ->rawColumns(['status', 'action'])
            // ->rawColumns(['status'])
            ->make(true);
    }

    public function createNew(array $data)
    {
        return DB::transaction(function () use ($data) {

            $clientIp = Helpers::clientIp();
            $reqData = array_merge($data, [
                'computer_ip'       => $clientIp,
                'computer_name'     => gethostbyaddr($clientIp),
                'status_work'       => 0, //not started
                'created_by'        => auth()->user()->id
            ]);

            $workProgress = $this->workProgressRepository->create($reqData);

            return $workProgress;
        });
    }

    public function updateRequest(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $reqData = array_merge($data, [
                'updated_by' => auth()->user()->id
            ]);

            $workProgress = $this->workProgressRepository->update($id, $reqData);

            return $workProgress;

        });
    }

    public function findApprovalTextByHeaderId($headerId)
    {
        return $this->workProgressTextReviewRepository->findByHeaderId($headerId)->pluck('name')->toArray();;
    }

    public function findApprovalColorByHeaderId($headerId)
    {
        return $this->workProgressColorReviewRepository->findByHeaderId($headerId)->pluck('name')->toArray();;
    }

    public function createApproval(array $data)
    {
        return DB::transaction(function () use ($data) {
            $reqData = array_merge($data, [
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);

            $this->workProgressColorReviewRepository->deleteByHeaderId($reqData['header_id']);
            $this->workProgressTextReviewRepository->deleteByHeaderId($reqData['header_id']);

            foreach ($reqData['approval_color'] as $color) {
                $this->workProgressColorReviewRepository->create([
                    'tx_work_progress_id'   => $reqData['header_id'],
                    'name'                  => $color,
                    'created_by'            => $reqData['created_by'],
                    'updated_by'            => $reqData['updated_by']
                ]);
            }

            foreach ($reqData['approval_text'] as $text) {
                $this->workProgressTextReviewRepository->create([
                    'tx_work_progress_id'   => $reqData['header_id'],
                    'name'                  => $text,
                    'created_by'            => $reqData['created_by'],
                    'updated_by'            => $reqData['updated_by']
                ]);
            }

            return true;
        });
    }

    public function restore(int $id)
    {
        return $this->designApprovalRequestRepository->restore($id);
    }

    public function forceDelete(int $id)
    {
        return $this->designApprovalRequestRepository->forceDelete($id);
    }
}
