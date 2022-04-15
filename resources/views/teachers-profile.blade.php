@extends('layouts.app-teacher-dashboard')
@section('content')
	<div class="w-100 h-100 d-flex flex-column container justify-content-center align-items-center">
		<div class="row w-100 p-4">
			{{-- left content --}}
			<div class="col-lg-3 col-md-3 pr-0">

				<div class="cont-upcoming-lesson">
					{{-- <div class="form-group ico-wrapper-find">
						<i class="fas fa-search"></i>
						<input type="text" class="form-control form-control-lg find-tutor-ipt" placeholder="Find Tutor">
					</div> --}}
					<div class="head-upcoming-lesson bg-dark mb-0 pb-2 pt-3 pl-3">
            <h5 class="font-weight-regular">Teacher Profile <span class="float-right pr-2" style="line-height: 1.5"><i class="fas fa-chevron-right"></i></span></h5>
          </div>
					<div class="body-upcoming-lesson p-3">
						<label class="text-center w-100 font-weight-bold"><?php echo date('l, F, j, Y'); ?></label>
						<p class="text-center"><?php echo date('h:i A'); ?></p>
					</div>
          {{-- custom-scrollbar-css mCustomScrollbar data-mcs-theme="minimal-dark" --}}
					<div class="">
						<teacher-information :teachers-id="{{ $teachers_id ?? 0 }}" :students-id="{{ $students_id ?? 0 }}"></teacher-information>
					</div>
				</div>
			</div>

			{{-- mid content --}}

			<div class="col-lg-5 justify-content-center col-md-5 pr-2 pl-4">
        <teacher-feeds :feeds_id="{{ $feeds_id }}"></teacher-feeds>
			</div>
		</div>
	</div>
@endsection
