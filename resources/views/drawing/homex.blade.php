@extends('layouts.drawing')

@section('content')

<section id="page-content">
	<div class="container">
		<div class="row">
			<div class="content col-lg-12">

					<table class="table" id="table">
						<thead>
							<tr>
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
							@foreach($drawings as $item)
							<tr>
								<td>{{$item->Status}}</td>
								<td>{{$item->Dwg_no}}</td>
								<td>{{$item->Revision}}</td>
								<td>{{$item->DwgTitle}}</td>
								<td>{{$item->Revision_date2}}</td>
								<td>{{$item->SubmissionNo}}</td>
								<td>{{$item->SubmissionRev}}</td>
								<td>{{$item->RegisterID}}</td>
								{{-- <td><button class="edit-modal btn btn-info"
									data-info="{{$item->id}},{{$item->first_name}},{{$item->last_name}},{{$item->email}},{{$item->gender}},{{$item->country}},{{$item->salary}}">
									<span class="glyphicon glyphicon-edit"></span> Edit
								</button>
								<button class="delete-modal btn btn-danger"
									data-info="{{$item->id}},{{$item->first_name}},{{$item->last_name}},{{$item->email}},{{$item->gender}},{{$item->country}},{{$item->salary}}">
									<span class="glyphicon glyphicon-trash"></span> Delete
								</button></td> --}}
							</tr>
							@endforeach
						</tbody>
					</table>
			</div>
		</div>
	</div>
</section>

@endsection
