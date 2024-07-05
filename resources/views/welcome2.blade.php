@extends('layouts.master')

@section('content')
<div class="content-wrapper">
					
					<div class="row mt-4">
						<div class="col-lg-8 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
											<h4 class="card-title">Sales Difference</h4>
											<canvas id="salesDifference" width="213" height="106" style="display: block; height: 85px; width: 171px;" class="chartjs-render-monitor"></canvas>
											<p class="mt-3 mb-4 mb-lg-0">Lorem ipsum dolor sit amet,
												consectetur adipisicing elit.
											</p>
										</div>
										<div class="col-lg-5">
											<h4 class="card-title">Best Sellers</h4>
											<div class="row">
												<div class="col-sm-4">
													<ul class="graphl-legend-rectangle">
														<li><span class="bg-danger"></span>Automotive</li>
														<li><span class="bg-warning"></span>Books</li>
														<li><span class="bg-info"></span>Software</li>
														<li><span class="bg-success"></span>Video games</li>
													</ul>
												</div>
												<div class="col-sm-8 grid-margin"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
													<canvas id="bestSellers" width="172" height="86" style="display: block; height: 69px; width: 138px;" class="chartjs-render-monitor"></canvas>
												</div>
											</div>
											<p class="mt-3 mb-4 mb-lg-0">Lorem ipsum dolor sit amet,
												consectetur adipisicing elit.
											</p>
										</div>
										<div class="col-lg-3">
											<h4 class="card-title">Social Media Statistics</h4>
											<div class="row">
												<div class="col-sm-12">
													<div class="progress progress-lg grouped mb-2">
														<div class="progress-bar  bg-danger" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-sm-12">
													<ul class="graphl-legend-rectangle">
														<li><span class="bg-danger"></span>Instagram (15%)</li>
														<li><span class="bg-warning"></span>Facebook (20%)</li>
														<li><span class="bg-info"></span>Website (25%)</li>
														<li><span class="bg-success"></span>Youtube (40%)</li>
													</ul>
												</div>
											</div>
											<p class="mb-0 mt-2">Lorem ipsum dolor sit amet,
												consectetur adipisicing elit.
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-3 mb-lg-0">
                            <div class="card mb-4">
								<div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
									<div class="d-flex align-items-center justify-content-between">
										<h4 class="card-title">Support Tracker</h4>
										<h4 class="text-success font-weight-bold">Tickets<span class="text-dark ms-3">163</span></h4>
									</div>
									<div id="support-tracker-legend" class="support-tracker-legend"><ul class="13-legend"><li><span class="legend-box" style="background:#464dee;"></span><span class="legend-label text-dark">New Tickets</span></li><li><span class="legend-box" style="background:#d8d8d8;"></span><span class="legend-label text-dark">Open Tickets</span></li></ul></div>
									<canvas id="supportTracker" width="508" height="253" style="display: block; height: 203px; width: 407px;" class="chartjs-render-monitor"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8 flex-column d-flex stretch-card">
							<div class="row">
								<div class="col-lg-4 d-flex grid-margin stretch-card">
									<div class="card bg-primary">
										<div class="card-body text-white">
											<h3 class="font-weight-bold mb-3">18,39 (75GB)</h3>
											<div class="progress mb-3">
												<div class="progress-bar  bg-warning" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
											<p class="pb-0 mb-0">Bandwidth usage</p>
										</div>
									</div>
								</div>
								<div class="col-lg-4 d-flex grid-margin stretch-card">
									<div class="card sale-diffrence-border">
										<div class="card-body">
											<h2 class="text-dark mb-2 font-weight-bold">$6475</h2>
											<h4 class="card-title mb-2">Sales Difference</h4>
											<small class="text-muted">APRIL 2019</small>
										</div>
									</div>
								</div>
								<div class="col-lg-4 d-flex grid-margin stretch-card">
									<div class="card sale-visit-statistics-border">
										<div class="card-body">
											<h2 class="text-dark mb-2 font-weight-bold">$3479</h2>
											<h4 class="card-title mb-2">Visit Statistics</h4>
											<small class="text-muted">APRIL 2019</small>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 grid-margin d-flex stretch-card">
									<div class="card">
										<div class="card-body">
											<div class="d-flex align-items-center justify-content-between">
												<h4 class="card-title mb-2">Sales Difference</h4>
												<div class="dropdown">
													<a href="#" class="text-success btn btn-link  px-1"><i class="mdi mdi-refresh"></i></a>
													<a href="#" class="text-success btn btn-link px-1 dropdown-toggle dropdown-arrow-none" data-bs-toggle="dropdown" id="settingsDropdownsales">
														<i class="mdi mdi-dots-horizontal"></i></a>
														<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="settingsDropdownsales">
															<a class="dropdown-item">
																<i class="mdi mdi-grease-pencil text-primary"></i>
																Edit
															</a>
															<a class="dropdown-item">
																<i class="mdi mdi-delete text-primary"></i>
																Delete
															</a>
														</div>
												</div>
											</div>
											<div>
												<ul class="nav nav-tabs tab-no-active-fill" role="tablist">
													<li class="nav-item">
														<a class="nav-link active ps-2 pe-2" id="revenue-for-last-month-tab" data-bs-toggle="tab" href="#revenue-for-last-month" role="tab" aria-controls="revenue-for-last-month" aria-selected="true">Revenue for last month</a>
													</li>
													<li class="nav-item">
														<a class="nav-link ps-2 pe-2" id="server-loading-tab" data-bs-toggle="tab" href="#server-loading" role="tab" aria-controls="server-loading" aria-selected="false">Server loading</a>
													</li>
													<li class="nav-item">
														<a class="nav-link ps-2 pe-2" id="data-managed-tab" data-bs-toggle="tab" href="#data-managed" role="tab" aria-controls="data-managed" aria-selected="false">Data managed</a>
													</li>
													<li class="nav-item">
														<a class="nav-link ps-2 pe-2" id="sales-by-traffic-tab" data-bs-toggle="tab" href="#sales-by-traffic" role="tab" aria-controls="sales-by-traffic" aria-selected="false">Sales by traffic</a>
													</li>
												</ul>
												<div class="tab-content tab-no-active-fill-tab-content">
													<div class="tab-pane fade show active" id="revenue-for-last-month" role="tabpanel" aria-labelledby="revenue-for-last-month-tab"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
														<div class="d-lg-flex justify-content-between">
															<p class="mb-4">+5.2% vs last 7 days</p>
															<div id="revenuechart-legend" class="revenuechart-legend"><ul class="2-legend"><li><span class="legend-box" style="background:#0ddbb9;"></span><span class="legend-label" style="">Margin</span></li><li><span class="legend-box" style="background:#464dee;"></span><span class="legend-label" style="">Product</span></li><li><span class="legend-box" style="background:#ee5b5b;"></span><span class="legend-label" style="">Cost</span></li></ul></div>
														</div>
														<canvas id="revenue-for-last-month-chart" width="716" height="357" style="display: block; height: 286px; width: 573px;" class="chartjs-render-monitor"></canvas>
													</div>
													<div class="tab-pane fade" id="server-loading" role="tabpanel" aria-labelledby="server-loading-tab">
														<div class="d-flex justify-content-between">
															<p class="mb-4">+5.2% vs last 7 days</p>
															<div id="serveLoading-legend" class="revenuechart-legend"><ul class="3-legend"><li><span class="legend-box" style="background:#0ddbb9;"></span><span class="legend-label" style="">Margin</span></li><li><span class="legend-box" style="background:#464dee;"></span><span class="legend-label" style="">Product</span></li><li><span class="legend-box" style="background:#ee5b5b;"></span><span class="legend-label" style="">Cost</span></li></ul></div>
														</div>
														<canvas id="serveLoading" height="0" width="0" class="chartjs-render-monitor" style="display: block; height: 0px; width: 0px;"></canvas>
													</div>
													<div class="tab-pane fade" id="data-managed" role="tabpanel" aria-labelledby="data-managed-tab">
														<div class="d-flex justify-content-between">
															<p class="mb-4">+5.2% vs last 7 days</p>
															<div id="dataManaged-legend" class="revenuechart-legend"><ul class="4-legend"><li><span class="legend-box" style="background:#0ddbb9;"></span><span class="legend-label" style="">Margin</span></li><li><span class="legend-box" style="background:#464dee;"></span><span class="legend-label" style="">Product</span></li><li><span class="legend-box" style="background:#ee5b5b;"></span><span class="legend-label" style="">Cost</span></li></ul></div>
														</div>
														<canvas id="dataManaged" height="0" width="0" class="chartjs-render-monitor" style="display: block; height: 0px; width: 0px;"></canvas>
													</div>
													<div class="tab-pane fade" id="sales-by-traffic" role="tabpanel" aria-labelledby="sales-by-traffic-tab">
														<div class="d-flex justify-content-between">
															<p class="mb-4">+5.2% vs last 7 days</p>
															<div id="salesTrafic-legend" class="revenuechart-legend"><ul class="5-legend"><li><span class="legend-box" style="background:#0ddbb9;"></span><span class="legend-label" style="">Margin</span></li><li><span class="legend-box" style="background:#464dee;"></span><span class="legend-label" style="">Product</span></li><li><span class="legend-box" style="background:#ee5b5b;"></span><span class="legend-label" style="">Cost</span></li></ul></div>
														</div>
														<canvas id="salesTrafic" height="0" width="0" class="chartjs-render-monitor" style="display: block; height: 0px; width: 0px;"></canvas>
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
													<h3 class="font-weight-bold text-dark">Canada,Ontario</h3>
													<p class="text-dark">Monday 3.00 PM</p>
													<div class="d-lg-flex align-items-baseline mb-3">
														<h1 class="text-dark font-weight-bold">23<sup class="font-weight-light"><small>o</small><small class="font-weight-medium">c</small></sup></h1>
														<p class="text-muted ms-3">Partly cloudy</p>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="position-relative">
														<img src="images/dashboard/live.png" class="w-100" alt="">
														<div class="live-info badge badge-success">Live</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 mt-4 mt-lg-0">
													<div class="bg-primary text-white px-4 py-4 card">
														<div class="row">
															<div class="col-sm-6 pl-lg-5">
																<h2>$1635</h2>
																<p class="mb-0">Your Iincome</p>
															</div>
															<div class="col-sm-6 climate-info-border mt-lg-0 mt-2">
																<h2>$2650</h2>
																<p class="mb-0">Your Spending</p>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row pt-3 mt-md-1">
												<div class="col">
													<div class="d-flex purchase-detail-legend align-items-center">
														<div id="circleProgress1" class="p-2"><svg viewBox="0 0 100 100" style="display: block; width: 100%;"><path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="#eee" stroke-width="10" fill-opacity="0"></path><path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="#0aadfe" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 231.882;"></path></svg></div>
														<div>
															<p class="font-weight-medium text-dark text-small">Sessions</p>
															<h3 class="font-weight-bold text-dark  mb-0">26.80%</h3>
														</div>
													</div>
												</div>
												<div class="col">
													<div class="d-flex purchase-detail-legend align-items-center">
														<div id="circleProgress2" class="p-2"><svg viewBox="0 0 100 100" style="display: block; width: 100%;"><path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="#eee" stroke-width="10" fill-opacity="0"></path><path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="#fa424a" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 180.981;"></path></svg></div>
														<div>
															<p class="font-weight-medium text-dark text-small">Users</p>
															<h3 class="font-weight-bold text-dark  mb-0">56.80%</h3>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-12 grid-margin stretch-card">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-12"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
													<div class="d-flex align-items-center justify-content-between">
														<h4 class="card-title mb-0">Visits Today</h4>
														<div class="dropdown">
															<a href="#" class="text-success btn btn-link  px-1"><i class="mdi mdi-refresh"></i></a>
															<a href="#" class="text-success btn btn-link px-1 dropdown-toggle dropdown-arrow-none" data-bs-toggle="dropdown" id="profileDropdownvisittoday"><i class="mdi mdi-dots-horizontal"></i></a>
															<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdownvisittoday">
																<a class="dropdown-item">
																	<i class="mdi mdi-grease-pencil text-primary"></i>
																	Edit
																</a>
																<a class="dropdown-item">
																	<i class="mdi mdi-delete text-primary"></i>
																	Delete
																</a>
															</div>
														</div>
													</div>
													<p class="mt-1">Calculated in last 30 days</p>
													<div class="d-lg-flex align-items-center justify-content-between">
														<h1 class="font-weight-bold text-dark">4332</h1>
														<div class="mb-3">
															<button type="button" class="btn btn-outline-light text-dark font-weight-normal">Day</button>
															<button type="button" class="btn btn-outline-light text-dark font-weight-normal">Month</button>
														</div>
													</div>
													<!-- <canvas id="visitorsToday" width="302" height="151" style="display: block; height: 121px; width: 242px;" class="chartjs-render-monitor"></canvas> -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
@endsection

