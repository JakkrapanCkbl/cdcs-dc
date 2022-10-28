@extends('layouts.drawing')

@section('content')
    <!-- Page Menu -->
    <div class="page-menu menu-outline">
        <div class="container">
            <nav>
                <ul>
                    <li><a href="page-menu.html">Memo</a></li>
                    <li><a href="page-menu-sticky.html">Advance Search</a></li>
                    <li><a href="page-menu-rounded.html">CDCS</a></li>
                </ul>
            </nav>
            <div id="pageMenu-trigger">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </div>
    <!-- end: Page Menu -->
    <section id="page-content">
            <div class="container">
                <div class="row">
                    <div class="content col-lg-12">
                        <form class="row g-3" method="GET" action="{{ route('drawing.dwg_search') }}" >
                            @if(Session::has('message'))
                                <div class="alert alert-success">{{Session::get('message')}}</div>
                            @endif

                            <div>
                                 {{-- show datatable 1 incoming --}}
                                <table class="table table-bordered nobottommargin" id="table_dwg">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Dwg No.</th>
                                            <th class="text-center">Revision</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Dwg Date</th>
                                            <th class="text-center">SubmissionNo</th>
                                            <th class="text-center">SubmissionRev</th>
                                            <th class="text-center">Outgoin</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($drawings) >= 1)
                                            @foreach($drawings as $drawing)
                                                <tr>
                                                    <td>
                                                        <a id="todo{{ $drawing->Dwg_no }}" class="open-ViewTodo btn btn-light btn-xs" data-bs-target="#modal-1" 
                                                        data-bs-toggle="modal" 
                                                        data-todo='{
                                                            "regid":"{{ $drawing->RegisterID }}",
                                                            
                                                            }'
                                                        href="#"><i class="icon-eye"></i></a>
                                                        
                                                    </td>
                                                    <td><p>{{ $drawing->Status }}</p></td>
                                                    <td>
                                                        <a href="{{ route('drawing.viewcad', ['id' => $drawing->Status . '-' . $drawing->Dwg_no . '-' . $drawing->Revision])}}" target="_blank">
                                                            {{ $drawing->Dwg_no }}
                                                        </a>
                                                        
                                                    </td>
                                                    <td><p>{{ $drawing->Revision }}</p></td>
                                                    <td><p>{{ $drawing->DwgTitle }}</p></td>
                                                    <td><p>{{ $drawing->Revision_date2 }}</p></td>
                                                    <td><p>{{ $drawing->SubmissionNo }}</p></td>
                                                    <td><p>{{ $drawing->SubmissionRev }}</p></td>
                                                    <td><p>{{ $drawing->RegisterID }}</p></td>
                                                    
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td>No result found!</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{-- end show datatable 1 incoming --}}
                            </div>

                        </form>
                        {{-- end form --}}
                    </div>
                    {{-- content col-lg-12 --}}
                </div> 
                {{-- end row --}}
            </div>
            {{-- end container --}}
            
    </section>





    <!--Modal large -->
    <div class="modal fade" id="modal-1" tabindex="-1" role="modal" aria-labelledby="modal-label-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-label-1" class="modal-title"><p id="mbdRegID" style="font-size: 20px;text-decoration: underline;"></p></h4>
                    {{-- <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button> --}}
                    <button aria-hidden="false" data-bs-dismiss="modal" class="btn-close" type="button">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <input type="text" name="regid" id="regid" value="" class="form-control" style="width: 230px;"> --}}                    
                            <p id="mbdCrossRef"></p>
                            <p id="mbdSubject"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><p id="mbdIssuedDate"></p></div>
                        <div class="col-md-6"><p id="mbdDocStatus"></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p id="mbdDocFrom"></p>
                            <p id="mbdDocTo"></p>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-2"><p>Respond to : </p></div>
                        <div class="col-md-10"><p id="mbdResponseToDocument"></p></div> --}}
                         <div class="col-md-2"><p>Respond to : </p></div>
                        <div class="col-md-10"><p id="mbdLink_ResponseToDocument" style="color:blue;text-decoration: underline;"></p></div>
                        {{-- <div class="col-md-2"><p>Refer to : </p></div>
                        <div class="col-md-10"><p id="mbdReferTo" style="color:blue;text-decoration: underline;"></p></div> --}}
                        <div class="col-md-2"><p>Refer to : </p></div>
                        <div class="col-md-10"><p id="mbdLink_ReferTo" style="color:blue;text-decoration: underline;"></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p id="mbdCSC_Response"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><p>Responded by : </p></div>
                        <div class="col-md-9"><p id="mbdLink_ShowResponsed" style="color:blue;text-decoration: underline;"></p></div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <p id="mbdShowDocCode"></p>
                            <p id="mbdShowTransmittalNo"></p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-b" type="button">Close</button>
                    {{-- <button class="btn btn-b" type="button">View PDF</button> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-2" tabindex="-1" role="modal" aria-labelledby="modal-label-2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-label-2" class="modal-title"><p id="mbdRegID_Out" style="font-size: 20px;text-decoration: underline;"></p></h4>
                    <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button>
                    {{-- <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button> --}}
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p id="mbdSubject_Out"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><p id="mbdIssuedDate_Out"></p></div>
                        <div class="col-md-6"><p id="mbdDocStatus_Out"></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><p id="mbdDocFrom_Out"></p></div>
                        <div class="col-md-6"><p id="mbdDocTo_Out"></p></div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-2"><p>Refer to : </p></div>
                        <div class="col-md-10"><p id="mbdLink_ReferTo_Out" style="color:blue;text-decoration: underline;"></p></div>
                        <div class="col-md-2"><p>Respond to : </p></div>
                        <div class="col-md-10"><p id="mbdLink_ResponseToDocument_Out" style="color:blue;text-decoration: underline;"></p></div>                          
                    </div>
                    <div class="row">
                        <div class="col-md-3"><p>Responded by : </p></div>
                        <div class="col-md-9"><p id="mbdLink_ShowResponsed_Out" style="color:blue;text-decoration: underline;"></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p id="mbdShowDocCode_Out"></p>
                            <p id="mbdShowTransmittalNo_Out"></p>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-b" type="button">Close</button>
                    {{-- <button class="btn btn-b" type="button">View PDF</button> --}}
                </div>
            </div>
        </div>
    </div>
    
    <!-- end: Modal large -->
@endsection
