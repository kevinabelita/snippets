<?php

class Controller_Maze extends Controller_Main
{
	public $template = 'template';
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$data = array();
		
		$dimension_x = 10;
		$dimension_y = 10;
		
		if(Input::post()) {
			$dimension_x = Input::post('dimension_x');
			$dimension_y = Input::post('dimension_y');
		}
		
		$data['maze'] = $this->build_maze($dimension_x, $dimension_y);
		$data['dimension_x'] = $dimension_x;
		$data['dimension_y'] = $dimension_y;
		
		$this->template->title = 'Maze';
		$this->template->content = View::forge('maze/index', $data);
	}
	
	public function build_maze($dim_x, $dim_y)
	{
		if(empty($dim_x) || empty($dim_y)){
			return null;
		}
		
		$maze_width = $dim_x;
		$maze_height = $dim_y;
	
		//initializations
		$start = array();
		$end = array();
		$maze = array();
		$moves = array();
		$get_move = array();
		$width = 2*$maze_width+1;
		$height = 2*$maze_height+1;
		
		//fill the maze	
		for($x=0;$x<$height;$x++){
			for($y=0;$y<$width;$y++){
				$maze[$x][$y]=1;
			}
		}
		
		//generation of start and end
		$rand_start_x = rand(0,$height-1);
		$rand_start_y = 0;

		$rand_end_x = rand(0,$height-1);
		$rand_end_y = $width-1;

		$maze[$rand_start_x][$rand_start_y+1]=0;
		$maze[$rand_start_x][$rand_start_y+2]=0;

		$maze[$rand_end_x][$rand_end_y-2]=0;
		$maze[$rand_end_x][$rand_end_y-1]=0;
		//end generation
		
		$x_pos = 1;
		$y_pos = 1;
		$maze[$x_pos][$y_pos]=0;
		$maze[$rand_start_x][$rand_start_y] = 2;
		$maze[$rand_end_x][$rand_end_y] = 3;
		
		$mazePath = array();
		$mazePath[]=array(1,1);
		$mazePath[]=array($rand_start_x,$rand_start_y+1);
		$mazePath[]=array($rand_start_x,$rand_start_y+2);
		
		array_push($moves,$y_pos+($x_pos*$width));
		while(count($moves)) {
		
			$possible_directions = "";
			if(isset($maze[$x_pos+2][$y_pos]) && ($maze[$x_pos+2][$y_pos]==1 and $x_pos+2!=0 and $x_pos+2!=$height-1)){
				$possible_directions .= "S";
			}
			if(isset($maze[$x_pos-2][$y_pos]) && ($maze[$x_pos-2][$y_pos]==1 and $x_pos-2!=0 and $x_pos-2!=$height-1)){
				$possible_directions .= "N";
			}
			if(isset($maze[$x_pos][$y_pos-2]) && ($maze[$x_pos][$y_pos-2]==1 and $y_pos-2!=0 and $y_pos-2!=$width-1)){
				$possible_directions .= "W";
			}
			if(isset($maze[$x_pos][$y_pos+2]) &&($maze[$x_pos][$y_pos+2]==1 and $y_pos+2!=0 and $y_pos+2!=$width-1)){
				$possible_directions .= "E";
			}
			
			if($possible_directions) {
			
				$move = rand(0,strlen($possible_directions)-1);
				switch ($possible_directions[$move]){
					case "N": 
						$maze[$x_pos-2][$y_pos]=0;
                        $maze[$x_pos-1][$y_pos]=0;
                        if(isset($maze[$x_pos-1][$y_pos]))
                        	$mazePath[]=array($x_pos-1,$y_pos);
                        if(isset($maze[$x_pos-2][$y_pos]))
                        	$mazePath[]=array($x_pos-2,$y_pos);
						$x_pos -=2; 
                        break;
					case "S": 
						$maze[$x_pos+2][$y_pos]=0;
                        $maze[$x_pos+1][$y_pos]=0;                    
                        if(isset($maze[$x_pos+1][$y_pos]))
                        	$mazePath[]=array($x_pos+1,$y_pos);
                        if(isset($maze[$x_pos+1][$y_pos]))
                        	$mazePath[]=array($x_pos+2,$y_pos);
                        $x_pos +=2; 
                        break;
					case "W": 
						$maze[$x_pos][$y_pos-2]=0;
                        $maze[$x_pos][$y_pos-1]=0;
                        if(isset($maze[$x_pos][$y_pos-1]))
                        	$mazePath[]=array($x_pos,$y_pos-1);
                        if(isset($maze[$x_pos][$y_pos-2]))
                        	$mazePath[]=array($x_pos,$y_pos-2);
                        $y_pos -=2; 
                        break;
					case "E": 
						$maze[$x_pos][$y_pos+2]=0;
                        $maze[$x_pos][$y_pos+1]=0;
                        if(isset($maze[$x_pos][$y_pos+1]))
                        	$mazePath[]=array($x_pos,$y_pos+1);
                        if(isset($maze[$x_pos][$y_pos+2]))
                        	$mazePath[]=array($x_pos,$y_pos+2);
						$y_pos +=2; 
                        break;        
				}
				array_push($moves,$y_pos+($x_pos*$width));
				
			}
			else {
			
				$back = array_pop($moves);
				$x_pos = floor($back/$width);
				$y_pos = $back%$width;
				
			}
		}	
		
		return $maze;
	}
}
