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
<?php
if (auth()->check()) {
	$addmore = '#addmore';
}
else
{
	$contactMakeAnOffer = '#quickLogin';	
}

if (auth()->check()) {
	$updateoffer = '#updateoffer';
}
else
{
	$contactMakeAnOffer = '#quickLogin';	
}
?>
@extends('layouts.master')
@include('common.spacer')
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2">
							<strong> <i class="icon-docs"></i> {{ t('Update Offer') }}</strong> -&nbsp;
							<?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
							<a href="{{ lurl($post->uri, $attr) }}" class="tooltipHere" title="" data-placement="top"
								data-toggle="tooltip"
								data-original-title="{!! $post->title !!}">
								{!! str_limit($post->title, 45) !!}
							</a>
						</h2>
						<form class="form-horizontal" id="postForm" method="POST" action="{{ url('account/makeanoffers/store')}}" enctype="multipart/form-data">
							<input type="hidden" name="makeanoffer-id" value="{{ $makeanoffers->id }}">
								<?php

									if (!empty($pictures->filename)) {
                                        $postImg = resize($pictures->filename, 'medium');
                                    } else {
                                        $postImg = resize(config('larapen.core.picture.default'));
                                    }

                                    $countryFlagPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';
								?>

								<div class="row">
									<div class="col-md-12">
										<div class="col-md-3 pull-left">
											<h2>Seller Products</h2> 
									        <div id="myCarousel" class="vertical-slider carousel vertical slide col-md-12" data-ride="carousel">
									        	
									        	@if($sellerPosts->count() > 4)
									            <div class="row">
									                <div class="col-md-4">
									                    <span data-slide="next" class="btn-vertical-slider glyphicon glyphicon-circle-arrow-up "
									                        style="font-size: 30px"></span>  
									                </div>
									                <div class="col-md-8"> 
									                </div>
									            </div>
									            @endif
									            <br />
									            <!-- Carousel items -->
									            <div class="carousel-inner">
									                <div class="item active">
									                	@if($sellerPosts->count() > 0)
									                	@foreach($sellerPosts as $sellerPost)
									                	<?php 
									                	if (!empty($sellerPost->filename)) {
						                                        $postImgseller = resize($sellerPost->filename, 'medium');
						                                    } else {
						                                        $postImgseller = resize(config('larapen.core.picture.default'));
						                                    }

						                                    $countryFlagPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';
									                	?>
									                	<div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="{{ $postImgseller }}" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    @endforeach
									                    @else
									                	<div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    @endif
									                </div>
									            	</div>
									            	@if($sellerPosts->count() > 4)
										            <div class="row">
										                <div class="col-md-4">
										                    <span data-slide="prev" class="btn-vertical-slider glyphicon glyphicon-circle-arrow-down"
										                        style="color: Black; font-size: 30px"></span>
										                </div>
										                <div class="col-md-8">
										                </div>
										            </div>
										            @endif
									        	</div>
										</div>
										<div class="col-md-6">
											<h2 class = "tabs-center" style="padding-right: 100px;">Offer </h2>
											<div class="row"> 
												<div class="col-md-10 center offer-display">
													<div class="col-md-4 offer-display-img">
														<a href="#"><img class="thumbnail img-responsive" src="{{ $postImg }}" alt="img"></a>
														@if(!empty($makeanoffers->next_post_id))
														<a href="#"><img class="thumbnail img-responsive" src="{{ $postImg }}" alt="img" width="50" height="50"></a>
														@endif
													</div>
													<div class="col-md-8">
														<h2 class="title-2 tabs-center">
															<?php 
																if($makeanoffers->seller_id == auth()->user()->id)
																{
																	echo auth()->user()->name;
																}
																else
																{
																	echo 'Seller';
																}
															?>
															<br />
														{{ $makeanoffers->original_price }} | {{ $makeanoffers->offer_price }}</h2>
														<p>{{ $makeanoffers->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</p>

															@if ($makeanoffers->status == 1 && auth()->user()->user_type_id == 2 && $makeanoffers->approve_seller == 0)
															<p>
					                                            <a class="btn btn-primary btn-sm" data-toggle="modal" href="{{ $updateoffer }}">
					                                                <i class="fa fa-pencil"></i> {{ t('Edit') }}
					                                            </a>
					                                        </p>
															@endif
													</div>	
												</div>
											</div>
											@if($makeanoffers->approve_seller == 0)
											<div class="row">
												<div class="col-md-6 add-items">
													<div class="col-md-5">
														<span><b><p>Add more item in offer</p></b></span>
													</div>
													<div class="col-md-1 pull-right">
														<a href="{{ $addmore }}" data-toggle="modal" class="btn btn-primary btn-md pull-right" type="button">
														<span class="glyphicon glyphicon-plus"></span> Add Items
														</a>
													</div>	
												</div>
											</div>
											@endif
											<div class="row">	
												<div class="col-md-10 offer-display">
													<div class="col-md-4 offer-display-img">
														<a href="#"><img class="thumbnail img-responsive" src="{{ $postImg }}" alt="img"></a>
														@if(!empty($makeanoffers->next_post_id))
														<a href="#"><img class="thumbnail img-responsive" src="{{ $postImg }}" alt="img" width="50" height="50"></a>
														@endif
													</div>
													<div class="col-md-8">
														<h2 class="title-2 tabs-center">
															<?php 
																if($makeanoffers->buyer_id == auth()->user()->id)
																{
																	echo auth()->user()->name;
																}
																else
																{
																	echo 'Buyer';
																}
															?>
														<br />	
														{{ $makeanoffers->original_price }} | {{ $makeanoffers->offer_price }}</h2>
														<p>{{ $makeanoffers->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</p>

															@if ($makeanoffers->status == 1 && auth()->user()->user_type_id == 3 && $makeanoffers->approve_seller == 0)
															<p>
					                                            <a class="btn btn-primary btn-sm" data-toggle="modal" href="{{ $updateoffer }}">
					                                                <i class="fa fa-pencil"></i> {{ t('Edit') }}
					                                            </a>
					                                        </p>
															@endif
													</div>	
												</div>
											</div>
											<div class="row offer-decision">
												@if($makeanoffers->approve_seller == 0)
												@if(auth()->user()->user_type_id == 2)
												<a href="{{ lurl('/account/makeanoffers/'.$makeanoffers->id.'/dealseller') }}" class="visible-lg tabs-center">
												<img src="{{ lurl('/') }}/images/logo-deal.png"
												 alt="{{ strtolower(config('settings.app.name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
												 data-toggle="tooltip"
												 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
												</a>
												<a href="{{ lurl('/account/makeanoffers/'.$makeanoffers->id.'/notdealseller') }}" class="visible-lg tabs-center">
													<img src="{{ lurl('/') }}/images/logo-not-deal.png"
													 alt="{{ strtolower(config('settings.app.name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
													 data-toggle="tooltip"
													 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
												</a>
												@endif
												@elseif($makeanoffers->approve_seller == 2)
												<a href="#" class="visible-lg tabs-center">
													<img src="{{ lurl('/') }}/images/logo-not-deal.png"
													 alt="{{ strtolower(config('settings.app.name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
													 data-toggle="tooltip"
													 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
												</a>
												@elseif($makeanoffers->approve_seller == 1)
												<a href="#" class="visible-lg tabs-center">
												<img src="{{ lurl('/') }}/images/logo-deal.png"
												 alt="{{ strtolower(config('settings.app.name')) }}" class="tooltipHere main-logo" title="" data-placement="bottom"
												 data-toggle="tooltip"
												 data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
												</a>
												@endif
											</div>	
										</div>	
										<div class="col-md-3 pull-right">
											<h2>Buyer Products</h2> 
									        <div id="myCarousel" class="vertical-slider carousel vertical slide col-md-12" data-ride="carousel">
									        	@if($buyerPosts->count() > 4)
									            <div class="row">
									                <div class="col-md-4">
									                    <span data-slide="next" class="btn-vertical-slider glyphicon glyphicon-circle-arrow-up "
									                        style="font-size: 30px"></span>  
									                </div>
									                <div class="col-md-8"> 
									                </div>
									            </div>
									            @endif
									            <br />
									            <!-- Carousel items -->
									            <div class="carousel-inner">
									                <div class="item active">
									                	@if($buyerPosts->count() > 0)
									                	@foreach($buyerPosts as $buyerPost)
									                	<?php 
									                	if (!empty($buyerPost->filename)) {
						                                        $postImgbuyer = resize($buyerPost->filename, 'medium');
						                                    } else {
						                                        $postImgbuyer = resize(config('larapen.core.picture.default'));
						                                    }

						                                    $countryFlagPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';
									                	?>
									                	<div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="{{ $postImgbuyer }}" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    @endforeach
									                    @else
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    <div class="row">
									                        <div class="col-xs-6 col-sm-5 col-md-5">
									                            <a href="http://dotstrap.com/"> <img src="http://placehold.it/100x100" class="thumbnail"
									                                alt="Image" /></a>
									                        </div>
									                    </div>
									                    @endif
									                </div>
									            	</div>
									            	@if($buyerPosts->count() > 4)
										            <div class="row">
										                <div class="col-md-4">
										                    <span data-slide="prev" class="btn-vertical-slider glyphicon glyphicon-circle-arrow-down"
										                        style="color: Black; font-size: 30px"></span>
										                </div>
										                <div class="col-md-8">
										                </div>
										            </div>
										            @endif
									        	</div>
										</div>
									</div>	
								</div>
								
				
								{{-- <div class="col-md-12 tabs-center">
									<button type = "submit" id="offerSubmit" class="btn btn-primary btn-md"> {{ t('Send Offer') }} </button>
								</div> --}}
							{{-- <fieldset> --}}
							{{-- <div class="form-group required">
								<label class="col-md-2 control-label">{{ t('Offer Description') }} <sup>*</sup></label>
								<div class="col-md-4">
									<select name="offer-description" id="offer-description" class="form-control selecter">
										<option value="Start negotiation with buyer" data-type="">{{ t('Select a category') }}</option>
										<option value="Low Price" data-type="">{{ t('Low Price') }}</option>
										<option value="Fix Price" data-type="">{{ t('Fix Price') }}</option>
										<option value="Not Negotiation" data-type="">{{ t('Not Negotiation') }}</option>
										<option value="Good Offer" data-type="">{{ t('Good Offer') }}</option>
									</select>
								</div>
								<label class="col-md-2 control-label">{{ t('Status') }} <sup>*</sup></label>
								<div class="col-md-4">
									<select name="status" id="status" class="form-control selecter">
										<option value="0" data-type="">{{ t('Rejected') }}</option>
										<option value="1" data-type="">{{ t('Accepted') }}</option>
									</select>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-md-2 control-label">{{ t('Offer Price') }} <sup>*</sup></label>
								<div class="col-md-4">
									<input id="offer-price" name="offer-price" class="form-control" placeholder="{{ t('e.i. 15000') }}" type="number" value="{{ old('price', $makeanoffers->offer_price) }}">
								</div>
								<label class="col-md-2 control-label"></label>
								<div class="col-md-4">
									<button type = "submit" id="offerSubmit" class="btn btn-primary btn-md"> {{ t('Update') }} </button>
								</div>
							</div> --}}
							{{-- </fieldset> --}}	

						</form>	
					</div>
				</div>
			</div>
		</div>
	</div>	
@endsection

@section('after_styles')
	@include('layouts.inc.tools.wysiwyg.css')
@endsection

@section('add_more')
	@if (auth()->check() or config('settings.single.guests_can_contact_seller')=='1')
		@include('account.inc.add-more', array('all_post' => $all_post, 'makeanoffers' => $makeanoffers ))
	@endif
@endsection

@section('update_offer')
	@if (auth()->check() or config('settings.single.guests_can_contact_seller')=='1')
		@include('account.inc.update-offer', array('all_post' => $all_post, 'makeanoffers' => $makeanoffers ))
	@endif
@endsection
