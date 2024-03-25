<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Task $task)
    {
        return view('attachments.index', ['attachments' => $task->attachments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Task $task)
    {
        return view('attachments.create', ['task' => $task]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $path = $request->file('file')->store('attachments');

        $attachment = new Attachment;
        $attachment->file_path = $path;
        $attachment->user_id = auth()->id();
        $task->attachments()->save($attachment);

        return redirect()->route('tasks.show', $task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        return Storage::download($attachment->file_path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        Storage::delete($attachment->file_path);
        $attachment->delete();

        return back();
    }
}
