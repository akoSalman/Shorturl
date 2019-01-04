<?php
	namespace Ako\Shorturl\Drivers;

	use Illuminate\Support\Str;
	use Ako\Shorturl\Models\Link;
	
	class LocalDriver implements BaseDriver
	{
		protected  $props = [];
		protected $config, $main_str, $head, $tail;
		
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
			return Link::where("long_url", $url)->select("short_url")->pluck("short_url")->first() ?: "";
		}
		
		/**
		 * @param string $url
		 *
		 * @return string
		 */
		function shorten (string $url) :string
		{
			$latest = Link::latest()->select("short_url")->first();
			$short_url = $latest ? $this->findNexPerm($latest->short_url) : $this->getFirstUrl();
			Link::create(["long_url" => $url, "short_url" => $short_url, 'props' => $this->props]);
			return $short_url;
		}

        /**
         * Git the first short url
         *
         * @return string
         */
        private function getFirstUrl () : string
        {
            $min_length = $this->config['drivers']['local']['min_length'];
            $short_url = "";
            for ($i = 0; $i < $min_length; $i++)
                $short_url .= $this->head;
            return $short_url;
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
	}