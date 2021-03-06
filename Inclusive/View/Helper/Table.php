<?php

class Inclusive_View_Helper_Table extends Zend_View_Helper_Abstract {
	
	protected $_columnCount = 0;
	
	public function getColumnCount()
	{
	
		return $this->_columnCount;
	
	}
	
	public function renderCaption($caption) 
	{
		
		return '<caption>'.$caption."</caption>\n";
		
	}
	
	public function renderHeader($row,array $options=null) 
	{
		
		$string = '';
		
		if (is_array($row)) 
		{
			
			$string .= '<tr>';
			
			foreach ($row as $key => $value) 
			{
				
				$string .= '<th class="'.strtolower($key).'"><span>'.$key.'</span></th>';
				
				$this->_columnCount++;
				
			}
			
			$string .= "</tr>\n";
			
		} 
		elseif ($row instanceof Inclusive_Table_Row
			or $row instanceof Inclusive_View_Table_Row) 
		{
			
			$string .= '<tr>';
			
			foreach ($row->getColumns() as $column) 
			{
				
				$string .= '<th class="'.strtolower($column->getOption('class')).'">'.$column->getKey().'</th>';
				
				$this->_columnCount++;
				
			}
			
			if ($row->getOption('navigation'))
			{
			
				$string .= '<th class="navigation">&nbsp;</th>';
			
				$this->_columnCount++;
			
			}
			
			$string .= '</tr>';
			
		} 
		else 
		{
			
			$string .=  $row;
			
			$this->_columnCount++;
			
		}
		
		return $string;
		
	}
	
	public function renderRow($row,array $options=null) 
	{
		
		$string = '';
		
		if (is_array($row)) 
		{
		
			$string .= '<tr>';
			
			foreach ($row as $key => $value) 
			{
				
				$string .= '<td class="'.strtolower($key).'">'.$value.'</td>';
				
			}
			
			$string .= "</tr>\n";
		
		} 
		elseif ($row instanceof Inclusive_Table_Row
			or $row instanceof Inclusive_View_Table_Row
			or $row instanceof Inclusive_View_Table) 
		{
			
			$this->view->addHelperPath('Inclusive/View/Helper/Table','Inclusive_View_Helper_Table');
			
			$string .= $this->view->row($row);
			
		} 
		else 
		{
			
			$string .= $row;
			
		}
		
		return $string;
		
	}
	
	public function table($table=null,array $options=array()) 
	{
		
		if ($table === null)
		{
			
			return $this;
		
		}
		
		$this->_columnCount = 0;
		
		if ($table instanceof Inclusive_Table) 
		{
		
			return 'Inclusive_Table is depreciated';
			
		} 
		elseif ($table instanceof Inclusive_View_Table) 
		{
		
			if (!$table->count()) 
			{
			
				return $table->getEmptyTableText();
			
			}
		
		} 
		elseif (is_array($table)) 
		{
			
			if (!count($table)) 
			{
				
				return $table->getEmptyTableText();
				
			}
			
			$array = $table;
			
			$table = new Inclusive_View_Table();
			
			foreach ($array as $row)
			{
			
				$table->addRow($row);
			
			}
					
		} 
		else 
		{
		
			return '';
		
		}
		
		$options = array_merge($options,$table->getOptions());
		
		$class = 'inclusive';
		
		if (isset($options['class']))
		{
		
			$class = $options['class'];
		
		}
		
		$string = '<table class="'.$class.'">';
		
		if (isset($options['caption'])) 
		{
			
			$string .= $this->renderCaption($options['caption']);
			
		}
		
		$string .= "<thead>\n";
		
		if ($table instanceof Inclusive_View_Table) 
		{
		
			$header = $table->getFirstRow();
		
		} 
		elseif (is_array($table)) 
		{
			
			$header = $table[0];
					
		}
		
		$string .= $this->renderHeader($header,$options);
		
		$string .= "</thead>\n";
		
		$string .= "<tbody>\n";
		
		if ($table instanceof Inclusive_Table
			or $table instanceof Inclusive_View_Table) 
		{
		
			$rows = $table->getRows();
		
		} 
		elseif (is_array($table)) 
		{
			
			$rows = $table;
					
		}
		
		foreach ($rows as $row) 
		{
			
			$string .= $this->renderRow($row,$options);
			
		}
		
		$string .= "</tbody>\n";
		
		return $string .= "</table>\n";
		
	}
	
}