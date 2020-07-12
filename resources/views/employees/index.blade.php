@extends('admin.master', ['activePage' => 'employees'])

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <!-- /.content-header -->

  <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @auth
                    <ul class="nav justify-content-between">
                        <span class="nav-item text-left">           
                        <h5>Employees Management</h5>
                        </span>
                        <div class="form-inline">
                            <li class="nav-item p-1">
                            <button type="button" class="btn btn-success btn-sm" data-backdrop="static" data-toggle="modal" data-target="#employeeAdd">
                            <i class="fas fa-plus-square" style="--fa-primary-color: white"></i> {{ __('New Employee') }}</button>
                        </li>
                        </div>
                    </ul>
                    @endauth
                </div>

                <div class="card-body">
                    <div class="table table-sm responsive">
                    <table id="employeetbl" class="ui celled table table-bordered table-striped" style="width:100%; font-size:14px;">
                  <thead class="text-center text-success">
                  <tr>
                    <th>ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Position</th>
                    <th scope="col">Office</th>
                    <th scope="col">Basic Pay</th>
                    <th scope="col">Total Hrs</th>
                    <th scope="col">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($employees as $employee)
                    <tr>
                        <td class="text-center">{{$employee->employee_id}}</td>
                        <td class="text-left">{{$employee->name}}</td>
                        <td class="text-left">{{$employee->position->position_name}}</td>
                        <td class="text-center">{{$employee->office->office_name}}</td>
                        <td class="text-right">{{ number_format($employee->pay,2)}}</td>
                        <td class="text-center">{{ $employee->total_hrs}} Hr(s)</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('employees.show', $employee->id) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-search"></i></a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Employee records found!</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="employeeAdd">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success">
            <i class="fas fa-plus-square"></i>
             New Employee</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('employees.store') }}" method="post">
                @csrf
            <div class="form-group">
                <label for="nameInput">Employee Name</label>
                <input type="text" class="form-control" name="name" id="nameInput" placeholder="" oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="form-group">
                <label for="employeeID">Employee Id</label>
                <input type="text" class="form-control" name="employee_id" id="employeeID" placeholder="" oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="form-group">
              <label for="positionInput">Position</label>
              <select class="form-control form-control-sm select2" name="position_id" id="positionInput">
                  @forelse($positions as $position)
                      <option value="{{$position->id}}">{{ $position->position_name }}</option>
                  @empty
                      <option>"No position Found"</option>
                  @endforelse
              </select>
            </div>
            <div class="form-group">
              <label for="officeInput">Office</label>
                <select class="form-control form-control-sm select2" name="office_id" id="officeInput">
                    @forelse($offices as $office)
                        <option value="{{$office->id}}">{{ $office->office_name }}</option>
                    @empty
                        <option>"No office Found"</option>
                    @endforelse
                </select>               
            </div>
            <div class="form-group">
                <label for="sgInput">Salary Grade</label>
                <input type="text" class="form-control col-6" name="salary_grade" id="sgInput" placeholder="0">
            </div>
            <div class="form-group">
                <label for="siInput">Step Increment</label>
                <input type="text" class="form-control col-6" name="step_increment" id="siInput" placeholder="0">
            </div>
            <div class="form-group">
                <label for="payInput">Basic Pay</label>
                <input type="text" class="form-control col-6" name="pay" id="payInput" placeholder="0.00">
            </div>
                <input type="text" hidden class="form-control col-6" name="status" id="statusInput" placeholder="" value="1">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection