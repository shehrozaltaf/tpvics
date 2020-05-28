<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sm{
	
	public function __construct(){
		
		
	}
	
	public function calculate_percentage($numerator, $denominator){
		
		return round((($numerator / $denominator) * 100), 2);
	}
}