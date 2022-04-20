@extends('layouts.app-teacher-dashboard')
@section('content')
	<div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
		<div class="row w-100 p-4">
			{{-- left content --}}
			<div class="col-lg-3 col-md-3 pr-0">

				<div class="cont-upcoming-lesson">
					{{-- <div class="form-group ico-wrapper-find">
						<i class="fas fa-search"></i>
						<input type="text" class="form-control form-control-lg find-tutor-ipt" placeholder="Find Tutor">
					</div> --}}
					<div class="head-upcoming-lesson bg-dark mb-0 pb-2 pt-3 pl-3"><h5 class="font-weight-regular">Upcoming Lesson <span class="float-right pr-2" style="line-height: 1.5"><i class="fas fa-chevron-right"></i></span></h5></div>
					<div class="body-upcoming-lesson p-3">
						<label class="text-center w-100 font-weight-bold"><?php echo date('l, F, j, Y'); ?></label>
						<p class="text-center"><?php echo date('h:i A'); ?></p>
					</div>
					<div class="upcoming-lesson-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
						<teacher-upcoming-lesson></teacher-upcoming-lesson>
					</div>
				</div>
			</div>

			{{-- mid content --}}

			<div class="{{ $uri=='teachers-workbooks' ? 'col-lg-8' : 'col-lg-5' }} justify-content-center col-md-5 pr-2 pl-4">
				@switch($uri)
						@case('chat')
							<chat-panel :messageDisplay="{{ $messageDisplay }}" :teachers-id="{{ $teachers_id ?? 0 }}" :students-id="{{ $students_id ?? 0 }}"></chat-panel>
							@break
						@case('profile')
							<div class="body-upcoming-lesson p-3 rounded-md">
								<div class="upcoming-lesson-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
									{{-- <teacher-information-main teachers-id="{{ Auth::id() }}"></teacher-information-main> --}}
									{{-- <teacher-main-profile teachers-id="{{ Auth::id() }}"></teacher-main-profile> --}}
									<teacher-profile-settings></teacher-profile-settings>
								</div>
							</div>
							@break
						@case('teacher-lobby')
							<div class="body-upcoming-lesson p-3 rounded-md">
								<div class="upcoming-lesson-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
									<teacher-information-main teachers-id="{{ Auth::id() }}"></teacher-information-main>
								</div>
							</div>
							@break
						@case('profile-details')
							<div class="body-upcoming-lesson p-3 rounded-md">
								<div class="upcoming-lesson-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
									<teacher-main-profile teachers-id="{{ $teachers_id }}"></teacher-main-profile>
								</div>
							</div>
							@break
						@case('teachers-workbooks')
							<div class="body-upcoming-lesson p-3 rounded-md h-100">
								<teachers-workbooks class="h-100" workbooks="{{ $workbooks }}" teachers-id="{{ $teachers_id }}"></teachers-workbooks>
							</div>
							@break
						@default
							{{-- feeds --}}
							<teacher-feeds></teacher-feeds>
				@endswitch

				{{-- @if(!empty($messageDisplay))
					<chat-panel :messageDisplay="{{ $messageDisplay }}" :teachers-id="{{ $teachers_id ?? 0 }}" :students-id="{{ $students_id ?? 0 }}"></chat-panel>
				@elseif(!empty($teachersProfileMain))
				<div class="body-upcoming-lesson p-3 rounded-md">
					<div class="upcoming-lesson-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
						<teacher-information-main teachers-id="{{ Auth::id() }}"></teacher-information-main>
					</div>
				</div>
				@else
				<teacher-feeds></teacher-feeds>
				@endif --}}
			</div>


			{{-- right content --}}
			@if ($uri != 'teachers-workbooks')

			<div class="col-lg-3 col-md-3 offset-lg-1 pr-0">
				<div class="cont-home-works">
					<div class="head-upcoming-lesson bg-dark mb-0 pb-2 pt-3 pl-3"><h5 class="font-weight-regular">Lesson Plans <span class="float-right pr-2" style="line-height: 1.5"><i class="fas fa-chevron-right"></i></span></h5></div>
					<div class="homework-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
						<div class="card-group b-bot-red">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div>
						<div class="card-group b-bot-blue">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div>
						<div class="card-group b-bot-red">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="cont-home-works mt-4">
					<teachers-library></teachers-library>
				</div> --}}
				{{-- <div class="cont-home-works mt-4">
					<div class="head-upcoming-lesson bg-dark mb-0 pb-2 pt-3 pl-3"><h5 class="font-weight-regular">Library <span class="float-right pr-2" style="line-height: 1.5"><i class="fas fa-chevron-right"></i></span></h5></div>
					<div class="homework-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
						<div class="card-group b-bot-red">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div>
						<div class="card-group b-bot-yellow">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div>
						
					</div>
				</div> --}}

						
				<div class="cont-books-workbooks-shop mt-4">
					<div class="head-upcoming-lesson bg-dark mb-0 pb-2 pt-3 pl-3">
						<h5 class="font-weight-regular cursor" onclick="window.location.href='{{ url('teachers/teachers-workbooks') }}'">Books/Workbooks Shop 
							<span class="float-right pr-2" style="line-height: 1.5"><i class="fas fa-chevron-right"></i></span>
						</h5>
					</div>

					<div class="books-workbooks-list custom-scrollbar-css p-2 mCustomScrollbar" data-mcs-theme="minimal-dark">
						{{-- <div class="card-group b-bot-red">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div>
						<div class="card-group b-bot-yellow">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div>
						<div class="card-group b-bot-red">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Card title</h5>
									<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Last updated 3 mins ago</small>
								</div>
							</div>
						</div> --}}
						<workbook-shop></workbook-shop>
					</div>
				</div>



				</div>
				@endif

		</div>
	</div>
@endsection
