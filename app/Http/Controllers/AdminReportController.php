<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    public function __invoke(Request $request, ReportService $reports): View
    {
        return view('admin.reports.index', $reports->build($request));
    }
}
