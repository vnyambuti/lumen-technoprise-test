<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $query = Task::query();
           // Search by title
           if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'LIKE', "%{$searchTerm}%");
        }
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by due_date
        if ($request->has('due_date')) {
            $dueDate = $request->due_date;
            switch ($dueDate) {
                case 'overdue':
                    $query->where('due_date', '<', now())->where('status', '!=', 'completed');
                    break;
                case 'today':
                    $query->whereDate('due_date', today());
                    break;
                case 'this_week':
                    $query->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'next_week':
                    $query->whereBetween('due_date', [now()->addWeek()->startOfWeek(), now()->addWeek()->endOfWeek()]);
                    break;
            }
        }

        // Sort by due_date
        if ($request->has('sort_by') && $request->sort_by === 'due_date') {
            $direction = $request->sort_direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy('due_date', $direction);
        }

           // Pagination
           $perPage = $request->input('per_page', 15); // Default to 15 items per page
           $tasks = $query->paginate($perPage);
   
           return response()->json([
               'data' => $tasks->items(),
               'current_page' => $tasks->currentPage(),
               'per_page' => $tasks->perPage(),
               'total' => $tasks->total(),
               'last_page' => $tasks->lastPage(),
           ]);
    }

    public function show($id)
    {
        return Task::findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:tasks',
            'description' => 'required',
            'status' => 'required|in:pending,completed',
            'due_date'=>'required|after:now'
        ]);

        try {
            $task = Task::create($request->all());
            return response()->json($task, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:pending,completed',
            'due_date'=>'required|after:now'
        ]);

        try {
            $task = Task::findOrFail($id);
            $task->update($request->all());
            return response()->json($task, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
