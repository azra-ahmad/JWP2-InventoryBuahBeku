<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicReportController extends Controller
{
    public function __invoke(Request $request, ReportService $reports): View
    {
        return view('public.reports', $reports->build($request));
    }
}
