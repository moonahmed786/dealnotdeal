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

namespace App\Http\Controllers\Post;

use App\Helpers\Arr;
use App\Http\Requests\ReportRequest;
use App\Models\Post;
use App\Models\ReportType;
use App\Http\Controllers\FrontController;
use App\Models\User;
use App\Mail\ReportSent;
use Illuminate\Support\Facades\Mail;
use Torann\LaravelMetaTags\Facades\MetaTag;

class ReportController extends FrontController
{
    /**
     * ReportController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        // From Laravel 5.3.4 or above
        $this->middleware(function ($request, $next) {
            $this->commonQueries();
            
            return $next($request);
        });
    }
    
    /**
     * Common Queries
     */
    public function commonQueries()
    {
        // Get Report abuse types
        $reportTypes = ReportType::trans()->get();
        view()->share('reportTypes', $reportTypes);
    }
    
    public function showReportForm($postId)
    {
        $data = [];
        
        // Get Post
        $data['post'] = Post::findOrFail($postId);
        
        // Meta Tags
        $data['title'] = t('Report for :title', ['title' => ucfirst($data['post']->title)]);
        $description = t('Send a report for :title', ['title' => ucfirst($data['post']->title)]);
        
        MetaTag::set('title', $data['title']);
        MetaTag::set('description', strip_tags($description));
        
        // Open Graph
        $this->og->title($data['title'])->description($description);
        view()->share('og', $this->og);
        
        return view('post.report', $data);
    }
    
    /**
     * @param $postId
     * @param ReportRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendReport($postId, ReportRequest $request)
    {
        // Get Post
        $post = Post::findOrFail($postId);
        
        // Store Report
		$report = $request->all();
		$report['post_id'] = $post->id;
		$report = Arr::toObject($report);
        
        // Send Abuse Report to admin
        try {
            if (config('settings.app.email')) {
                $recipient = [
                    'email' => config('settings.app.email'),
                    'name'  => config('settings.app.name'),
                ];
                $recipient = Arr::toObject($recipient);
                Mail::send(new ReportSent($post, $report, $recipient));
            } else {
                $admins = User::where('is_admin', 1)->get();
                if ($admins->count() > 0) {
                    foreach ($admins as $admin) {
                        Mail::send(new ReportSent($post, $report, $admin));
                    }
                }
            }
            
            flash(t('Your report has sent successfully to us. Thank you!'))->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
            
            return back()->withInput();
        }
        
        return redirect(config('app.locale') . '/' . $post->uri);
    }
    
}
