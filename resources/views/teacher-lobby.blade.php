@extends('layouts.app-teacher-dashboard')
@section('content')
	<div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
		<div class="row w-100 p-4">
			{{-- left content --}}

			<div class="col-lg-8 justify-content-center col-md-5 pr-2 pl-4">
        <teaching-strategies></teaching-strategies>
			</div>


			{{-- right content --}}
			<div class="col-lg-3 col-md-3 offset-lg-1 pr-0">
				<div class="cont-home-works">
					<div class="head-upcoming-lesson bg-dark mb-0 p-3"><h5 class="font-weight-regular">Filters <span class="float-right pr-2" style="line-height: 1.5"><i class="fas fa-chevron-right"></i></span></h5></div>
					{{-- <div class="homework-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark"> --}}
						<div class="card-group b-bot-red">
							<div class="card p-4">
								<strategy-filter></strategy-filter>
							</div>
						</div>
						{{-- <div class="card-group b-bot-red">
							<div class="card"> --}}
								{{-- <div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div> --}}
							{{-- </div>
						</div> --}}
					{{-- </div> --}}
				</div>
				
			</div>
		</div>
	</div>
@endsection
