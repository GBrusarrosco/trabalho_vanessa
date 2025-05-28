<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $forms = Form::with(['questions.answers.student.user'])->get();
        return view('report.index', compact('forms'));
    }
}

