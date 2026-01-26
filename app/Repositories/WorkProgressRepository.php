<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\WorkProgress;

class WorkProgressRepository
{
    public function getAll()
    {
        return WorkProgress::latest()->get();
    }

    public function find(int $id)
    {
        return WorkProgress::findOrFail($id);
    }

    public function countByStatusWork(int $statusWork): int
    {
        return WorkProgress::where('status_work', $statusWork)->count();
    }

    // Jika mau sekaligus semua status:
    public function countAllByStatus(): array
  {
      $user =auth()->user();

      $query = WorkProgress::query();

      if ($user->role === 'staff') {
          $query->where('created_by', $user->id);
      }

      $counts = $query->selectRaw('status_work, COUNT(*) as total')
          ->groupBy('status_work')
          ->pluck('total','status_work')
          ->toArray();

      $counts['all'] = array_sum($counts);

      return $counts;
  }

    public function datatableQuery()
    {
        // $user = Auth::user();

        $query = WorkProgress::query()
            // ->leftJoin('tx_work_progress_color_reviews as wp_color', function ($join) {
            //     $join->on(
            //         'wp_color.tx_work_progress_id',
            //         '=',
            //         'tx_work_progress.id'
            //     );
            ->leftJoin(DB::raw('
                (
                SELECT
                    tx_work_progress_id,
                    GROUP_CONCAT(name ORDER BY id ASC SEPARATOR "||") AS color_review,
                    MAX(created_at) as color_created_at
                FROM tx_work_progress_color_reviews
                GROUP BY tx_work_progress_id
                ) AS wp_color
            '), 'wp_color.tx_work_progress_id', '=', 'tx_work_progress.id')

            ->leftJoin(DB::raw('
                (
                SELECT
                    tx_work_progress_id,
                    GROUP_CONCAT(name ORDER BY id ASC SEPARATOR "||") AS text_review,
                    MAX(created_at) as text_created_at
                FROM tx_work_progress_text_reviews
                GROUP BY tx_work_progress_id
                ) AS wp_text
            '), 'wp_text.tx_work_progress_id', '=', 'tx_work_progress.id')
            ->leftJoin('tx_users as creator', 'creator.id', '=', 'tx_work_progress.created_by')
            ->select([
                'tx_work_progress.id',
                'tx_work_progress.supplier',
                'tx_work_progress.item',
                'tx_work_progress.no_approval',
                'tx_work_progress.email_received_at',
                'tx_work_progress.start_time',
                'tx_work_progress.end_time',
                'tx_work_progress.status_work',
                'tx_work_progress.duration',
                'tx_work_progress.remarks',
                'tx_work_progress.created_at',
                'creator.name as creator_name',
                'wp_color.color_review',
                'wp_text.text_review',
                'wp_color.color_created_at',
                'wp_text.text_created_at'
                // 'wp_color.created_at as color_created_at'
            ])
            ->groupBy([
                'tx_work_progress.id',
                'tx_work_progress.supplier',
                'tx_work_progress.item',
                'tx_work_progress.no_approval',
                'tx_work_progress.email_received_at',
                'tx_work_progress.start_time',
                'tx_work_progress.end_time',
                'tx_work_progress.duration',
                'tx_work_progress.remarks',
                'tx_work_progress.created_at',
                'creator.name',
                'wp_color.color_review',
                'wp_text.text_review',
                'wp_color.color_created_at',
                'wp_text.text_created_at'
            ]);
            // ->orderBy('tx_work_progress.id', 'DESC');

        // Superadmin → lihat semua
        // if ($user->hasRole('superadmin')) {
        //     return $query;
        // }

        // Manager → lihat per divisi
        // if ($user->hasRole('manager')) {
        //     return $query->where(
        //         'tx_design_approval_requests.division_id',
        //         $user->division_id
        //     );
        // }

        // Requester → lihat milik sendiri
        // return $query->where(
        //     'tx_work_progress.created_by',
        //     $user->id
        // );
        return $query;
    }

    public function create(array $data)
    {
        return WorkProgress::create($data);
    }

    public function update($id, array $data)
    {
        $request = WorkProgress::findOrFail($id);
        $request->update($data);

        return $request;
    }
}
