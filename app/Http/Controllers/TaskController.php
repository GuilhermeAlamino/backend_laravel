<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Task::with('employee');

            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $query->search($searchTerm);
            }

            if ($request->has('sort')) {
                $sortField = $request->input('sort');
                $sortDirection = $request->input('direction', 'asc');
                $query->orderBy($sortField, $sortDirection);
            }

            if ($request->has('page')) {
                $perPage = $request->input('per_page', 10);
                $tasks = $query->paginate($perPage);
            } else {
                $tasks = $query->get();
            }

            if (!$tasks) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            return response()->json(["status" => "success", "response" => $tasks], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $task = Task::with('employee')->where('id', $id)->get()->map(function ($task) {
                unset($task->assignee_id);
                return $task;
            });

            if (!$task) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            return response()->json(["status" => "success", "response" => $task], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            $customMessages = [
                'title.required' => 'O campo Título é obrigatório.',
                'description.nullable' => 'O campo Descrição deve ser null ou vazio.',
                'due_date.nullable' => 'O campo Prazo deve ser null ou vazio.',
                'assignee_id.required' => 'O campo Funcionário é obrigatório.',
                'assignee_id.exists' => 'O funcionário selecionado não existe.'
            ];

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'nullable',
                'due_date' => 'nullable',
                'assignee_id' => 'required|exists:tb_employees,id'
            ], $customMessages);

            if ($validator->fails()) {
                return response()->json(["status" => "error", "message" => $validator->errors()], 422);
            }

            $task = Task::create($request->only('title', 'description', 'due_date', 'assignee_id'));

            return response()->json(["status" => "success", "message" => "Criado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::find($id);

            if (!$task) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'nullable',
                'due_date' => 'nullable',
                'assignee_id' => 'required|exists:tb_employees,id'
            ]);

            if ($validator->fails()) {
                return response()->json(["status" => "error", "message" => $validator->errors()], 422);
            }

            $task->update($request->only('title', 'description', 'due_date', 'assignee_id'));

            return response()->json(["status" => "success", "message" => "Atualizado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $task = Task::find($id);

            if (!$task) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            $task->delete();

            return response()->json(["status" => "success", "message" => "Deletado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
