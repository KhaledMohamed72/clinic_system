<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            @if(\Jenssegers\Agent\Facades\Agent::isMobile())
            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
            <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                   href="#custom-content-below-appointment" role="tab"
                   aria-controls="custom-content-below-appointment" aria-selected="true">
                    <span><i class="fa fa-user-plus"></i></span>&ensp;&ensp;
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                   href="#custom-content-below-prescription" role="tab"
                   aria-controls="custom-content-below-prescription" aria-selected="false">
                    &ensp;&ensp;<span><i class="fa fa-file"></i></span>&ensp;&ensp;
                </a>
            </li>
            {{--                            <li class="nav-item">
                                            <a class="nav-link" id="custom-content-below-invoices-tab" data-toggle="pill"
                                               href="#custom-content-below-invoices" role="tab"
                                               aria-controls="custom-content-below-invoices" aria-selected="false">
                                                &ensp;&ensp;<span><i class="fa fa-pen-square"></i></span>&ensp;
                                            </a>
                                        </li>--}}
            @else
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                       href="#custom-content-below-appointment" role="tab"
                       aria-controls="custom-content-below-appointment" aria-selected="true">
                        &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Appointments&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                       href="#custom-content-below-prescription" role="tab"
                       aria-controls="custom-content-below-prescription" aria-selected="false">
                        &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Prescription List&ensp;&ensp;&ensp;&ensp;&ensp;
                    </a>
                </li>
            @endif
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade show active" id="custom-content-below-appointment" role="tabpanel"
                 aria-labelledby="custom-content-below-appointment-tab">
                {{-- Appointment List table --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="" class="display table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Phone</th>
                                        <th>Date</th>
                                        <th>time</th>
                                        <th>status</th>
                                        <th>action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($appointments as $row)
                                        <tr>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->patient_name}}</td>
                                            <td>{{$row->doctor_name}}</td>
                                            <td>{{$row->phone}}</td>
                                            <td>{{$row->date}}</td>
                                            <td>{{date("g:i A", strtotime($row->time))}}</td>
                                            <td>
                                                @if($row->status == 'pending')
                                                    <span class="badge badge-info">pending</span>
                                                @elseif($row->status == 'cancel')
                                                    <span class="badge badge-danger">cancel</span>
                                                @elseif($row->status == 'complete')
                                                    <span class="badge badge-primary">complete</span>
                                                @else

                                                @endif
                                            </td>
                                            <td>
                                                @if($row->status == 'pending')
                                                    @if(auth()->user()->hasRole('doctor'))
                                                        <a class="btn btn-primary btn-sm"
                                                           href="{{route('prescriptions.create') . '?date='. $row->date . '&patient_id=' . $row->patient_id}}"
                                                           title="Complete">
                                                            Create Prescription
                                                        </a>
                                                    @endif

                                                    <a class="btn btn-danger btn-sm"
                                                       href="{{route('cancel-action',$row->id)}}"
                                                       title="Complete">
                                                        Cancel
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                {{-- End Appointment List table --}}
            </div>
            <div class="tab-pane fade" id="custom-content-below-prescription" role="tabpanel"
                 aria-labelledby="custom-content-below-prescription-tab">
                {{-- prescription List table --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="" class="display table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($prescriptions as $row)
                                        <tr>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->patient_name}}</td>
                                            <td>{{$row->doctor_name}}</td>
                                            <td>{{date('Y-m-d',strtotime($row->created_at))}}</td>
                                            <td>{{date('h:i a',strtotime($row->created_at))}}</td>
                                            <td class="project-actions text-left">
                                                <a class="btn btn-primary btn-sm"
                                                   href="{{route('prescriptions.show',$row->id)}}"
                                                   title="View">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                </a>

                                                @if(auth()->user()->hasRole('doctor'))
                                                    <a class="btn btn-info btn-sm"
                                                       href="{{route('prescriptions.edit',$row->id)}}"
                                                       title="Edit">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </a>
                                                    <form
                                                        action="{{route('prescriptions.destroy',$row->id)}}"
                                                        method="POST"
                                                        style="display: contents;">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                href="#"
                                                                title="Delete">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                {{-- End Appointment List table --}}
            </div>
        </div>
    </div>
</div>
