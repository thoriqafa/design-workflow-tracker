<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class GridViewExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $monthNow = Carbon::now()->format('F - Y');

        return view('content\pages\monitoring\export-view', [
            'items' => $this->data,
            'monthNow' => $monthNow
        ]);
    }
}