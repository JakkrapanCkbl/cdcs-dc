@extends('layouts.cdcs')

@section('content')


    <section id="page-content">
            <div class="container">
                <div class="row">
                    <div class="content col-lg-12">
                        <form class="row g-3" method="GET" action="{{ route('cdcs.search') }}" >
                            @if(Session::has('message'))
                                <div class="alert alert-success">{{Session::get('message')}}</div>
                            @endif
                            <div class="col-md-1">
                                <label for="inputContract" class="form-label">Contract</label>
                                <select name="inputContract" id="inputContract" class="form-select">
                                    @if(isset($ct))
                                        @if($ct == '02')
                                            <option selected>02</option>
                                            <option>03</option>
                                            <option>All</option>
                                        @elseif($ct == '03')
                                            <option>02</option>
                                            <option selected>03</option>
                                            <option>All</option>
                                        @else
                                            <option>02</option>
                                            <option>03</option>
                                            <option selected>All</option>
                                        @endif
                                    @else
                                        <option selected>02</option>
                                        <option>03</option>
                                        <option>All</option>
                                    @endif
                              </select>
                            </div>
                            <div class="col-md-3">
                                <label for="inputField" class="form-label">Field</label>
                                <select name="inputField" id="inputField" class="form-select">
                                    @if(isset($sf))
                                        @if($sf == 'RegisterID')
                                            <option selected>RegisterID</option>
                                            <option>Subject</option>
                                        @elseif($sf == 'DocSubject')
                                            <option>RegisterID</option>
                                            <option selected>Subject</option>
                                        @endif
                                    @else
                                        <option selected>RegisterID</option>
                                        <option>Subject</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputText" class="form-label">Input</label>
                                @if(isset($inputs))
                                    <input type="text" class="form-control" name="inputText" id="inputText" value="{{$inputs}}">
                                @else
                                    <input type="text" class="form-control" name="inputText" id="inputText">
                                @endif
                                                               
                            </div>
                           
                            <div class="col-md-2">
                                <label for="btnSearch" class="form-label">Search</label>
                                <button type="submit" class="btn btn-primary" id="btnSearch">Search now</button>
                            </div>
                        
                            <div class="container">
                                {{-- start Tab --}}
                                <div class="bs-example">
                                    <ul class="nav nav-tabs" id="myTab">
                                        <li class="nav-item">
                                            <a href="#sectionA" class="nav-link active" data-toggle="tab">Incoming</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sectionB" class="nav-link" data-toggle="tab">Outgoing</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="sectionA" class="tab-pane fade show active">
                                            <div style="background: Ivory;">
                                                <div class="table-responsive text-nowrap">
                                                    @if(isset($incomings))
                                                        <table class="table table-bordered nobottommargin">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>RegisterID</th>
                                                                    <th>IssuedDate</th>
                                                                    <th>From</th>
                                                                    <th>To</th>
                                                                    <th>Subject</th>
                                                                    <th>Status</th>
                                                                    <th>Sender Ref</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(count($incomings) > 0)
                                                                    @foreach ($incomings as $incoming)
                                                                        <tr>
                                                                            <td>
                                                                                <a id="todo{{ $incoming->RegisterID }}" class="open-ViewTodo btn btn-light btn-xs" data-bs-target="#modal-3" 
                                                                                data-bs-toggle="modal" 
                                                                                data-todo='{
                                                                                    "regid":"{{ $incoming->RegisterID }}",
                                                                                    "crossref":"{{ $incoming->CrossRef }}",
                                                                                    "subject":"{{ $incoming->DocSubject }}",
                                                                                    "rn":"{{ $url = route('cdcs.viewpdf', ['id' => $incoming->RegisterID]); }}"
                                                                                    }'
                                                                                href="#">...</a>
                                                                                
                                                                            </td>
                                                                            <td>
                                                                                @if((new \Jenssegers\Agent\Agent())->isDesktop())
                                                                                    <a href="{{ route('cdcs.viewpdf', ['id' => $incoming->RegisterID])}}" target="_blank">
                                                                                        {{ $incoming->RegisterID }}
                                                                                    </a>
                                                                                @elseif((new \Jenssegers\Agent\Agent())->isMobile())
                                                                                    <a href="{{ route('cdcs.mobileviewpdf', ['id' => $incoming->RegisterID])}}" target="_blank">
                                                                                        {{ $incoming->RegisterID }}
                                                                                    </a>
                                                                                @elseif((new \Jenssegers\Agent\Agent())->isTablet())
                                                                                    <a href="{{ route('cdcs.mobileviewpdf', ['id' => $incoming->RegisterID])}}" target="_blank">
                                                                                        {{ $incoming->RegisterID }}
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                            <td><p>{{ date('d-M-y', strtotime($incoming->IssuedDate)) }}</p></td>
                                                                            <td><p data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $incoming->DocFrom }}">{{ Str::limit($incoming->DocFrom, 10) }}</p></td>
                                                                            <td><p data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $incoming->DocTo }}">{{ Str::limit($incoming->DocTo, 20) }}</p></td>
                                                                            <td><p data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $incoming->DocSubject }}">{{ $incoming->DocSubject }}</p></td>
                                                                            <td><p>{{ $incoming->DocStatus }}</p></td>
                                                                            <td><p>{{ $incoming->CrossRef }}</p></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr><td>No result found!</td></tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <div class="pagination-block">
                                                            {{$incomings->links('layouts.paginationlinks')}}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end incoming --}}
                                        <div id="sectionB" class="tab-pane fade">
                                            <div style="background: Azure;">
                                                <div class="table-responsive text-nowrap">
                                                    @if(isset($outgoings))
                                                        <table class="table table-bordered nobottommargin">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>RegisterID</th>
                                                                    <th>IssuedDate</th>
                                                                    <th>From</th>
                                                                    <th>To</th>
                                                                    <th>Subject</th>
                                                                    <th>Status</th>
                                                                    <th>Sender Ref</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(count($outgoings) > 0)
                                                                    @foreach ($outgoings as $outgoing)
                                                                        <tr>
                                                                            <td>
                                                                                <a id="todo{{ $outgoing->RegisterID }}" class="open-ViewTodoOut btn btn-light btn-xs" data-bs-target="#modal-2" 
                                                                                data-bs-toggle="modal" 
                                                                                data-todo='{
                                                                                    "regidout":"{{ $outgoing->RegisterID }}",
                                                                                    "subjectout":"{{ $outgoing->DocSubject }}",
                                                                                    "rnout":"{{ $url = route('cdcs.viewpdf', ['id' => $outgoing->RegisterID]); }}"
                                                                                    }'
                                                                                href="#">...</a>
                                                                                
                                                                            </td>
                                                                            <td>
                                                                                @if((new \Jenssegers\Agent\Agent())->isDesktop())
                                                                                    <a href="{{ route('cdcs.viewpdf', ['id' => $outgoing->RegisterID])}}" target="_blank">
                                                                                        {{ $outgoing->RegisterID }}
                                                                                    </a>
                                                                                @elseif((new \Jenssegers\Agent\Agent())->isMobile())
                                                                                    <a href="{{ route('cdcs.mobileviewpdf', ['id' => $outgoing->RegisterID])}}" target="_blank">
                                                                                        {{ $outgoing->RegisterID }}
                                                                                    </a>
                                                                                @elseif((new \Jenssegers\Agent\Agent())->isTablet())
                                                                                    <a href="{{ route('cdcs.mobileviewpdf', ['id' => $outgoing->RegisterID])}}" target="_blank">
                                                                                        {{ $outgoing->RegisterID }}
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                            <td><p>{{ date('d-M-y', strtotime($outgoing->IssuedDate)) }}</p></td>
                                                                            <td><p data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $outgoing->DocFrom }}">{{ Str::limit($outgoing->DocFrom, 10) }}</p></td>
                                                                            <td><p data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $outgoing->DocTo }}">{{ Str::limit($outgoing->DocTo, 20) }}</p></td>
                                                                            <td><p data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $outgoing->DocSubject }}">{{ $outgoing->DocSubject }}</p></td>
                                                                            <td><p>{{ $outgoing->DocStatus }}</p></td>
                                                                            <td><p>{{ $outgoing->ReferTo }}</p></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr><td>No result found!</td></tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <div class="pagination-block">
                                                            {{$outgoings->links('layouts.paginationlinks')}}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end outgoing --}}
                                    </div>
                                    {{-- end tab content --}}
                                </div>
                                {{-- end tab section with table --}}
                            </div>
                            {{-- end container (tab) --}}
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
    <div class="modal fade" id="modal-3" tabindex="-1" role="modal" aria-labelledby="modal-label-3" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-label-3" class="modal-title"><p id="mbdRegID" style="font-size: 20px;"></p></h4>
                    <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <input type="text" name="regid" id="regid" value="" class="form-control" style="width: 230px;"> --}}                    
                            <p id="mbdCrossRef"></p>
                            <p id="mbdSubject"></p>
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
                    <h4 id="modal-label-2" class="modal-title"><p id="mbdRegID_Out" style="font-size: 20px;"></p></h4>
                    {{-- <button aria-hidden="true" data-bs-dismiss="modal" class="btn-close" type="button">×</button> --}}
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <input type="text" name="regid" id="regid" value="" class="form-control" style="width: 230px;"> --}}                                                      
                            <p id="mbdSubject_Out"></p>
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
