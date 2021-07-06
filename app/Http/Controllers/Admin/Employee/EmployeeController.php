<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\EmployeeStoreUpdateRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('modules.employee.employee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileView()
    {
        return view('modules.employee.profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employyes = Employee::filterByRole()
                            ->role($request->role)
                            ->office($request->office)
                            ->with('offices','roles')
                            ->orderBy('name')
                            ->get();

        return $this->sendResponse(null, EmployeeResource::collection($employyes));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        $employeesPaginate = Employee::filterByRole()
                                    ->softDelete($request->softDelete)
                                    ->name($request->name)
                                    ->email($request->email)
                                    ->office($request->office)
                                    ->with('offices','roles')
                                    ->orderBy('name')
                                    ->paginate();

        $employeesPaginate->setCollection(EmployeeResource::collection($employeesPaginate->getCollection())->collection);

        return $this->sendResponse(null, $employeesPaginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $newEmployee = new Employee($request->all());
            $newEmployee->password = Hash::make($request->password);
            $newEmployee->created_by = auth()->user()->id;
            $newEmployee->updated_by = auth()->user()->id;
            if ($newEmployee->save()) {
                $newEmployee->syncRoles(Role::where('id', $request->role)->get());
                if (!$newEmployee->hasRole('Super Admin')) {
                    $newEmployee->offices()->sync($request->offices);
                }
            }

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), (new EmployeeResource($newEmployee)), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeStoreUpdateRequest $request, $id)
    {
        if(!$employee = Employee::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $employee->fill($request->all());
            if (!empty($request->password)) {
                $employee->password = Hash::make($request->password);
            }
            $employee->updated_by = auth()->user()->id;
            if ($employee->save()) {
                $employee->syncRoles(Role::where('id', $request->role)->get());
                if ($employee->hasRole('Super Admin')) {
                    $employee->offices()->sync([]);
                } else {
                    $employee->offices()->sync($request->offices);
                }
            }

            DB::commit();
            return $this->sendResponse(__('Updated successfully'), (new EmployeeResource($employee)));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $employee = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => "required|email|unique:employees,email,".$employee->id.",id",
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password',
        ]);

        try {
            DB::beginTransaction();
            $employee->fill($request->all());
            if ($request->password) {
                $employee->password = Hash::make($request->password);
            }
            $employee->save();

            DB::commit();
            return $this->sendResponse(__('Updated successfully'), $employee);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$employee = Employee::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $employee->delete();

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), (new EmployeeResource($employee)));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id)
    {
        if(!$employee = Employee::find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $employee->changeStatus();

            DB::commit();
            return $this->sendResponse(__('Saved successfully'), $employee);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if(!$employee = Employee::onlyTrashed()->find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $employee->restore();

            DB::commit();
            return $this->sendResponse(__('Restored successfully'), $employee);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        if(!$employee = Employee::onlyTrashed()->find($id)) {
            return $this->sendError404();
        }

        try {
            DB::beginTransaction();
            $employee->forceDelete();

            DB::commit();
            return $this->sendResponse(__('Deleted successfully'), $employee);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }


}
