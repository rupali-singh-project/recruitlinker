@extends('layouts.master')

@section('content')
<div class="container-fluid page-body-wrapper">
	<div class="main-panel">
		<div class="content-wrapper">
			<div class="row">
				<div class="col-sm-6 mb-4 mb-xl-0">
					<div class="d-lg-flex align-items-center">
						<div>
							<h3 class="text-dark font-weight-bold mb-2">Dashboard</h3>


						</div>

					</div>
				</div>

			</div>
			<div class="row ">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card" style="height:430px;">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-4">
									<div class="chartjs-size-monitor">
										<div class="chartjs-size-monitor-expand">
											<div class=""></div>
										</div>
										<div class="chartjs-size-monitor-shrink">
											<div class=""></div>
										</div>
									</div>
									<h4 class="card-title">Candidate Status</h4>
									<div id="studentStatusChart" style="height:300px;"></div>
								</div>
								<div class="col-lg-5">
									<h4 class="card-title">Top 10 Trending Jobs</h4>
									<div class="row">
										<div class="col-sm-12 pr-0">
											<ul class="graphl-legend-rectangle">
												@foreach($trendingJobs as $job)
												<li><i class="mdi mdi-clipboard-check" style="font-size:20px; color:#46c35f;"></i>&nbsp;</span>{{$job->job_title}}
												</li>
												@endforeach
											</ul>
										</div>

									</div>

								</div>
								<div class="col-lg-3">
									<h4 class="card-title">Weekely Joind Users</h4>
									<div class="row">
										<div class="col-sm-12">
											<div class="card mb-5" style="background-color:#FFF7F1;">
												<div class="card-body p-2">
													<div class="row">
														<div class="col-6">
															<i class="mdi mdi-account-check" style="font-size:30px;color:#E91E63;"></i>
														</div>
														<div class="col-6">
															<h5 class="text-dark mb-2 font-weight-bold">{{$total_jobs}}</h5>
															<h4 class="card-title mb-2">Total Jobs</h4>
														</div>
													</div>
												</div>
											</div>
											<div class="card mb-5" style="background-color:#E1F0DA;">
												<div class="card-body p-2">
													<div class="row">
														<div class="col-6">
															<i class="mdi mdi-account-check" style="font-size:30px;color:#58d8a3;"></i>
														</div>
														<div class="col-6">
															<h5 class="text-dark mb-2 font-weight-bold">{{$total_jobs_active}}</h5>
															<h4 class="card-title mb-2">Active Jobs</h4>
														</div>
													</div>
												</div>
											</div>

											<div class="card " style="background-color:#F8FAE5;">
												<div class="card-body p-2">
													<div class="row">
														<div class="col-6">
															<i class="mdi mdi-account-check" style="font-size:30px;color:#6a008a;"></i>
														</div>
														<div class="col-6">
															<h5 class="text-dark mb-2 font-weight-bold">{{$total_jobs_inactive}}</h5>
															<h4 class="card-title mb-2">In-active jobs</h4>
														</div>
													</div>
												</div>
											</div>

										</div>
										<div class="col-sm-12">
											<ul class="graphl-legend-rectangle">
												@foreach($mostHiringByCompanies as $hiringData)
												@php
												$totalJobs = $total_jobs;
												$percentage = round(($hiringData->total)*100/$totalJobs,2);
												@endphp
												<li>
													<span class="bg-success"></span>{{$hiringData->company_name}}
													({{$percentage}}%)
												</li>

												@endforeach
											</ul>
										</div>
									</div>

								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
			<div class="row">
				<div class="col-sm-8 flex-column d-flex stretch-card">
					<div class="row">
						<div class="col-lg-4 d-flex grid-margin stretch-card">
							<div class="card" style="background-color:#E91E63;">
								<div class="card-body text-white">
									<h3 class="font-weight-bold mb-3">{{$total_hr}}</h3>
									<div class="progress mb-3">
										<div class="progress-bar  bg-warning" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>

									</div>
									<p class="pb-0 mb-0">Total Human Resources</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 d-flex grid-margin stretch-card">
							<div class="card sale-diffrence-border">
								<div class="card-body">
									<h2 class="text-dark mb-2 font-weight-bold">{{$total_companies}}</h2>
									<h4 class="card-title mb-2">Total Company</h4>
									<!--<small class="text-muted">APRIL 2019</small>-->
								</div>
							</div>
						</div>
						<div class="col-lg-4 d-flex grid-margin stretch-card">
							<div class="card sale-visit-statistics-border">
								<div class="card-body">
									<h2 class="text-dark mb-2 font-weight-bold">{{$total_students}}</h2>
									<h4 class="card-title mb-2">Total Candidates</h4>
									<!--<small class="text-muted">APRIL 2019</small>-->
								</div>
							</div>
						</div>
					</div>
					<div class="row">

						<div class="col-sm-12 grid-margin d-flex stretch-card">
							<div class="card">
								<div class="card-body">
									<div class="d-flex align-items-center justify-content-between">
										<h4 class="card-title mb-2">Company Wise Jobs</h4>
										<div class="dropdown">
											<a href="#" class="text-success btn btn-link  px-1"><i class="mdi mdi-refresh"></i></a>
											<a href="#" class="text-success btn btn-link px-1 dropdown-toggle dropdown-arrow-none" data-bs-toggle="dropdown" id="settingsDropdownsales">
												<i class="mdi mdi-dots-horizontal"></i></a>
											<!--<div class="dropdown-menu dropdown-menu-right navbar-dropdown"
												aria-labelledby="settingsDropdownsales">
												<a class="dropdown-item">
													<i class="mdi mdi-grease-pencil text-primary"></i>
													Edit
												</a>
												<a class="dropdown-item">
													<i class="mdi mdi-delete text-primary"></i>
													Delete
												</a>
											</div>-->
										</div>
									</div>
									<div>

										<div class="tab-content tab-no-active-fill-tab-content">
											<div class="tab-pane fade show active" id="revenue-for-last-month" role="tabpanel" aria-labelledby="revenue-for-last-month-tab">
												<div class="chartjs-size-monitor">
													<div class="chartjs-size-monitor-expand">
														<div class=""></div>

													</div>
													<div class="chartjs-size-monitor-shrink">
														<div class=""></div>
													</div>
												</div>
												<div class="d-lg-flex justify-content-between">

												</div>

												<div id="comWiseJobs" style="height:460px;"></div>
											</div>


										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 flex-column d-flex stretch-card">
					<div class="row flex-grow">
						<div class="col-sm-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-8">
											<h3 class="font-weight-bold text-dark">Company Agreement Status</h3>
											<!--<p class="text-dark">Monday 3.00 PM</p>-->
											<div class="d-lg-flex align-items-baseline mb-3">

											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-sm-12 mt-4 mt-lg-0">

											<div id="company_Agree_status" style="height:250px;">

											</div>
										</div>
									</div>
									<!--<div class="row pt-3 mt-md-1">
										<div class="col">
											<div class="d-flex purchase-detail-legend align-items-center">
												<div id="circleProgress1" class="p-2"><svg viewBox="0 0 100 100"
														style="display: block; width: 100%;">
														<path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90"
															stroke="#eee" stroke-width="10" fill-opacity="0"></path>
														<path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90"
															stroke="#0aadfe" stroke-width="10" fill-opacity="0"
															style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 231.882;">
														</path>
													</svg></div>
												<div>
													<p class="font-weight-medium text-dark text-small">Sessions</p>
													<h3 class="font-weight-bold text-dark  mb-0">26.80%</h3>
												</div>
											</div>
										</div>
										<div class="col">
											<div class="d-flex purchase-detail-legend align-items-center">
												<div id="circleProgress2" class="p-2"><svg viewBox="0 0 100 100"
														style="display: block; width: 100%;">
														<path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90"
															stroke="#eee" stroke-width="10" fill-opacity="0"></path>
														<path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90"
															stroke="#fa424a" stroke-width="10" fill-opacity="0"
															style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 180.981;">
														</path>
													</svg></div>
												<div>
													<p class="font-weight-medium text-dark text-small">Users</p>
													<h3 class="font-weight-bold text-dark  mb-0">56.80%</h3>
												</div>
											</div>
										</div>
									</div>-->
								</div>
							</div>
						</div>
						<div class="col-sm-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-sm-12">
											<div class="chartjs-size-monitor">
												<div class="chartjs-size-monitor-expand">
													<div class=""></div>
												</div>
												<div class="chartjs-size-monitor-shrink">
													<div class=""></div>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between">
												<h4 class="card-title mb-0">Candidate Paid Status</h4>
												<!--<div class="dropdown">
													<a href="#" class="text-success btn btn-link  px-1"><i
															class="mdi mdi-refresh"></i></a>
													<a href="#"
														class="text-success btn btn-link px-1 dropdown-toggle dropdown-arrow-none"
														data-bs-toggle="dropdown" id="profileDropdownvisittoday"><i
															class="mdi mdi-dots-horizontal"></i></a>
													<div class="dropdown-menu dropdown-menu-right navbar-dropdown"
														aria-labelledby="profileDropdownvisittoday">
														<a class="dropdown-item">
															<i class="mdi mdi-grease-pencil text-primary"></i>
															Edit
														</a>
														<a class="dropdown-item">
															<i class="mdi mdi-delete text-primary"></i>
															Delete
														</a>
													</div>
												</div>-->
											</div>

											<div class="d-lg-flex align-items-center justify-content-between">

												<!--<div class="mb-3">
													<button type="button"
														class="btn btn-outline-light text-dark font-weight-normal">Day</button>
													<button type="button"
														class="btn btn-outline-light text-dark font-weight-normal">Month</button>
												</div>-->
											</div>

											<div id="paidStatus" style="height:300px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--<div class="row">
				<div class="col-lg-2 grid-margin stretch-card">
					<div class="card">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<div class="card-body pb-0">
							<div class="d-flex align-items-center justify-content-between">
								<h2 class="text-success font-weight-bold">18390</h2>
								<i class="mdi mdi-account-outline mdi-18px text-dark"></i>
							</div>
						</div>
						<canvas id="newClient" width="1021" height="507"
							style="display: block; height: 338px; width: 681px;"
							class="chartjs-render-monitor"></canvas>
						<div class="line-chart-row-title">MY NEW CLIENTS</div>
					</div>
				</div>
				<div class="col-lg-2 grid-margin stretch-card">
					<div class="card">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<div class="card-body pb-0">
							<div class="d-flex align-items-center justify-content-between">
								<h2 class="text-danger font-weight-bold">839</h2>
								<i class="mdi mdi-refresh mdi-18px text-dark"></i>
							</div>
						</div>
						<canvas id="allProducts" width="1021" height="507"
							style="display: block; height: 338px; width: 681px;"
							class="chartjs-render-monitor"></canvas>
						<div class="line-chart-row-title">All Products</div>
					</div>
				</div>
				<div class="col-lg-2 grid-margin stretch-card">
					<div class="card">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<div class="card-body pb-0">
							<div class="d-flex align-items-center justify-content-between">
								<h2 class="text-info font-weight-bold">244</h2>
								<i class="mdi mdi-file-document-outline mdi-18px text-dark"></i>
							</div>
						</div>
						<canvas id="invoices" width="1021" height="507"
							style="display: block; height: 338px; width: 681px;"
							class="chartjs-render-monitor"></canvas>
						<div class="line-chart-row-title">NEW INVOICES</div>
					</div>
				</div>
				<div class="col-lg-2 grid-margin stretch-card">
					<div class="card">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<div class="card-body pb-0">
							<div class="d-flex align-items-center justify-content-between">
								<h2 class="text-warning font-weight-bold">3259</h2>
								<i class="mdi mdi-folder-outline mdi-18px text-dark"></i>
							</div>
						</div>
						<canvas id="projects" width="1021" height="507"
							style="display: block; height: 338px; width: 681px;"
							class="chartjs-render-monitor"></canvas>
						<div class="line-chart-row-title">All PROJECTS</div>
					</div>
				</div>
				<div class="col-lg-2 grid-margin stretch-card">
					<div class="card">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<div class="card-body pb-0">
							<div class="d-flex align-items-center justify-content-between">
								<h2 class="text-secondary font-weight-bold">586</h2>
								<i class="mdi mdi-cart-outline mdi-18px text-dark"></i>
							</div>
						</div>
						<canvas id="orderRecieved" width="1021" height="507"
							style="display: block; height: 338px; width: 681px;"
							class="chartjs-render-monitor"></canvas>
						<div class="line-chart-row-title">Orders Received</div>
					</div>
				</div>
				<div class="col-lg-2 grid-margin stretch-card">
					<div class="card">
						<div class="chartjs-size-monitor">
							<div class="chartjs-size-monitor-expand">
								<div class=""></div>
							</div>
							<div class="chartjs-size-monitor-shrink">
								<div class=""></div>
							</div>
						</div>
						<div class="card-body pb-0">
							<div class="d-flex align-items-center justify-content-between">
								<h2 class="text-dark font-weight-bold">7826</h2>
								<i class="mdi mdi-cash text-dark mdi-18px"></i>
							</div>
						</div>
						<canvas id="transactions" width="1021" height="507"
							style="display: block; height: 338px; width: 681px;"
							class="chartjs-render-monitor"></canvas>
						<div class="line-chart-row-title">TRANSACTIONS</div>
					</div>
				</div>
			</div>-->
			<!--<div class="row">
				<div class="col-sm-6 grid-margin grid-margin-md-0 stretch-card">
					<div class="card">
						<div class="card-body">
							<div class="chartjs-size-monitor">
								<div class="chartjs-size-monitor-expand">
									<div class=""></div>
								</div>
								<div class="chartjs-size-monitor-shrink">
									<div class=""></div>
								</div>
							</div>
							<div class="d-flex align-items-center justify-content-between">
								<h4 class="card-title">Support Tracker</h4>
								<h4 class="text-success font-weight-bold">Tickets<span class="text-dark ms-3">163</span>
								</h4>
							</div>
							<div id="support-tracker-legend" class="support-tracker-legend">
								<ul class="13-legend">
									<li><span class="legend-box" style="background:#464dee;"></span><span
											class="legend-label text-dark">New Tickets</span></li>
									<li><span class="legend-box" style="background:#d8d8d8;"></span><span
											class="legend-label text-dark">Open Tickets</span></li>
								</ul>
							</div>
							<canvas id="supportTracker" width="417" height="208"
								style="display: block; height: 139px; width: 278px;"
								class="chartjs-render-monitor"></canvas>
						</div>
					</div>
				</div>
				<div class="col-sm-6 grid-margin grid-margin-md-0 stretch-card">
					<div class="card">
						<div class="card-body">
							<div class="d-lg-flex align-items-center justify-content-between mb-4">
								<h4 class="card-title">Product Orders</h4>
								<p class="text-dark">+5.2% vs last 7 days</p>
							</div>
							<div class="product-order-wrap padding-reduced">
								<div id="productorder-gage" class="gauge productorder-gage"><svg height="100%"
										version="1.1" width="100%" xmlns="http://www.w3.org/2000/svg"
										xmlns:xlink="http://www.w3.org/1999/xlink"
										style="overflow: hidden; position: relative; left: -0.666687px; top: -0.583374px;"
										viewBox="0 0 200 150" preserveAspectRatio="xMidYMid meet">
										<desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with
											Raphaël 2.1.4</desc>
										<defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
											<filter id="inner-shadow-productorder-gage">
												<feOffset dx="0" dy="3"></feOffset>
												<feGaussianBlur result="offset-blur" stdDeviation="5"></feGaussianBlur>
												<feComposite operator="out" in="SourceGraphic" in2="offset-blur"
													result="inverse"></feComposite>
												<feFlood flood-color="black" flood-opacity="0.2" result="color">
												</feFlood>
												<feComposite operator="in" in="color" in2="inverse" result="shadow">
												</feComposite>
												<feComposite operator="over" in="shadow" in2="SourceGraphic">
												</feComposite>
											</filter>
										</defs>
										<path fill="#f0f0f0" stroke="none"
											d="M33.4375,120L25,120A75,75,0,0,1,175,120L166.5625,120A66.5625,66.5625,0,0,0,33.4375,120Z"
											style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"
											filter="url(#inner-shadow-productorder-gage)"></path>
										<path fill="#fcd53b" stroke="none"
											d="M33.4375,120L25,120A75,75,0,0,1,133.83918133313838,53.067871640721165L130.0322734331603,60.59773608114003A66.5625,66.5625,0,0,0,33.4375,120Z"
											style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"
											filter="url(#inner-shadow-productorder-gage)"></path><text x="100"
											y="23.4375" text-anchor="middle" font-family="sans-serif" font-size="15px"
											stroke="none" fill="#999999"
											style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 15px; font-weight: bold; fill-opacity: 1;"
											font-weight="bold" fill-opacity="1">
											<tspan dy="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
											</tspan>
										</text><text x="100" y="117.64705882352942" text-anchor="middle"
											font-family="Arial" font-size="23px" stroke="none" fill="#001737"
											style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 23px; font-weight: bold; fill-opacity: 1;"
											font-weight="bold" fill-opacity="1">
											<tspan dy="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3245K
											</tspan>
										</text><text x="100" y="134.18552036199097" text-anchor="middle"
											font-family="Arial" font-size="10px" stroke="none" fill="#001737"
											style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 10px; font-weight: normal; fill-opacity: 1;"
											font-weight="normal" fill-opacity="1">
											<tspan dy="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">You
												have done 57.6% more ordes today</tspan>
										</text><text x="29.21875" y="134.18552036199097" text-anchor="middle"
											font-family="Arial" font-size="10px" stroke="none" fill="#001737"
											style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 10px; font-weight: normal; fill-opacity: 0;"
											font-weight="normal" fill-opacity="0">
											<tspan dy="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0
											</tspan>
										</text><text x="170.78125" y="134.18552036199097" text-anchor="middle"
											font-family="Arial" font-size="10px" stroke="none" fill="#001737"
											style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 10px; font-weight: normal; fill-opacity: 0;"
											font-weight="normal" fill-opacity="0">
											<tspan dy="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5000
											</tspan>
										</text>
									</svg>
									<div class="product-order">
										<div class="icon-inside-circle"><i class="mdi mdi-basket"></i></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>-->
		</div>
		<!-- content-wrapper ends -->
		<!-- partial:partials/_footer.html -->

		<!-- partial -->
	</div>
	<!-- main-panel ends -->
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/11.3.0/highcharts.js" integrity="sha512-YaS2hEb1tgmo/a5e+KBxGW3PQLKsCIM0UaTaC3Ll1BYSIMk8VqCasxsUh5AvfYCKi5rOwJ4o74cY0xmWJCupmg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/11.3.0/highcharts-3d.min.js" integrity="sha512-snBJUvuuTT6OQKmPMBmSnorOEtH0FqUVBKpu/j2pPirzFz3F8j4ynSSevImPgrdMTUkC2DMQpZ76cD6nnF2ZkA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/11.3.0/highcharts.src.min.js" integrity="sha512-hCToekXhgmKcmHY4mTl1HWfD8rvZcc7EjQRzJYeNC0+RKtjarSl+FDQ2BiFwqrSeoVhEEXVXw7rowzMufa22iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(function() {
		var salesDifferencedata = {
			labels: ["50+", "35-50", "25-35", "18-25", "0-18"],
			datasets: [{
				label: 'Best Sellers',
				data: [{{$companySizeChart->employees_1_5}},
					{{$companySizeChart->employees_5_20}},
					{{$companySizeChart->employees_20_50}},
					{{$companySizeChart->employees_50_100}},
					{{$companySizeChart->employees_100_plus}}
				],
				backgroundColor: [
					'#8169f2',
					'#6a4df5',
					'#4f2def',
					'#2b0bc5',
					'#180183',
				],
				borderColor: [
					'#8169f2',
					'#6a4df5',
					'#4f2def',
					'#2b0bc5',
					'#180183',
				],
				borderWidth: 2,
				fill: false
			}],
		};
		var salesDifferenceOptions = {
			scales: {
				xAxes: [{
					position: 'bottom',
					display: false,
					gridLines: {
						display: false,
						drawBorder: true,
					},
					ticks: {
						display: false, //this will remove only the label
						beginAtZero: true
					}
				}],
				yAxes: [{
					display: true,
					gridLines: {
						drawBorder: true,
						display: false,
					},
					ticks: {
						beginAtZero: true
					},
				}]
			},
			legend: {
				display: false
			},
			credits: {
				enabled: false
			},
			tooltips: {
				show: false,
				backgroundColor: 'rgba(31, 59, 179, 1)',
			},
			plugins: {
				datalabels: {
					display: true,
					align: 'start',
					color: 'white',
				}
			}

		};
		if ($("#companySizeChart").length) {
			var barChartCanvas = $("#companySizeChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var barChart = new Chart(barChartCanvas, {
				type: 'horizontalBar',
				data: salesDifferencedata,
				options: salesDifferenceOptions,

			});
		}
	});

	// Trending Jobs Chart
	var bestSellersData = {
		datasets: [{
			data: [
				@foreach($trendingJobs as $job) {
					{
						$job - > total
					}
				},
				@endforeach
			],
			@php
			$colorArr = [
				'#ee5b5b',
				'#fcd53b',
				'#0bdbb8',
				'#464dee',
				'#0ad7f7'
			];
			@endphp
			backgroundColor: [
				@foreach($trendingJobs as $job)
				'{{$colorArr[$loop->iteration - 1]}}',
				@endforeach
			],
			borderColor: [
				@foreach($trendingJobs as $job)
				'{{$colorArr[$loop->iteration - 1]}}',
				@endforeach
			],
		}],
		// These labels appear in the legend and in the tooltips when hovering different arcs
		labels: [
			@foreach($trendingJobs as $job)
			'{{$job->job_title}}',
			@endforeach
		]
	};
	var bestSellersOptions = {
		responsive: true,
		cutoutPercentage: 80,
		legend: {
			display: false,
		},
		animation: {
			animateScale: true,
			animateRotate: true
		},
		plugins: {
			datalabels: {
				display: false,
				align: 'center',
				anchor: 'center'
			}
		}

	};
	if ($("#bestSellers").length) {
		var pieChartCanvas = $("#bestSellers").get(0).getContext("2d");
		var pieChart = new Chart(pieChartCanvas, {
			type: 'doughnut',
			data: bestSellersData,
			options: bestSellersOptions
		});
	}
