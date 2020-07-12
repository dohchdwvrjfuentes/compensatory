@extends('admin.master', ['activePage' => 'leaves'])

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row text-sm">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Leave Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Leave Management</li>
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
                        <h5>Leave Management</h5>
                        </span>
                        <div class="form-inline">
                            <li class="nav-item p-1">
                            <button type="button" class="btn btn-success btn-sm" data-backdrop="static" data-toggle="modal" data-target="#leaveAdd">
                            <i class="fas fa-plus-square" style="--fa-primary-color: white"></i> {{ __('New Leave') }}</button>
                        </li>
                        </div>
                    </ul>
                    @endauth
                </div>

                <div class="card-body">
                    <div class="table table-sm responsive">
                    <table id="leavetbl" class="ui celled table table-bordered table-striped" style="width:100%; font-size:14px;">
                  <thead class="text-center text-success">
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Applied Date</th>
                    <th scope="col"># of Hrs <br> Availed</th>
                    <th scope="col">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($leaves as $leave)
                    <tr>
                        <td class="text-center">{{ \Carbon\Carbon::parse($leave->created_at)->toFormattedDateString() }}</td>
                        <td class="text-center">{{ $leave->employee->name }}</td>
                        <td class="text-center">{{ $leave->apply_date }}</td>
                        <td class="text-center">{{ $leave->duration . ' Hour(s)' }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('leaves.show', $leave->id) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-search"></i></a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No leave records found!</td>
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


<div class="modal fade" id="leaveAdd">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success">
            <i class="fas fa-plus-square"></i>
             New Leave</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('leaves.store') }}" method="post">
                @csrf
            <div class="form-group">
              <label for="leaveDate">Leave Date</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control datemask" id="leaveDate" name="leave_date" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask>
              </div>
              <!-- /.input group -->
            </div> 
            <div class="form-group">
              <label for="employeeInput">Employee</label>
              <select class="form-control form-control-sm select2" name="employee_id" id="employeeInput">
                  <option selected disabled>{{ 'Select Employee' }}</option>
                  @forelse($employees as $employee)
                      <option value="{{$employee->id}}">{{ $employee->name }}</option>
                  @empty
                      <option>"No employee Found"</option>
                  @endforelse
              </select>
            </div>
            <div class="form-group">
              <label for="apply_date">Select Duty</label>
              <select class="select2" multiple="multiple" name="apply_date[]" id="apply_date" style="width:100%">
              </select>
            </div> 
            <div class="form-group">
                <label for="durationInput">Duration</label>
                <input type="text" class="form-control col-6" name="duration" id="durationInput" placeholder="0">
            </div>
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