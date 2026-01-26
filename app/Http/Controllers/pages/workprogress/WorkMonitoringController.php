<?php

namespace App\Http\Controllers\pages\workprogress;

use App\Http\Controllers\Controller;
use App\Services\workprogress\WorkMonitoringService;
use App\Exports\GridViewExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class WorkMonitoringController extends Controller
{
    public function __construct(
        protected WorkMonitoringService $workMonitoringService
    ) {}

    public function index()
    {
        $lstWorkProgress = $this->workMonitoringService->list();
        return view('content.pages.monitoring.index', compact('lstWorkProgress'));
    }

    public function datatable(Request $request)
    {
        return $this->workMonitoringService->datatable($request);
    }

    public function exportExcel(Request $request)
    {
        $data = $this->workMonitoringService->getRawData($request);

        return Excel::download(new GridViewExport($data), 'grid-export.xlsx');
    }
}
