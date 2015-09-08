<?php

class Raman_View_Helper_Panel
{

	/**
	 *
	 * @param array $items        	
	 * @example panel(array(
	 *          array(
	 *          'name' => 'profile',
	 *          'href' => './cpanel/profile',
	 *          'image' => './images/profile.png'
	 *          ),
	 *          array(
	 *          'name' => 'logout',
	 *          'href' => './cpanel/logout',
	 *          'image' => './images/logout.png'
	 *          ),
	 *         
	 *          ));
	 */
	public function panel (array $items)
	{
		$return = "
                <style>
                    
					.tile_col{
		                margin:20px 0;
		            } 
				
					.tile_col a, .tile_col a:visited{
						color:#FFF;
					}
				
					.tile_col a:hover{
						text-decoration:none;
						color:#FFF;
					}
				
                    .tile_col .panel_item{
						max-width:256px;
						margin:0 auto;
				
						overflow:hidden;
						display:block;
				
		            	background: rgba(0, 0, 0, 0.5);
		            	border:1px solid rgba(0, 0, 0, 0.6);
				
						-webkit-border-radius: 7px;
						-moz-border-radius: 7px; 				
		            	border-radius: 7px;
				
		            	padding: 20px 20px 7px 20px;
						
						-webkit-box-shadow: 0px 0px 7px 1px rgba(0, 0, 0, 0.4);
						box-shadow: 0px 0px 7px 1px  rgba(0, 0, 0, 0.4);
						
						-webkit-transition: all 0.5s ease;
		    			transition: all 0.5s ease;                                                                   
                    }
                
                    .tile_col:hover .panel_item{
                        transform: translate(5px,-5px);
						border:1px solid rgba(255, 255, 255, 0.5);
				
						-webkit-box-shadow: 0px 0px 7px 1px rgba(255, 255, 255, 0.4);
						box-shadow: 0px 0px 7px 1px  rgba(255, 255, 255, 0.4);
                    }
                
                    .panel_item .panel_item_image{
                        display:block;
		            	width:100%;
		            	cursor:pointer;
		            	position:relative;
                    }    
                
                    .panel_item .panel_item_image img{
						position:relative;   
                        max-width:128px;
						max-height:128px;		
                        width:100%;
                        margin:0 auto;
				
						-webkit-border-radius: 7px;
						-moz-border-radius: 7px; 
                        border-radius: 7px 7px 0 0;	
                    }

                    .panel_item .panel_item_name{						
                        width:100%;
                        height:35px;
						overflow:hidden;
						padding: 10px;
		            	text-align:center;
		                font-size:15px;
		                color:#FFF;
		                border-top:1px solid #AAA;
		                margin-top:25px;
                    }
                    
                </style>
        ";
		
		$colCounter = 0;
		foreach($items as $item)
		{
			$name = $item['name'];
			$href = $item['href'];
			$image = $item['image'];
			$colCounter++;
			
			$return .= "
                    <div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 tile_col'>
                        <a href='$href' class='panel_item'>
                            <div class='panel_item_image'><img src='$image' alt='$name' /></div>
                            <div class='panel_item_name'>$name</div>
                        </a>
                    </div>
            ";
			
			$html .= "<div class='clearfix visible-xs-block'></div>";
			
			if($colCounter % 2 == 0)
				$html .= "<div class='clearfix visible-sm-block'></div>";
			
			if($colCounter % 3 == 0)
				$html .= "<div class='clearfix visible-md-block'></div>";				
			
			if($colCounter % 4 == 0)
				$html .= "<div class='clearfix visible-lg-block'></div>";
		}
		
		return $return;
	}
}