</script>
<script>
	(function(H) {
		H.seriesTypes.pie.prototype.animate = function(init) {
			const series = this,
				chart = series.chart,
				points = series.points,
				{
					animation
				} = series.options,
				{
					startAngleRad
				} = series;

			function fanAnimate(point, startAngleRad) {
				const graphic = point.graphic,
					args = point.shapeArgs;

				if (graphic && args) {

					graphic
						// Set inital animation values
						.attr({
							start: startAngleRad,
							end: startAngleRad,
							opacity: 1
						})
						// Animate to the final position
						.animate({
							start: args.start,
							end: args.end
						}, {
							duration: animation.duration / points.length
						}, function() {
							// On complete, start animating the next point
							if (points[point.index + 1]) {
								fanAnimate(points[point.index + 1], args.end);
							}
							// On the last point, fade in the data labels, then
							// apply the inner size
							if (point.index === series.points.length - 1) {
								series.dataLabelsGroup.animate({
										opacity: 1
									},
									void 0,
									function() {
										points.forEach(point => {
											point.opacity = 1;
										});
										series.update({
											enableMouseTracking: true
										}, false);
										chart.update({
											plotOptions: {
												pie: {
													innerSize: '40%',
													borderRadius: 8
												}
											}
										});
									});
							}
						});
				}
			}

			if (init) {
				// Hide points on init
				points.forEach(point => {
					point.opacity = 0;
				});
			} else {
				fanAnimate(points[0], startAngleRad);
			}
		};
	}(Highcharts));

	Highcharts.chart('studentStatusChart', {
		chart: {
			type: 'pie'
		},
		title: {
			text: '',
			align: 'left'
		},
		credits: {
			enabled: false
		},
		subtitle: {
			text: '',
			align: 'left'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				borderWidth: 2,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b><br>{point.percentage}%',
					distance: 20
				}
			}
		},
		series: [{
			// Disable mouse tracking on load, enable after custom animation
			enableMouseTracking: false,
			animation: {
				duration: 2000
			},
			colorByPoint: true,
			data: [
				@foreach($studentStatus as $stuStatus) {
					name: '{{$stuStatus->jobStatus}}',
					y: {{$stuStatus -> total}}
				},
				@endforeach
			]
		}]
	});
