<?php

namespace App\Http\Controllers\pages\workprogress;

use App\Http\Controllers\Controller;
use App\Services\workprogress\WorkProgressService;
use Illuminate\Http\Request;

class WorkProgressController extends Controller
{
    public function __construct(
        protected WorkProgressService $workProgressService
    ) {}

    public function index()
    {
        $lstWorkProgress = $this->workProgressService->list();
        return view('content.pages.workprogress.index', compact('lstWorkProgress'));
    }

    public function datatable(Request $request)
    {
        return $this->workProgressService->datatable($request);
    }

    public function show(int $id)
    {
        $data = $this->workProgressService->find($id);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item'  => 'required|string|max:50'
        ]);

        $data = $this->workProgressService->createNew($request, $request->all());

        return response()->json([
            'message' => 'Task berhasil dibuat',
            'data' => $data
        ]);
    }

    public function update(Request $request, int $id)
    {
        // $request->validate([
        //     'remarks'  => 'required|string'
        // ]);

        $this->workProgressService->updateRequest($id, $request->all());

        return response()->json([
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function editApproval($headerId)
    {
        $texts = $this->workProgressService->findApprovalTextByHeaderId($headerId); 
        $colors = $this->workProgressService->findApprovalColorByHeaderId($headerId); 

        return response()->json([
            'status' => 'success',
            'data' => [
                'approval_text' => $texts,
                'approval_color' => $colors
            ]
        ]);
    }

    public function storeApproval(Request $request)
    {
        $request->validate([
            'header_id' => 'required|integer',
            'approval_text' => 'required|array',
            'approval_text.*.approval_text' => 'required|string|max:255',
            'approval_color' => 'required|array',
            'approval_color.*.approval_color' => 'required|string|max:50',
        ]);

        $data = [
            'header_id' => $request->header_id,
            'approval_text' => collect($request->approval_text)
                ->pluck('approval_text')
                ->toArray(),

            'approval_color' => collect($request->approval_color)
                ->pluck('approval_color')
                ->toArray(),
        ];

        try {
            $this->workProgressService->createApproval($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Approval berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    function restore(int $id)
    {
        $this->workProgressService->restoreRequest($id);

        return redirect()
            ->route('content.pages.workprogress.index')
            ->with('success', 'Data berhasil dikembalikan.');
    }

    function delete(int $id)
    {
        $this->workProgressService->deleteRequest($id);

        return redirect()
            ->route('content.pages.workprogress.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
