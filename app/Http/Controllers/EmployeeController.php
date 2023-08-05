<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Employee::with('department');

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
                $employees = $query->paginate($perPage);
            } else {
                $employees = $query->get();
            }

            if (!$employees)  return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            return response()->json(["status" => "success", "response" => $employees], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function show($id)
    {
        try {
            $employee = Employee::with('department')->where('id', $id)->get()->map(function ($employee) {
                unset($employee->department_id);
                return $employee;
            });

            if (!$employee)  return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            return response()->json(["status" => "success", "response" => $employee], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            $customMessages = [
                'firstName.required' => 'O campo Nome é obrigatório.',
                'lastName.required' => 'O campo Sobrenome é obrigatório.',
                'email.required' => 'O campo E-mail é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.unique' => 'Este e-mail já está sendo usado por outro funcionário.',
                'department_id.required' => 'O campo Departamento é obrigatório.',
                'department_id.exists' => 'O departamento selecionado não existe.'
            ];

            $validator = Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:tb_employees,email',
                'phone' => 'nullable',
                'department_id' => 'required|exists:tb_departments,id'
            ], $customMessages);

            if ($validator->fails()) {
                return response()->json(["status" => "error", "message" => $validator->errors()], 422);
            }

            $employee = Employee::create($request->only('firstName', 'lastName', 'email', 'phone', 'department_id'));

            return response()->json(["status" => "success", "message" => "Criado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee)  return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            $customMessages = [
                'firstName.required' => 'O campo Nome é obrigatório.',
                'lastName.required' => 'O campo Sobrenome é obrigatório.',
                'email.required' => 'O campo E-mail é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.unique' => 'Este e-mail já está sendo usado por outro funcionário.',
                'department_id.required' => 'O campo Departamento é obrigatório.',
                'department_id.exists' => 'O departamento selecionado não existe.'
            ];

            $validator = Validator::make($request->all(), [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:tb_employees,email,' . $id,
                'phone' => 'nullable',
                'department_id' => 'required|exists:tb_departments,id'
            ], $customMessages);

            if ($validator->fails()) {
                return response()->json(["status" => "error", "message" => $validator->errors()], 422);
            }


            $employee->update($request->only('firstName', 'lastName', 'email', 'phone', 'department_id'));

            return response()->json(["status" => "success", "message" => "Atualizado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee)  return response()->json(["status" => "error", "message" => "Registro não encontrado"], 404);

            $employee->delete();

            return response()->json(["status" => "success", "message" => "Deletado com sucesso"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
