@extends('admin.master', ['activePage' => 'duties'])

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
              <li class="breadcrumb-item active">Duty Management</li>
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
                        <h5>Duty Management</h5>
                        </span>
                        <div class="form-inline">
                            <li class="nav-item p-1">
                            <button type="button" class="btn btn-success btn-sm" data-backdrop="static" data-toggle="modal" data-target="#dutyAdd">
                            <i class="fas fa-plus-square" style="--fa-primary-color: white"></i> {{ __('New Duty') }}</button>
                        </li>
                        </div>
                    </ul>
                    @endauth
                </div>

                <div class="card-body">
                    <div class="table table-sm responsive">
                    <table id="dutytbl" class="ui celled table table-bordered table-striped" style="width:100%; font-size:14px;">
                  <thead class="text-center text-success">
                  <tr>
                    <th scope="col">Duty Date</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Shift</th>
                    <th scope="col">Hrs Rendered</th>
                    <th scope="col">Usable</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($duties as $duty)
                    <tr>
                        <td class="text-center">{{ \Carbon\Carbon::parse($duty->duty_date)->toFormattedDateString() }}</td>
                        <td class="text-center">{{ $duty->employee->name }}</td>
                        <td class="text-center">
                          @switch($duty->shift)

                            @case(1)
                              OPCEN - WEEKDAY
                            @break

                            @case(2)
                              OPCEN - WEEKEND
                            @break

                            @case(3)
                              ACTIVITY
                            @break

                            @case(6)
                              OVERTIME SERVICES
                            @break

                            @default
                              NO SHIFT FOUND
                          @endswitch

                         </td>
                        <td class="text-center">{{ number_format($duty->hr_rendered, 2) }} Hr(s)</td>
                        <td class="text-center">{{ $duty->remaining }} Hr(s) </td>
                          @if($duty->remaining != 0.000 && $duty->duty_date >= $duty->expiry_date)
                            <td class="text-center text-danger"> Expired </td>
                          @elseif($duty->remaining != 0.000 && $duty->duty_date < $duty->expiry_date)
                            <td class="text-center text-success"> Available </td>
                          @elseif($duty->remaining == 0.000)
                            <td class="text-center text-warning"> Unavailable </td>
                          @endif
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('duties.show', $duty->id) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-search"></i></a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No duty records found!</td>
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

<div class="modal fade" id="dutyAdd">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success">
            <i class="fas fa-plus-square"></i>
             New Duty</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('duties.store') }}" method="post">
                @csrf
            <div class="form-group">
              <label for="employeeInput">Employee</label>
              <select class="form-control form-control-sm select2" name="employee_id" id="employeeInput">
                  @forelse($employees as $employee)
                      <option value="{{$employee->id}}">{{ $employee->name }}</option>
                  @empty
                      <option>"No employee Found"</option>
                  @endforelse
              </select>
            </div>
            <div class="form-group">
              <label for="dutyDate">Duty Date</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="text" class="form-control datemask" id="dutyDate" name="duty_date" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask>
              </div>
              <!-- /.input group -->
            </div> 
            <div class="form-group">
              <label for="shiftInput">Shift</label>
              <select class="form-control form-control-sm" name="shift" id="shiftInput">
                  @forelse($shifts as $shift)
                      <option value="{{$shift->id}}">{{ $shift->desc }}</option>
                  @empty
                      <option>"No shift Found"</option>
                  @endforelse
              </select>
            </div>
            <div class="form-group">
                <label for="hrrenderedInput">Hrs Rendered</label>
                <input type="text" class="form-control col-6" name="hr_rendered" id="hrrenderedInput" placeholder="0.00">
            </div>
            <div class="form-group">
                <label for="rosoInput">ROSO No. <small class="lead">(optional)</small></label>
                <input type="text" class="form-control col-6" name="roso_no" id="rosoInput" placeholder="0" value="N/A">
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