<?php

class UtilityFunc {

	/*
	 valid_email
	 Desc: Check whether supplied value is a valid email
	 params: string (email)
	 return: true/false
	*/
	public static function valid_email($val) {
		return !empty($val) && filter_var($val, FILTER_VALIDATE_EMAIL);
	}

	/*
	 time_readable
	 Desc: Converts seconds to how many hours/minutes/seconds remaining
	 params: date converted to seconds
	 return: string
	*/
	public static function time_readable($seconds) { 
        $days = (int)($seconds/86400); 
        // $plural = $days > 1 ? 'days' : 'day';
        $hours = (int)(($seconds-($days*86400))/3600); 
		$plural_hour = $days > 1 ? 'hours' : 'hour';
        $mins = (int)(($seconds-$days*86400-$hours*3600)/60);
		$plural_min = $mins > 1 ? 'minutes' : 'minute';
        $secs = (int)($seconds - ($days*86400)-($hours*3600)-($mins*60)); 
        // return sprintf("%d $plural, %d hours, %d min, %d sec", $days, $hours, $mins, $secs);
		return ($seconds >= 3600) ? sprintf("%d $plural_hour", $hours) : sprintf("%d $plural_min", $mins);
    }
	
	/*
	 format_url
	 Desc: searches inside string for url and converts it to and anchor
	 params: string
	 return: string with formated url to anchor 
	*/
	public static function format_url($text) {
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		preg_match_all($reg_exUrl, $text, $matches);
		$usedPatterns = array();
		foreach($matches[0] as $pattern){
			if(!array_key_exists($pattern, $usedPatterns)){
				$usedPatterns[$pattern] = true;
				$text = str_replace($pattern, "<a href={$pattern} rel=nofollow target='_blank'>{$pattern}</a>", $text);   
			}
		}
		return $text;            
	}
	
	/*
	 create_pagination_links
	 Desc: custom pagination links creator
	 params: page (page number), limit (how many rows per page), total_items (total of rows)
	 return: array (batch of pages)
	*/
	
	public static function create_pagination_links($page, $limit, $total_items) {
	
		// if pagination is
		// (1, 2, 3, 4, 5, 6 || 7, 8, 9, 10, 11, 12 || 11, 12, 13, 14, 15)
		
		$total_pages = ceil($total_items / $limit);
		
		$pages = range(1, $total_pages); //for example: 1, 15
		$batch = NULL;
		$per_chunk = 6;
		$page_pieces = array_chunk($pages, $per_chunk); // divide links by 6 (1, 2, 3, 4, 5, 6 || 7, 8, 9, 10, 11, 12 || 13, 14, 15)
		foreach($page_pieces as $key => $values) {
			$sub = $values;
			foreach($sub as $k => $v) {
				if($v == $page) {
					$batch = $key;
				}
			}
		}

	   if(count($page_pieces) > 1) {
			$current_chunk = count($page_pieces[$batch]);
			if($current_chunk < $per_chunk) {
				for($x = $current_chunk; $x < $per_chunk; $x++) {
					$page_pieces[$batch][] = array_pop($page_pieces[$batch-1]);
				}
				sort($page_pieces[$batch]);
			}
		}
		
		return $page_pieces[$batch];	
	}
	
	/*
	 time_ago
	 Desc: calculate time ago from supplied date
	 params: datetime (later date e.g. 1999-09-09), full (optional)
	 return: string 
	*/
	
	public static function time_ago($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
	
	/*
	 time_remaining
	 Desc: calculate time remaning from supplied date
	 params: end_date (ending date e.g. 1999-09-09), start_date (1998-09-09)
	 return: string
	*/
	
	public static function time_remaining($end_date, $start_date) {
		$end_date = new DateTime($end_date);
		$start_date = new DateTime();
		$interval = $start_date->diff($end_date);
		
		$interval->w = floor($interval->d / 7);
		$interval->d -= $interval->w * 7;
		
		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($interval->$k) {
				$v = $interval->$k . ' ' . $v . ($interval->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
		
		$string = array_slice($string, 0, 1);
		return 'Last ' . implode(', ', $string);
	}
	
	/*
	 get_age
	 Desc: calculate age from supplied date (birth day)
	 params: raw_birthday (e.g. 1989-08-04 YYYY-MM-DD, 04/08/1989 d/m/Y)
	 return: int (age)
	*/
	
	public static function get_age($raw_birthday) {
		return intval(substr(date('Ymd') - date('Ymd', strtotime($raw_birthday)), 0, -4));
	}
	
	/*
	 get_generation
	 Desc: calculate generation from supplied date (birth day)
	 params: raw_birthday (e.g. 1989-08-04 YYYY-MM-DD, 04/08/1989 d/m/Y)
	 params: generation (array)
	 e.g.
	 array (
		0 => 12 - 20
		1 => 21 - 30
		2 => 31 - 40
		3 => 41 - 50
	 )
	 return: int
	*/
	
	public static function get_generation($raw_birthday, $generations) {
		$generation = null;
		$age = intval(substr(date('Ymd') - date('Ymd', strtotime($raw_birthday)), 0, -4));

		foreach($generations as $generation_key => $range) {
			$age_range = explode('-', $range);
			$age_range = array_map('intval', $age_range);

			if(count($age_range) > 1) {
				if($age >= $age_range[0] && $age <= $age_range[1]) {
					$generation = $generation_key;
					break;
				}
			} else {
				$generation = $generation_key;
			}
		}

		return strval($generation);
	}
	
	/*
	 check_browser
	 Desc: get the current browser
	 params: none
	 return: string (browser) (iOS, Android, WindowsPhone, OtherMobile, PC)
	*/
	
	public static function check_browser()
	{
		if(preg_match_all('/iPhone|iPad|iPod/i', $_SERVER['HTTP_USER_AGENT'])) {
			return 'iOS';
		} else if(preg_match_all('/Android/i', $_SERVER['HTTP_USER_AGENT'])) {
			return 'Android';
		} else if(preg_match_all('/IEMobile/i', $_SERVER['HTTP_USER_AGENT'])) {
			return 'WindowsPhone';
		} else if(preg_match_all('/Opera Mini|BlackBerry|Nokia|BB10/i', $_SERVER['HTTP_USER_AGENT'])) {
			return 'OtherMobile';
		} else if(preg_match_all('/Mozilla|Chrome|MSIE|Safari/i', $_SERVER['HTTP_USER_AGENT'])) {
			return 'PC';
		}
	}
}

/* End of file utilityfunc.php */