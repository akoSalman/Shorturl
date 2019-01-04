<?php

	namespace Ako\Shorturl\Models;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Link extends Model
	{
		protected  $fillable = [
			'short_url',
			'long_url',
			'clicks',
			'properties'
		];
		
		protected  $casts = [
			'properties' => 'collection'
		];
	}