</script>
<script>
	// Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

	// Create the chart
	Highcharts.chart('comWiseJobs', {
		chart: {
			type: 'column'
		},
		title: {
			align: 'left',
			text: ''
		},
		credits: {
			enabled: false
		},
		subtitle: {
			align: 'left',
			text: ''
		},
		accessibility: {
			announceNewData: {
				enabled: true
			}
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: 'Total'
			}

		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					format: '{point.y}'
				}
			}
		},

		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
		},

		series: [{
			name: 'Jobs',
			colorByPoint: true,
			data: [
				@foreach($companyWiseJobs as $companyJobs) {
					name: '{{$companyJobs->company_name}}',
					y: {
						{
							$companyJobs - > total
						}
					},
					drilldown: '{{$companyJobs->company_name}}'
				},
				@endforeach

			]
		}],

	});
</script>
<script>
	(function(H) {
		H.seriesTypes.pie.prototype.animate = function(init) {
			const series = this,
				chart = series.chart,
				points = series.points,
				{
					animation
				} = series.options,
				{
					startAngleRad
				} = series;

			function fanAnimate(point, startAngleRad) {
				const graphic = point.graphic,
					args = point.shapeArgs;

				if (graphic && args) {

					graphic
						// Set inital animation values
						.attr({
							start: startAngleRad,
							end: startAngleRad,
							opacity: 1
						})
						// Animate to the final position
						.animate({
							start: args.start,
							end: args.end
						}, {
							duration: animation.duration / points.length
						}, function() {
							// On complete, start animating the next point
							if (points[point.index + 1]) {
								fanAnimate(points[point.index + 1], args.end);
							}
							// On the last point, fade in the data labels, then
							// apply the inner size
							if (point.index === series.points.length - 1) {
								series.dataLabelsGroup.animate({
										opacity: 1
									},
									void 0,
									function() {
										points.forEach(point => {
											point.opacity = 1;
										});
										series.update({
											enableMouseTracking: true
										}, false);
										chart.update({
											plotOptions: {
												pie: {
													innerSize: '40%',
													borderRadius: 8
												}
											}
										});
									});
							}
						});
				}
			}

			if (init) {
				// Hide points on init
				points.forEach(point => {
					point.opacity = 0;
				});
			} else {
				fanAnimate(points[0], startAngleRad);
			}
		};
	}(Highcharts));

	Highcharts.chart('paidStatus', {
		chart: {
			type: 'pie'
		},
		title: {
			text: '',
			align: 'left'
		},
		credits: {
			enabled: false
		},
		subtitle: {
			text: '',
			align: 'left'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				borderWidth: 2,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b><br>{point.percentage}%',
					distance: 20
				}
			}
		},
		series: [{
			// Disable mouse tracking on load, enable after custom animation
			enableMouseTracking: false,
			animation: {
				duration: 2000
			},
			colorByPoint: true,
			data: [

				{
					name: 'Paid',
					y: {
						{
							$paid_student_count
						}
					},
					color: '#0ddbb9'
				}, {
					name: 'Unpaid',
					y: {
						{
							$unpaid_student_count
						}
					},
					color: '#ee5b5b'
				},

			]
		}]
	});
