<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Services\workprogress\WorkProgressService;
use Illuminate\Http\Request;

class HomePage extends Controller
{
  public function __construct(
      protected WorkProgressService $workProgressService
  ) {}

  public function index()
  {
    $taskCounts = $this->workProgressService->countAllByStatus();

    return view('content.pages.pages-home', compact('taskCounts'));
  }
}
