<?php

namespace App\Repositories;

use App\Models\WorkProgressColorReview;

class WorkProgressColorReviewRepository
{
    public function getAll()
    {
        return WorkProgressColorReview::latest()->get();
    }

    public function find(int $id)
    {
        return WorkProgressColorReview::find($id);
    }

    public function findByHeaderId(int $id)
    {
        return WorkProgressColorReview::where('tx_work_progress_id', $id)->get();
    }

    public function create(array $data)
    {
        return WorkProgressColorReview::create($data);
    }

    public function update($id, array $data)
    {
        $request = WorkProgressColorReview::find($id);
        $request->update($data);

        return $request;
    }

    public function delete(int $id)
    {
        return WorkProgressColorReview::destroy($id);
    }

    public function deleteByHeaderId(int $id)
    {
        return WorkProgressColorReview::where('tx_work_progress_id', $id)->delete();
    }
}