</script>
<script>
	(function(H) {
		H.seriesTypes.pie.prototype.animate = function(init) {
			const series = this,
				chart = series.chart,
				points = series.points,
				{
					animation
				} = series.options,
				{
					startAngleRad
				} = series;

			function fanAnimate(point, startAngleRad) {
				const graphic = point.graphic,
					args = point.shapeArgs;

				if (graphic && args) {

					graphic
						// Set inital animation values
						.attr({
							start: startAngleRad,
							end: startAngleRad,
							opacity: 1
						})
						// Animate to the final position
						.animate({
							start: args.start,
							end: args.end
						}, {
							duration: animation.duration / points.length
						}, function() {
							// On complete, start animating the next point
							if (points[point.index + 1]) {
								fanAnimate(points[point.index + 1], args.end);
							}
							// On the last point, fade in the data labels, then
							// apply the inner size
							if (point.index === series.points.length - 1) {
								series.dataLabelsGroup.animate({
										opacity: 1
									},
									void 0,
									function() {
										points.forEach(point => {
											point.opacity = 1;
										});
										series.update({
											enableMouseTracking: true
										}, false);
										chart.update({
											plotOptions: {
												pie: {
													innerSize: '40%',
													borderRadius: 8
												}
											}
										});
									});
							}
						});
				}
			}

			if (init) {
				// Hide points on init
				points.forEach(point => {
					point.opacity = 0;
				});
			} else {
				fanAnimate(points[0], startAngleRad);
			}
		};
	}(Highcharts));

	Highcharts.chart('company_Agree_status', {
		chart: {
			type: 'pie'
		},
		title: {
			text: '',
			align: 'left'
		},
		credits: {
			enabled: false
		},
		subtitle: {
			text: '',
			align: 'left'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				borderWidth: 2,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b><br>{point.percentage}%',
					distance: 20
				}
			}
		},
		series: [{
			// Disable mouse tracking on load, enable after custom animation
			enableMouseTracking: false,
			animation: {
				duration: 2000
			},
			colorByPoint: true,
			data: [

				{
					name: 'Agreement done',
					y: {{$paid_company_count}},
					color: '#0ddbb9'
				}, {
					name: 'Agreement not done',
					y: {{$unpaid_company_count}},
					color: '#ee5b5b'
				},

			]
		}]
	});
</script>
@endsection