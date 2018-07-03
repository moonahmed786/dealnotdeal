<?php
/**
 * LaraClassified - Geo Classified Ads Software
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
 */

namespace App\Http\Controllers\Account;


use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\Makeanoffer;
use App\Models\Post;
use App\Models\Picture;
use App\Http\Requests\MakeAnOfferEditRequest;
use Illuminate\Support\Facades\Request;
use DB;


class MakeanoffersController extends AccountBaseController
{
	private $perPage = 10;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
	}
	
	/**
	 * List Transactions
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		// echo "string";
		// exit;
		$data = [];
		$data['makeanoffers'] = $this->makeanoffers->paginate($this->perPage);
		
		view()->share('pagePath', 'makeanoffers');
		
		// Meta Tags
		MetaTag::set('title', t('My Offer Maker'));
		MetaTag::set('description', t('My Offers Maker on :app_name', ['app_name' => config('settings.app.name')]));
		// echo "<pre>";
		// print_r($data);
		// exit;
		return view('account.makeanoffers', $data);
	}

	public function edit($id)
	{
		
		$data = [];
		$data['makeanoffers'] = Makeanoffer::findOrFail($id);
		$data['post'] = Post::findOrFail($data['makeanoffers']['post_id']);
		$data['pictures'] = DB::table('pictures')->select('pictures.filename','pictures.position','pictures.active')->where(['post_id' => $data['makeanoffers']['post_id'] , 'position' => 0])->first();
		$all_post = DB::table('posts')->where('posts.user_id', $data['makeanoffers']['seller_id'])
                        // ->join('pictures', 'posts.id', '=', 'pictures.post_id')
                        ->select('posts.*')  
                        ->orderByDesc('posts.id')->get();
		$data['all_post'] = $all_post;
		return view('account.makeanoffers-edit', $data);
	}

	public function store( MakeAnOfferEditRequest $request)
	{
		$offerId = $request->input('makeanoffer-id');
		$offerDescription = $request->input('offer-description');
		$offerPrice = $request->input('offer-price');
		$status = $request->input('status');

		$makeanoffer = Makeanoffer::find($offerId);
		$makeanoffer->description_text = $offerDescription;
		$makeanoffer->offer_price = $offerPrice;
		$makeanoffer->approve_seller = $status;
		$makeanoffer->is_read_professional = 1;
		$makeanoffer->update();

		return redirect('account/makeanoffers');
	}

	public function dealseller($id)
	{
		$makeanoffer = Makeanoffer::find($id);
		$makeanoffer->approve_seller = 1;
		$makeanoffer->update();
		return redirect('account/makeanoffers/'.$id.'/edit');
	}
	public function notdealseller($id)
	{
		$makeanoffer = Makeanoffer::find($id);
		$makeanoffer->approve_seller = 0;
		$makeanoffer->update();
		return redirect('account/makeanoffers/'.$id.'/edit');
	}

	public function dealbuyer($id)
	{
		$makeanoffer = Makeanoffer::find($id);
		$makeanoffer->approve_seller = 1;
		$makeanoffer->update();
		return redirect('account/makeanoffers/'.$id.'/edit');
	}
	public function notdealbuyer($id)
	{
		$makeanoffer = Makeanoffer::find($id);
		$makeanoffer->approve_seller = 0;
		$makeanoffer->update();
		return redirect('account/makeanoffers/'.$id.'/edit');
	}

	public function addmore($id, MakeAnOfferEditRequest $request )
	{
		$makeanoffer = Makeanoffer::find($id);
		$makeanoffer->next_post_id = $request->input('post');
		$makeanoffer->update();
		return redirect('account/makeanoffers/'.$id.'/edit');
	}
}
