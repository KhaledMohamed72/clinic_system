@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('title')   PRESCRIPTION DETAILS    @endsection
@section('header-title')    PRESCRIPTION DETAILS    @endsection
@section('header-title-one')    PRESCRIPTIONS     @endsection
@section('header-title-two')    PRESCRIPTION DETAILS   @endsection

@section('content')
    <div class="row d-print-none">
        <div class="col-12 text-center">
            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4 ml-3"
               title="Print">
                <i class="fa fa-print"></i>
            </a>
            <a href="{{route('prescription-pdf',$prescription->id)}}"
               class="btn btn-warning waves-effect waves-light mb-4" title="Print">
                <i class="fa fa-file-pdf"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <strong class="float-right font-size-16">Prescription #{{$prescription->id}}</strong>

                        <img src="{{asset('assets/dist/img/pulpo-logo.jpg')}}" alt="logo"
                             height="30"/>
                        <small>PULPO CLINIC</small>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4 text-center">
                            <address>
                                <strong>المريض</strong>
                                <div>
                                    <span>{{$patient->name}}</span><strong> : الاسم </strong>
                                </div>
                                <div>
                                    <span>{{$prescription->date}}</span><strong> : التاريخ </strong>
                                </div>
                                <div>
                                    <span>{{$patient->address}}</span><strong> : العنوان </strong>
                                </div>
                            </address>
                        </div>
                        <div class="col-2">

                        </div>
                        <div class="col-6">
                            {!! $prescription_design->header ?? '' !!}
                        </div>
                    </div>
                    @if(!$medicines->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold">Medicines</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($medicines as $row)
                                            <tr>
                                                <td>{{$row->medicine_name}}</td>
                                                <td>{{$row->frequency_name ?? ''}}</td>
                                                <td>{{$row->period_name ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!$tests->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold">Test Reports</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($tests as $row)
                                            <tr>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->note}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!$formulas->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold">Formulas</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($formulas as $row)
                                            <tr>
                                                <td>{{$row->formula_name}}</td>
                                                <td>{{$row->frequency_name ?? ''}}</td>
                                                <td>{{$row->period_name ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    <hr>
                    <div class="row">
                        {!! $prescription_design->footer ?? '' !!}
                    </div>
                    <div class="row d-print-none">
                        <div class="col-12 text-center">
                            <a href="javascript:window.print()"
                               class="btn btn-success waves-effect waves-light mb-4 ml-3" title="Print">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="{{route('prescription-pdf',$prescription->id)}}"
                               class="btn btn-warning waves-effect waves-light mb-4" title="Print">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, order: [[0, 'desc']],
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>
@endsection
