<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradingTopic;
use Illuminate\Http\Request;

class GradingTopicController extends Controller
{

    public function index()
    {
        $topics = GradingTopic::all();

        return view('admin.grading_topic.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.grading_topic.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'topic' => 'required|string',
            'department' => 'required|string',
        ]);

        GradingTopic::create([
            'topic' => $validatedData['topic'],
            'department' => $validatedData['department'],
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.grading-topic')->with('success', 'Grading Topic created successfully.');
    }

    public function edit($id)
    {
        $topic_id = decrypt($id);

        $topic = GradingTopic::query()->find($topic_id);

        return view('admin.grading_topic.edit', compact('topic'));
    }

    public function update(Request $request, $id)
    {
        $topic_id = decrypt($id);

        $grading_topic = GradingTopic::query()->find($topic_id);

        $validatedData = $request->validate([
            'topic' => 'required|string',
            'department' => 'required|string',
        ]);

        $grading_topic->update([
            'topic' => $validatedData['topic'],
            'department' => $validatedData['department'],
            'status' => $request->has('status') ? 1 : 0,
        ]);

        $grading_topic->save();

        return redirect()->route('admin.grading-topic')->with('success', 'Grading Topic updated successfully.');
    }

    public function destroy($id)
    {
        $topic_id = decrypt($id);

        $topic = GradingTopic::query()->find($topic_id);

        $topic->delete();

        return redirect()->route('admin.grading-topic')->with('success', 'Grading Topic deleted successfully.');
    }


    public function getGradingTopics(Request $request)
    {
        $department = $request->query('department');

        $topics = GradingTopic::where('department', $department)
            ->where('status', 0)
            ->get();

        return response()->json($topics);
    }




}
