<?php

namespace App\Repositories;

use App\Models\WorkProgressTextReview;

class WorkProgressTextReviewRepository
{
    public function getAll()
    {
        return WorkProgressTextReview::latest()->get();
    }

    public function find(int $id)
    {
        return WorkProgressTextReview::find($id);
    }

    public function findByHeaderId(int $id)
    {
        return WorkProgressTextReview::where('tx_work_progress_id', $id)->get();
    }

    public function create(array $data)
    {
        return WorkProgressTextReview::create($data);
    }

    public function update($id, array $data)
    {
        $request = WorkProgressTextReview::find($id);
        $request->update($data);

        return $request;
    }

    public function delete(int $id)
    {
        return WorkProgressTextReview::destroy($id);
    }

    public function deleteByHeaderId(int $id)
    {
        return WorkProgressTextReview::where('tx_work_progress_id', $id)->delete();
    }
}
