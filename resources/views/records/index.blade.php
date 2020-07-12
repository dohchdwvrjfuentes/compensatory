@extends('admin.master', ['activePage' => 'records'])

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row text-sm">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Record Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Record Management</li>
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
                        <h5>Record Management</h5>
                        </span>
                        <div class="form-inline">
                            <li class="nav-item p-1">
                            <button type="button" class="btn btn-success btn-sm" data-backdrop="static" data-toggle="modal" data-target="#RecordAdd">
                            <i class="fas fa-plus-square" style="--fa-primary-color: white"></i> {{ __('New Record') }}</button>
                        </li>
                        </div>
                    </ul>
                    @endauth
                </div>

                <div class="card-body">
                    <div class="table table-sm responsive">
                    <table id="recordtbl" class="ui celled table table-bordered table-striped" style="width:100%; font-size:14px;">
                  <thead class="text-center text-success">
                  <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Particulars</th>
                    <th scope="col">Earned</th>
                    <th scope="col">Availed</th>
                    <th scope="col">Availed Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    @forelse ($records as $record)
                    <tr>
                        <td class="text-left">{{ $record->employee->name }}</td>
                        <td class="text-center">{{ $record->particulars }}</td>
                        <td class="text-center">{{ $record->earned != 0 ? $record->earned . ' Hr(s)' : ''}} </td>
                        <td class="text-center">{{ $record->availed != "" ? $record->availed . ' Hr(s)': '' }} </td>
                        <td class="text-center">{{ $record->availed_date }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No record records found!</td>
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
@endsection