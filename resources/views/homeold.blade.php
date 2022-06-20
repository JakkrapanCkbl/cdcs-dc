@extends('layouts.cdcs')

@section('content')
 <section id="page-content">
            <div class="container">
                <div class="row">
                    <div class="content col-lg-12">
                        <form class="row g-3" method="GET" action="{{ route('search') }}" >
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
                                 <div class="tabs">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="incoming-tab" data-bs-toggle="tab" href="#incoming" role="tab" aria-controls="incoming" aria-selected="true">Incoming</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="outgoing-tab" data-bs-toggle="tab" href="#outgoing" role="tab" aria-controls="outgoing" aria-selected="false">Outgoing</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">                                           
                                            <div style="background: Ivory;">
                                                <div class="table-responsive text-nowrap">
                                                    @if(isset($incomings))
                                                        <table class="table table-bordered nobottommargin">
                                                            <thead>
                                                                <tr>
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
                                                                                <a href="{{ route('viewpdf', ['id' => $incoming->RegisterID])}}" target="_blank">
                                                                                {{ $incoming->RegisterID }}
                                                                                </a>
                                                                                {{-- @if(auth()->user()->ViewConfidential) 
                                                                                    <a href="{{ route('viewpdf', ['id' => $incoming->RegisterID])}}" target="_blank">
                                                                                        {{ $incoming->RegisterID }}
                                                                                    </a>
                                                                                @else
                                                                                    {{ $incoming->RegisterID }}
                                                                                @endif --}}
                                                                            </td>
                                                                            <td>{{ date('d-M-y', strtotime($incoming->IssuedDate)) }}</td>
                                                                            <td>{{ Str::limit($incoming->DocFrom, 10) }}</td>
                                                                            <td>{{ Str::limit($incoming->DocTo, 20) }}</td>
                                                                            <td>{{ $incoming->DocSubject }}</td>
                                                                            <td>{{ $incoming->DocStatus }}</td>
                                                                            <td>{{ $incoming->CrossRef }}</td>
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
                                        <div class="tab-pane fade" id="outgoing" role="tabpanel" aria-labelledby="outgoing-tab">
                                            <div style="background: pear;">
                                                <div class="table-responsive text-nowrap">
                                                    @if(isset($outgoings))
                                                        <table class="table table-bordered nobottommargin">
                                                            <thead>
                                                                <tr>
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
                                                                                {{-- <a href="{{ route('viewpdf', ['id' => $outgoing->RegisterID])}}" target="_blank">
                                                                                {{ $outgoing->RegisterID }}
                                                                                </a> --}}
                                                                                 <a href="{{ route('viewpdf', ['id' => $outgoing->RegisterID])}}" target="_blank">
                                                                                {{ $outgoing->RegisterID }}
                                                                                </a>
                                                                            </td>
                                                                            <td>{{ date('d-M-y', strtotime($outgoing->IssuedDate)) }}</td>
                                                                            <td>{{ Str::limit($outgoing->DocFrom, 10) }}</td>
                                                                            <td>{{ Str::limit($outgoing->DocTo, 20) }}</td>
                                                                            <td>{{ $outgoing->DocSubject }}</td>
                                                                            <td>{{ $outgoing->DocStatus }}</td>
                                                                            <td>{{ $outgoing->ReferTo }}</td>
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
                                    </div>
                                </div>

                                

                                
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>

@endsection
