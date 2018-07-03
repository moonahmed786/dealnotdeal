
{{--
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="glyphicon glyphicon-hand-left"></i> {{ t('Offers Maker') }} </h2>
						
						<div style="clear:both"></div>
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
								<tr>
									<th><span>ID</span></th>
									<th>{{ t('Description') }}</th>
									<th>{{ t('Original Price') }}</th>
									<th>{{ t('Offer Price') }}</th>
									<th>{{ t('Photo') }}</th>
									<th>{{ t('Add Information') }}</th>
									<th>{{ t('Option') }}</th>
								</tr>
								</thead>
								<tbody>
								<?php

								if (isset($makeanoffers) && $makeanoffers->count() > 0):
									foreach($makeanoffers as $key => $makeanoffer):
									$picture = \App\Models\Picture::where(['post_id' => $makeanoffer->post_id, 'position'=> 1])->get();
									if (!empty($picture[0]->filename)) {
										$postImg = resize($picture[0]->filename, 'medium');
                                    } else {
                                        $postImg = resize(config('larapen.core.picture.default'));
                                    }
                                    $countryFlagPath = 'images/flags/16/' . strtolower($makeanoffer->country_code) . '.png';
								?>
								<tr>
									<td>#{{ $makeanoffer->id }}</td>
									<td>
										{{ $makeanoffer->description_text }}
									</td>
									<td>
										{{ $makeanoffer->original_price }}
									</td>
									<td>
										{{ $makeanoffer->offer_price }}
									</td>
									<td style="width:14%" class="add-img-td">

										<a href="#"><img class="thumbnail img-responsive" src="{{ $postImg }}" alt="img"></a>
									</td>
									<td style="width:58%" class="ads-details-td">
											<div>
												<p>
													<strong>
                                                        <a href="#" title="{{ $makeanoffer->title }}">{{ str_limit($makeanoffer->title, 40) }}</a>
                                                    </strong>
													@if (in_array($pagePath, ['my-posts', 'archived', 'pending-approval']))
														@if (isset($makeanoffer->latestPayment) and !empty($makeanoffer->latestPayment))
															@if (isset($makeanoffer->latestPayment->package) and !empty($makeanoffer->latestPayment->package))
																<?php
																if ($makeanoffer->featured == 1) {
																	$color = $makeanoffer->latestPayment->package->ribbon;
																	$packageInfo = '';
																} else {
																	$color = '#ddd';
																	$packageInfo = ' (' . t('Expired') . ')';
																}
																?>
																<i class="fa fa-check-circle tooltipHere" style="color: {{ $color }};" title="" data-placement="bottom"
																   data-toggle="tooltip" data-original-title="{{ $makeanoffer->latestPayment->package->short_name . $packageInfo }}"></i>
															@endif
														@endif
													@endif
                                                </p>
												<p>
													<strong><i class="icon-clock" title="{{ t('Posted On') }}"></i></strong>&nbsp;
													{{ $makeanoffer->created_at}}
												</p>
												<p>
													<strong><i class="icon-eye" title="{{ t('Visitors') }}"></i></strong> {{ $makeanoffer->visits or 0 }}
													<strong><i class="fa fa-map-marker" title="{{ t('Located In') }}"></i></strong> {{ !empty($makeanoffer->city) ? $makeanoffer->city->name : '-' }}
													@if (file_exists(public_path($countryFlagPath)))
														<img src="{{ url($countryFlagPath) }}" data-toggle="tooltip" title="{{ $makeanoffer->country_code }}">
													@endif
												</p>
											</div>
										</td>
									<td>
										@if ($makeanoffer->status == 1)
										<p>
                                            <a class="btn btn-info btn-sm" href="{{ lurl('account/makeanoffers/' . $makeanoffer->id . '/edit') }}">
                                                <i class="fa fa-eye"></i> {{ t('View') }}
                                            </a>
                                        </p>
										@else
												{{ t('Not Active') }}
										@endif
									</td>
								</tr>
								<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
						
						<div class="pagination-bar text-center">
							
						</div>
						
						<div style="clear:both"></div>
					
					</div>
				</div>
				<!--/.page-content-->
				
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection

@section('after_scripts')
@endsection