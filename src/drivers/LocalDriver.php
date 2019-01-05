<?php
	namespace Ako\Shorturl\Drivers;

	use Illuminate\Support\Str;
	use Ako\Shorturl\Models\Link;
	
	class LocalDriver implements BaseDriver
	{
		protected  $props = [];
		protected $config, $main_str, $head, $tail, $base_url, $path;
		
		public function __construct ()
		{
			$this->config = config('shorturl');
			$this->main_str = $this->config['drivers']['local']['str_shuffled'];
			$this->head = $this->main_str[0];
			$this->tail = $this->main_str[strlen($this->main_str) - 1];
		}

        /**
         * @param string $url
         *
         * @return string
         */
		function  expand (string $url) :string
		{
		    $this->parseUrl($url);
		    $link = Link::where("short_path", $this->path)->first();
		    if ($link) {
		        $link->increment("clicks");
		        return $link->base_url . "/" . $link->long_path;
            }
			return "";
		}
		
		/**
		 * @param string $url
		 *
		 * @return string
		 */
		function shorten (string $url) :string
		{
            $this->parseUrl ($url);

		    $duplicate = Link::where('long_path', $this->path)->first();
		    if ($duplicate)
		        return $duplicate->base_url . "/" . $duplicate->short_path;

			$latest = Link::latest()->select("short_path")->first();
			$short_path = $latest ? $this->findNexPerm($latest->short_path) : $this->getFirstUrl();
			Link::create([
			    "long_path" => $this->path,
                "short_path" => $short_path,
                'base_url' => $this->base_url,
                'properties' => $this->props]
            );
			return $this->base_url . "/" . $short_path;
		}

        /**
         * Git the first short url
         *
         * @return string
         */
        private function getFirstUrl () : string
        {
            $min_length = $this->config['drivers']['local']['min_length'];
            $short_path = "";
            for ($i = 0; $i < $min_length; $i++)
                $short_path .= $this->head;
            return $short_path;
        }

        /**
         *
         * Get the next short url based on the given item (it gets permutations one by one)
         *
         * @param string $current_perm
         * @return string
         */
        private function findNexPerm (string $current_perm) :string
		{
			if (!strlen($current_perm))
			    return $this->head;

			$arr = array_reverse(str_split($current_perm));
			foreach($arr as $key => $current_char) {
				if ($current_char == $this->tail) {
					$current_perm = Str::replaceLast($current_char, "", $current_perm);
					return $this->findNexPerm($current_perm) . $this->head;
				}
                $next_char = str_split(Str::after($this->main_str, $current_char));
				return Str::replaceLast($current_char, $next_char, $current_perm);
			}
		}
		
		/**
		 * @param array $props
		 *
		 * @return LocalDriver
		 */
		function withProperties (array $props = []) :LocalDriver
		{
			$this->props = array_merge($this->props, $props);
			return $this;
		}

        private function parseUrl (string $url)
        {
            $parse = parse_url($url);
            $path = "";
            if ($parse['path'] ?? null)
                $path .= str::replaceFirst("/", "", $parse['path']);
            if ($parse['query'] ?? null)
                $path .= "?" . $parse['query'];
            if ($parse['fragment'] ?? null)
                $path .= "#" . $parse['fragment'];

            $this->base_url = str_replace("/" . $path, "", $url);
            $this->path = $path;
        }
	}