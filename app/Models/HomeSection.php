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

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Observer\HomeSectionObserver;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Larapen\Admin\app\Models\Crud;
use Prologue\Alerts\Facades\Alert;

class HomeSection extends BaseModel
{
	use Crud;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'home_sections';
    
    protected $fakeColumns = ['options'];
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'method', 'options', 'parent_id', 'lft', 'rgt', 'depth', 'active'];
    
    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    // protected $hidden = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [];
    
    protected $casts = [
        'options' => 'array',
    ];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
	
		HomeSection::observe(HomeSectionObserver::class);
		
        static::addGlobalScope(new ActiveScope());
    }
	
	public function resetHomepageReOrderBtn($xPanel = false)
	{
		$url = url(config('larapen.admin.route_prefix', 'admin') . '/actions/homepage/reset_reorder');
		
		$msg = trans('admin::messages.Reset the homepage sections reorder.');
		$tooltip = ' data-toggle="tooltip" title="' . $msg . '"';
		
		// Button
		$out = '';
		$out .= '<a class="btn btn-warning" href="' . $url . '"' . $tooltip . '>';
		$out .= '<i class="fa fa-sort-amount-asc"></i> ';
		$out .= trans('admin::messages.Reset sections reorganization');
		$out .= '</a>';
		
		return $out;
	}
	
	public function resetHomepageSettingsBtn($xPanel = false)
	{
		$url = url(config('larapen.admin.route_prefix', 'admin') . '/actions/homepage/reset_settings');
		
		$msg = trans('admin::messages.Reset all the homepage settings.');
		$tooltip = ' data-toggle="tooltip" title="' . $msg . '"';
		
		// Button
		$out = '';
		$out .= '<a class="btn btn-danger" href="' . $url . '"' . $tooltip . '>';
		$out .= '<i class="fa fa-industry"></i> ';
		$out .= trans('admin::messages.Return to factory settings');
		$out .= '</a>';
		
		return $out;
	}
    
    public function getNameHtml()
    {
        $out = '';
    
        $url = url(config('larapen.admin.route_prefix', 'admin') . '/homepage/' . $this->id . '/edit');
        $out .= '<a href="' . $url . '">' . $this->name . '</a>';
        
        return $out;
    }
	
	public function configureBtn($xPanel = false)
	{
		$url = url(config('larapen.admin.route_prefix', 'admin') . '/homepage/' . $this->id . '/edit');
		
		$msg = trans('admin::messages.Configure :entity', ['entity' => $this->name]);
		$tooltip = ' data-toggle="tooltip" title="' . $msg . '"';
		
		$out = '';
		$out .= '<a class="btn btn-xs btn-primary" href="' . $url . '"' . $tooltip . '>';
		$out .= '<i class="fa fa-cog"></i> ';
		$out .= mb_ucfirst(trans('admin::messages.Configure'));
		$out .= '</a>';
		
		return $out;
	}
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
	public function getOptionsAttribute($value)
	{
		// Get 'options' field value
		$value = jsonToArray($value);
		
		// Handle 'options' field value
		if (is_array($value) && count($value) > 0) {
			// Get Entered values (Or Default values if the Entry doesn't exist)
			if ($this->method == 'getSearchForm') {
				if (!isset($value['enable_form_area_customization'])) {
					$value['enable_form_area_customization'] = '1';
				}
				if (!isset($value['background_image'])) {
					$value['background_image'] = null;
				}
			}
			
			if ($this->method == 'getLocations') {
				if (!isset($value['show_cities'])) {
					$value['show_cities'] = '1';
				}
				if (!isset($value['max_items'])) {
					$value['max_items'] = '14';
				}
				if (!isset($value['show_post_btn'])) {
					$value['show_post_btn'] = '1';
				}
				if (!isset($value['show_map'])) {
					$value['show_map'] = '1';
				}
				if (!isset($value['map_width'])) {
					$value['map_width'] = '300px';
				}
				if (!isset($value['map_height'])) {
					$value['map_height'] = '300px';
				}
			}
			
			if ($this->method == 'getSponsoredPosts') {
				if (!isset($value['max_items'])) {
					$value['max_items'] = '20';
				}
				if (!isset($value['autoplay'])) {
					$value['autoplay'] = '1';
				}
			}
			
			if ($this->method == 'getLatestPosts') {
				if (!isset($value['max_items'])) {
					$value['max_items'] = '8';
				}
				if (!isset($value['show_view_more_btn'])) {
					$value['show_view_more_btn'] = '1';
				}
			}
			
			if ($this->method == 'getCategories') {
				if (!isset($value['type_of_display'])) {
					$value['type_of_display'] = 'c_picture_icon';
				}
				if (!isset($value['show_icon'])) {
					$value['show_icon'] = '0';
				}
				if (!isset($value['max_sub_cats'])) {
					$value['max_sub_cats'] = '3';
				}
			}
		} else {
			if (isset($this->method)) {
				// Get Default values
				$value = [];
				if ($this->method == 'getSearchForm') {
					$value['enable_form_area_customization'] = '1';
					$value['background_image'] = null;
				}
				if ($this->method == 'getLocations') {
					$value['show_cities'] = '1';
					$value['max_items'] = '14';
					$value['show_post_btn'] = '1';
					$value['show_map'] = '1';
					$value['map_width'] = '300px';
					$value['map_height'] = '300px';
				}
				if ($this->method == 'getSponsoredPosts') {
					$value['max_items'] = '20';
					$value['autoplay'] = '1';
				}
				if ($this->method == 'getLatestPosts') {
					$value['max_items'] = '8';
					$value['show_view_more_btn'] = '1';
				}
				if ($this->method == 'getCategories') {
					$value['type_of_display'] = 'c_picture_icon';
					$value['show_icon'] = '0';
					$value['max_sub_cats'] = '3';
				}
			}
		}
		
		return $value;
	}
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
	public function setOptionsAttribute($value)
	{
		$value = jsonToArray($value);
		
		// Background Image
		if (isset($value['background_image'])) {
			$backgroundImage = [
				'attribute' => 'background_image',
				'path'      => 'app/logo',
				'default'   => null,
				'width'     => 2000,
				'height'    => 1000,
				'upsize'    => false,
				'quality'   => 100,
				'filename'  => 'header-',
				'orientate' => true,
			];
			$value = $this->upload($value, $backgroundImage);
		}
		
		$this->attributes['options'] = json_encode($value);
	}
	
	// Set Upload
	public function upload($value, $params)
	{
		$attribute_name = $params['attribute'];
		$destination_path = $params['path'];
		
		// If 'background_image' option doesn't exist, don't make the upload and save data
		if (!isset($value[$attribute_name])) {
			return $value;
		}
		
		// If the image was erased
		if ($value[$attribute_name] == null) {
			// Delete the image from disk
			if (isset($this->options) && isset($this->options[$attribute_name])) {
				if (!empty($params['default'])) {
					if (!str_contains($this->options[$attribute_name], $params['default'])) {
						Storage::delete($this->options[$attribute_name]);
					}
				} else {
					Storage::delete($this->options[$attribute_name]);
				}
			}
			
			// Set null in the database column
			$value[$attribute_name] = null;
			
			return $value;
		}
		
		// If laravel request->file('filename') resource OR base64 was sent, store it in the db
		try {
			if (fileIsUploaded($value[$attribute_name])) {
				// Get file extension
				$extension = getUploadedFileExtension($value[$attribute_name]);
				if (empty($extension)) {
					$extension = 'jpg';
				}
				
				// Check if 'Auto Orientate' is enabled
				$autoOrientateIsEnabled = false;
				if (isset($params['orientate']) && $params['orientate']) {
					$autoOrientateIsEnabled = exifExtIsEnabled();
				}
				
				// Make the Image
				if ($autoOrientateIsEnabled) {
					$image = Image::make($value[$attribute_name])->orientate()->resize($params['width'], $params['height'], function ($constraint) use ($params) {
						$constraint->aspectRatio();
						if ($params['upsize']) {
							$constraint->upsize();
						}
					})->encode($extension, $params['quality']);
				} else {
					$image = Image::make($value[$attribute_name])->resize($params['width'], $params['height'], function ($constraint) use ($params) {
						$constraint->aspectRatio();
						if ($params['upsize']) {
							$constraint->upsize();
						}
					})->encode($extension, $params['quality']);
				}
				
				// Generate a filename.
				$filename = uniqid($params['filename']) . '.' . $extension;
				
				// Store the image on disk.
				Storage::put($destination_path . '/' . $filename, $image->stream());
				
				// Save the path to the database
				$value[$attribute_name] = $destination_path . '/' . $filename;
			} else {
				// Retrieve current value without upload a new file.
				if (!empty($params['default'])) {
					if (str_contains($value[$attribute_name], $params['default'])) {
						$value[$attribute_name] = null;
					} else {
						if (!starts_with($value[$attribute_name], $destination_path)) {
							$value[$attribute_name] = $destination_path . last(explode($destination_path, $value[$attribute_name]));
						}
					}
				} else {
					if ($value[$attribute_name] == url('/')) {
						$value[$attribute_name] = null;
					} else {
						if (!starts_with($value[$attribute_name], $destination_path)) {
							$value[$attribute_name] = $destination_path . last(explode($destination_path, $value[$attribute_name]));
						}
					}
				}
			}
			
			return $value;
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			
			$value[$attribute_name] = null;
			
			return $value;
		}
	}
}
