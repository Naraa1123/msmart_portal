<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $survey = Survey::findOrFail(2);
        return view('survey', compact('survey'));
    }
}
