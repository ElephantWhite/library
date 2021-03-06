<?php

class Inclusive_View_Helper_Container extends Zend_View_Helper_Abstract 
{
	
	public function container($content,$options=null) 
	{
		
		$string = '<div';
		
		$class = 'container';
		
		if (isset($options['class'])) 
		{ 
		
			$class .= ' '.$options['class'];
			
		}
		
		$string .= ' class="'.$class.'"';
		
		if (isset($options['id']))
		{
		
			$string .= ' id="'.$options['id'].'"';
		
		}
		
		$string .= '>'."\n";
		
		if (isset($options['border'])
			&& $options['border'])
		{
		
			$string .= '<div class="border">'."\n";
		
		}
		
        if (isset($options['wrapper'])
            && $options['wrapper']) {
            
            $string .= '<div class="wrapper">'."\n";
            
        }
        
		if (isset($options['title'])) {
			
			$string .= $this->view->header($options['title'],'3');
			
		}
		
        $string .= $content;
        
        if (isset($options['wrapper'])
            && $options['wrapper']) {
            
            $string .= '<div class="clear"></div>';
            	
            $string .= '</div>'."\n";
            
        }
        
        if (isset($options['border'])
        	&& $options['border'])
        {
        
        	$string .= '<div class="clear"></div>';
        
        	$string .= '</div>'."\n";
        
        }
        
		$string .= '</div>'."\n";
		
		return $string;
		
	}
	
}