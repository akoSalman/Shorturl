<?php

	namespace Ako\Shorturl\Models;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Link extends Model
	{
		protected  $fillable = [
			'short_path',
			'long_path',
			'base_url',
			'clicks',
			'properties'
		];
		
		protected  $casts = [
			'properties' => 'collection'
		];
	}