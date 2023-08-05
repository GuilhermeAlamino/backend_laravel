<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Department::query();

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
                $perPage = (int)$request->input('per_page', 10);
                $departments = $query->paginate($perPage);
            } else {
                $departments = $query->get();
            }

            if (!$departments) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            return response()->json(["status" => "success", "response" => $departments], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $department = Department::where('id', $id)->first();

            if (!$department) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            return response()->json(["status" => "success", "response" => $department], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            $customMessages = [
                'name.required' => 'O campo Nome é obrigatório.'
            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], $customMessages);


            if ($validator->fails()) {
                return response()->json(["status" => "error", "message" => $validator->errors()], 422);
            }

            $department = Department::create($request->only('name'));

            return response()->json(["status" => "success", "message" => "Criado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $department = Department::find($id);

            if (!$department) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            $customMessages = [
                'name.required' => 'O campo Nome é obrigatório.'
            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], $customMessages);


            if ($validator->fails()) {
                return response()->json(["status" => "error", "message" => $validator->errors()], 422);
            }

            $department->update($request->only('name'));

            return response()->json(["status" => "success", "message" => "Atualizado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $department = Department::find($id);

            if (!isset($department)) return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            $department->delete();

            return response()->json(["status" => "success", "message" => "Deletado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
