<?php
/**
 * Implement the jqxDatatable
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.1
 */
class Raman_View_Helper_Datatable
{	
	
	const DATATABLE_DATA_TYPE_JSON 			= 'json';
	const DATATABLE_DATA_TYPE_XML 			= 'xml';
	
	
	const DATATABLE_LOCALIZATION_US 		= '';
	const DATATABLE_LOCALIZATION_FA 		= '';
	
	
	const DATATABLE_EDIT_MODE_CLICK 		= 'click';
	const DATATABLE_EDIT_MODE_DOUBLE_CLICK 	= 'dblclick';
	
	
	const DATATABLE_SELECTION_MODE_MULTIEXT = 'multiplerowsextended';
	
	
	const DATATABLE_TOLLBAR_BUTTON_ADD 		= 'ADD';
	const DATATABLE_TOLLBAR_BUTTON_DELETE	= 'DELETE';
	const DATATABLE_TOLLBAR_BUTTON_UPDATE	= 'UPDATE';
	const DATATABLE_TOLLBAR_BUTTON_PRINT	= 'PRINT';
	const DATATABLE_TOLLBAR_BUTTON_EXCEL	= 'EXCEL';
	
	const DATATABLE_BUTTON_ACTION_IN_PLACE     = 0;
	const DATATABLE_BUTTON_ACTION_IN_NEW_PAGE  = 1;
	const DATATABLE_BUTTON_ACTION_IN_NEW_TAB   = 2;
	
	/**
	 * The url for geting & seting data 
	 * @var string
	 */
	protected $dataSource;
	
	
	/**
	 * The type of data in dataSource
	 * @var Consts with DATATABLE_DATA_TYPE_ prefix
	 */
	protected $dataType = self::DATATABLE_DATA_TYPE_JSON;
	
	
	/**
	 * The columns
	 * @var array
	 */
	protected $dataFields;
	
	
	/**
	 * Grid use it for update & delete commands
	 * @var int
	 */
	protected $primaryKey = 'id';
	
	
	/**
	 * Determinate layout direction, currency and other localizations info 
	 * @var Consts with DATATABLE_LOCALIZATION_ prefix
	 */
	protected $localization;
	
	
	/**
	 * Grid width
	 * @var support all css values for 'width' attribute
	 */
	protected $width = '100%';
	
	
	/**
	 * Grid height
	 * @var support all css values for 'height' attribute
	 */
	protected $height;
	
	
	/**
	 * Allow filtering rows
	 * @var boolean
	 */
	protected $filterable;
	
	
	/**
	 * Allow sorting rows
	 * @var boolean
	 */
	protected $sortable;
	
	
	/**
	 * Use two differents backgrounds
	 * @var boolean
	 */
	protected $altRows = true;
	
	
	/**
	 * Allow editing rows
	 * @var boolean
	 */
	protected $editable = false;
	
	
	/**
	 * Determinate how to enter in editing mode
	 * @var Consts with DATATABLE_EDIT_MODE_ prefix
	 */
	protected $editSettings;
	
	
	/**
	 * Rows selections availablity
	 * @var Consts with DATATABLE_SELECTION_MODE_ prefix
	 */
	protected $selectionmode;
	
	
	/**
	 * Enable toolbar
	 * @var boolean
	 */
	protected $showToolbar = true;
	
	
	/**
	 * The toolbar height
	 * @var int
	 */
	protected $toolbarHeight;
	
	
	/**
	 * Available buttons in tools
	 * @var array of consts with DATATABLE_TOLLBAR_BUTTON_ prefix
	 */
	protected $toolbarButtons;
	
	
	/**
	 * 
	 * @var string
	 */
	protected $renderToolbar;
	
	
	/**
	 * Enable pagination
	 * @var boolean
	 */
	protected $pageable = true;
	
	
	/**
	 * Number of pages buttons that whill shown in grid
	 * @var integer
	 */
	protected $pagerButtonsCount = 10;
	
	
	/**
	 * 
	 * @var boolean
	 */
	protected $serverProcessing = true;
	
	
	/**
	 * Allow columns resizing
	 * @var boolean
	 */
	protected $columnsResize = true;
	
	
	/**
	 * Html tag name. it will generate automatically
	 * @var string
	 */
	protected $TagName;
	
	/**
	 * Scripts dependencies
	 * @var array
	 */
	protected $Dependencies;
	
	
	/**
	 * Path to jqwidgets library
	 * @var string
	 */
	protected $JQwidgetsPath;
	
	
	/**
	 * The insert and update form`s URL
	 * @var string
	 */
	protected $formUrl;
	
	/**
	 * Determinate what happen after click on add button
	 * @var unknown
	 */
	protected $addButtonAction;
	
	
	/**
	 * Determinate what happen after click on edit button
	 * @var unknown
	 */
	protected $editButtonAction;
	
		
	
	/**
	 * Get JQwidgetsPath's value
	 * @return JQwidgetsPath's value
	 */
	public function getJQwidgetsPath()
	{
		return $this->JQwidgetsPath;
	}
	
	/**
	 * Set JQwidgetsPath's value
	 * @param string $JQwidgetsPath
	 */
	public function setJQwidgetsPath($value)
	{
		$this->JQwidgetsPath = $value;
	}
	
	/**
	 * Get Dependencies's value
	 * @return Dependencies's value
	 */
	public function getDependencies()
	{
		return $this->Dependencies;
	}
	
	/**
	 * Set Dependencies's value
	 * @param string $Dependencies
	 */
	public function setDependencies($value)
	{
		$this->Dependencies = $value;
	}
	
	
	/**
	 * Get TagName's value
	 * @return TagName's value
	 */
	public function getTagName()
	{
		return $this->TagName;
	}
	
	/**
	 * Set TagName's value
	 * @param string $TagName
	 */
	public function setTagName($value)
	{
		$this->TagName = $value;
	}
	
	public function __construct(array $initData=array())
	{
		foreach ($initData as $attr=>$value)
			$this->$attr 	= $value;
		
		if(!is_array($this->dataFields))
			$this->dataFields  	= array();
		
		if(!isset($this->JQwidgetsPath))
			$this->setJQwidgetsPath(ROOT_URL . 'libPlugins/jqwidgets');
		
		if(!isset($this->editSettings))
			$this->seteditSettings("{ saveOnPageChange: true, saveOnBlur: true, saveOnSelectionChange: true, cancelOnEsc: true, saveOnEnter: true, editSingleCell: true, editOnDoubleClick: true, editOnF2: true }");
		
				
		$this->setDependencies(array(
				'jqx.base.css',
				'jqxdatatable.js',
				'jqxinput.js',
				'jqxpasswordinput.js',
				'jqxslider.js',
				'jqxcheckbox.js',
				'jqxinput.js',
				'jqxtooltip.js',
				'jqxcombobox.js',
				'jqxdropdownlist.js',
				'jqxlistbox.js',
				'jqxdata.export.js',
				'jqxdata.js',
				'jqxmenu.js',
				'jqxscrollbar.js',
				'jqxbuttons.js',
				'jqxcore.js'
		));
		

		/**
		 * generate tag name with current time(Minute, Second, Micro Second)
		 */
		if(!isset($this->TagName))
			$this->setTagName('Raman_Datatable_' . date("isu", time()));
	}
	
	
	public function render()
	{
		$buffer .= "<div id='" . $this->getTagName() . "'></div>";
		
		$buffer .= "<script>$(document).ready(function(){" . $this->generateDependencies($this->generateSource() . $this->generateDataAdapter() . $this->generateDatatable()) . "}); </script>";
		
		return $buffer;
	}
	
	/**
	 * 
	 * @param unknown $url
	 */
	public function setDataSource($url)
	{
		$this->dataSource = $url;
		
		return $this;
	}	

	
	/**
	 *
	 * @param unknown $type
	 */
	public function setDataType($type)
	{
		$this->dataType = $type;
	}
	
	
	/**
	 *
	 * @param integer $primaryKey
	 */
	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
		
		return $this;
	}

	/**
	 * 
	 * @param string $localization
	 */
	public function setLocalization($localization)
	{
		$this->localization = $localization;
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $width
	 */
	public function setWidth($width)
	{
		$this->width = $width;
		
		return $this;
	}
	
	
	/**
	 * 
	 * @param string $height
	 */
	public function setHeight($height)
	{
		$this->height = $height;
		
		return $this;
	}
	
	
	/**
	 *
	 * @param boolean $filterable
	 */
	public function setFilterable($filterable)
	{
		$this->filterable = $filterable;
		
		return $this;
	}
	
	
	/**
	 *
	 * @param boolean $sortable
	 */
	public function setSortable($sortable)
	{
		$this->sortable = $sortable;
		
		return $this;
	}
	
	
	/**
	 *
	 * @param boolean $altRows
	 */
	public function setAltRows($altRows)
	{
		$this->altRows = $altRows;
		
		return $this;
	}
	
	
	/**
	 *
	 * @param boolean $editable
	 */
	public function setEditable($editable)
	{
		$this->editable = $editable;
		
		return $this;
	}
	
	
	/**
	 *
	 * @param string $editSettings
	 */
	public function seteditSettings($editSettings)
	{
		$this->editSettings = $editSettings;
		
		return $this;
	}
	
	
	/**
	 *
	 * @param string $selectionMode
	 */
	public function setSelectionmode($selectionMode)
	{
		$this->selectionmode = $selectionMode;
		
		return $this;
	}
	
		
	/**
	 *
	 * @param boolean $showToolbar
	 */
	public function setShowToolbar($showToolbar)
	{
		$this->showToolbar = $showToolbar;
		
		return $this;
	}
	
	
	/**
	 *
	 * @param string $toolbarHeight
	 */
	public function setToolbarHeight($toolbarHeight)
	{
		$this->toolbarHeight = $toolbarHeight;
		
		return $this;
	}
	
	
	/**
	 * Generate $renderToolbar
	 * @param array $toolbarButtons. array elements have to be one of the consts with DATATABLE_TOLLBAR_BUTTON_ prefix
	 */
	public function setToolbarButtons($toolbarButtons)
	{
		$renderToolbar = "function(toolBar){";		
		
		$renderToolbar .= "var container = $(\"<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>\");";
		
		$renderToolbar .= "var buttonTemplate = \"<div style='float: left; padding: 3px; margin: 2px;'><div style='margin: 4px; width: 16px; height: 16px;'></div></div>\";";
		
		foreach ($toolbarButtons as $button)
		{
			switch ($button)
			{
				case self::DATATABLE_TOLLBAR_BUTTON_ADD:	
					
					$tagName 		= $this->getTagName();
					
					$renderToolbar .= "var addButton = $(buttonTemplate);";
					$renderToolbar .= "container.append(addButton);";	
					$renderToolbar .= "addButton.jqxButton({cursor: \"pointer\", enableDefault: false,  height: 25, width: 25 });";
					$renderToolbar .= "addButton.find('div:first').addClass('jqx-icon-plus');";
					$renderToolbar .= "addButton.jqxTooltip({ position: 'bottom', content: \"Add\"});";

					switch($this->addButtonAction)
					{
					    case self::DATATABLE_BUTTON_ACTION_IN_PLACE:
					        $renderToolbar .= "
    					        addButton.click(function (event) {
        					        if (!addButton.jqxButton('disabled')) {
            					        // add new empty row.
            					        $('#$tagName').jqxDataTable('addRow', null, {}, 'first');
            					        // select the first row and clear the selection.
            					        $('#$tagName').jqxDataTable('clearSelection');
            					        $('#$tagName').jqxDataTable('selectRow', 0);
            					        // edit the new row.
            					        $('#$tagName').jqxDataTable('beginRowEdit', 0);
            					        updateButtons('add');
    					           }
					           });";
					        break;
					        
					    case self::DATATABLE_BUTTON_ACTION_IN_NEW_PAGE:
					        $renderToolbar .= "
    					        addButton.click(function (event) {
        					        document.location = '" . $this->formUrl . "';
    					        });";
					        break;
					        
					    case self::DATATABLE_BUTTON_ACTION_IN_NEW_TAB:
					        $renderToolbar .= "
    					        addButton.click(function (event) {
        					         open('" . $this->formUrl . "');
    					        });";
					        break;
					}
															
					break;
					
					
				case self::DATATABLE_TOLLBAR_BUTTON_UPDATE:
				    
				    $renderToolbar .= "var editButton = $(buttonTemplate);";
				    $renderToolbar .= "container.append(editButton);";
				    $renderToolbar .= "editButton.jqxButton({ cursor: 'pointer', enableDefault: false,  height: 25, width: 25 });";
				    $renderToolbar .= "editButton.find('div:first').addClass('jqx-icon-edit');";
				    $renderToolbar .= "editButton.jqxTooltip({ position: 'bottom', content: 'Edit'});";
				    
				    switch($this->editButtonAction)
				    {
				        case self::DATATABLE_BUTTON_ACTION_IN_PLACE:
				            $renderToolbar .= "
				                editButton.click(function () {
                					if (!editButton.jqxButton('disabled')) {
                						$('#$tagName').jqxDataTable('beginRowEdit', rowIndex);
                						updateButtons('edit');
                					}
                				});";
				            break;
				             
				        case self::DATATABLE_BUTTON_ACTION_IN_NEW_PAGE:
				            $renderToolbar .= "
    					        editButton.click(function (event) {
        					        document.location = '" . $this->formUrl . "?id=' + rowIndex;
    					        });";
				            break;
				             
				        case self::DATATABLE_BUTTON_ACTION_IN_NEW_TAB:
				            $renderToolbar .= "
    					        editButton.click(function (event) {
        					         open('" . $this->formUrl . "?id=' + rowIndex);
    					        });";
				            break;
				    }				    					

					break;
					
				case self::DATATABLE_TOLLBAR_BUTTON_DELETE:
					$renderToolbar .= "var deleteButton = $(buttonTemplate);";
					$renderToolbar .= "container.append(deleteButton);";
					$renderToolbar .= "deleteButton.jqxButton({ cursor: 'pointer', enableDefault: false,  height: 25, width: 25 });";
					$renderToolbar .= "deleteButton.find('div:first').addClass('jqx-icon-delete');";
					$renderToolbar .= "deleteButton.jqxTooltip({ position: 'bottom', content: 'Delete'});";
					
					$renderToolbar .= "deleteButton.click(function () {
						if (!deleteButton.jqxButton('disabled')) {
						
							var selectedRows = $('#$tagName').jqxDataTable('getSelection');

							 if (selectedRows && selectedRows.length > 0) 
							 {
							 	var rows = $('#$tagName').jqxDataTable('getRows');
							 	
							 	for(i=0; i<selectedRows.length; i++)
							 	{
								 	var rowId = rows.indexOf(selectedRows[i]);
								 									 									 
							 		$('#$tagName').jqxDataTable('deleteRow', rowId);
						 		}
							 }
														
							updateButtons('delete');					
						}						
					});";
					
					break;									
					
				case self::DATATABLE_TOLLBAR_BUTTON_PRINT:
					$renderToolbar .= "var printButton = $(buttonTemplate);";
					$renderToolbar .= "container.append(printButton);";
					$renderToolbar .= "printButton.jqxButton({ cursor: 'pointer', enableDefault: false,  height: 25, width: 25 });";
					$renderToolbar .= "printButton.find('div:first').addClass('glyphicon glyphicon-print');";
					$renderToolbar .= "printButton.jqxTooltip({ position: 'bottom', content: 'Print'});";
					break;
						
				case self::DATATABLE_TOLLBAR_BUTTON_EXCEL:
					break;
			}
		}
		
		$renderToolbar .= "toolBar.append(container);";
		
		$renderToolbar .= "
			var updateButtons = function (action) {
        	 	switch (action) {
                        
                    	case 'Select':
                        	addButton.jqxButton({ disabled: false });
                            deleteButton.jqxButton({ disabled: false });
                            editButton.jqxButton({ disabled: false });
                            break;
                                
                    	case 'Unselect':
                            addButton.jqxButton({ disabled: false });
                            deleteButton.jqxButton({ disabled: true });
                            editButton.jqxButton({ disabled: true });
                            break;
                                
                    	case 'Edit':
                    		addButton.jqxButton({ disabled: true });
                        	deleteButton.jqxButton({ disabled: true });
                        	editButton.jqxButton({ disabled: true });
                       		break;
                                
                    	case 'End Edit':
                        	addButton.jqxButton({ disabled: false });
                            deleteButton.jqxButton({ disabled: false });
                            editButton.jqxButton({ disabled: false });                       
                    		break;

                	}
                }		
		
		
				var rowIndex = null;				
				
                $('#$tagName').on('rowSelect', function (event) {
                	var args = event.args;
                	rowIndex = args.index;
                	updateButtons('Select');
                });
                
                $('#$tagName').on('rowUnselect', function (event) {
                	updateButtons('Unselect');
                });
                
                $('#$tagName').on('rowEndEdit', function (event) {
                	updateButtons('End Edit');
                });
                
                $('#$tagName').on('rowBeginEdit', function (event) {
                	updateButtons('Edit');
                });
        ";
		
		$renderToolbar .= "}\r\n";//end toolbar renderer function
		
		$this->renderToolbar = $renderToolbar;
		
		return $this;
	}
	
	
	/**
	 * 
	 * @param boolean $pageable
	 */
	public function setPagable($pageable)
	{
		$this->pageable = $pageable;
		
		return $this;
	}
	
			
	/**
	 * 
	 * @param integer $pagerButtonsCount
	 */
	public function setPagerButtonsCount($pagerButtonsCount)
	{
		$this->pagerButtonsCount 	= $pagerButtonsCount;
		
		return $this;
	}
	
	/**
	 *
	 * @param boolean $serverProcessing
	 */
	public function setServerProcessing($serverProcessing)
	{
		$this->serverProcessing = $serverProcessing;
		
		return $this;
	}
	
	/**
	 *
	 * @param boolean $columnsResize
	 */
	public function setColumnsResize($columnsResize)
	{
		$this->columnsResize = $columnsResize;
		
		return $this;
	}
	
	
	public function setFormUrl($formUrl)
	{
	    $this->formUrl = $formUrl;
	}
	
	public function setAddButtonAction($addButtonAction)
	{
	    $this->addButtonAction = $addButtonAction;
	}
	
	public function editButtonAction($editButtonAction)
	{
	    $this->editButtonAction = $editButtonAction;
	}
	
	/**
	 * Add a new column to grid
	 * @param Raman_View_Helper_DatatableColumn $column	 
	 * @return void
	 */
	public function addColumn($column)
	{						
		array_push($this->dataFields, $column->getColumn());
		
		return $this;
	}
	
	public function addColumns(array $columns)
	{
		foreach ($columns as $column)
			array_push($this->dataFields, $column->getColumn());
		
		return $this;
	}
	
	
	/**
	 * generate source object
	 */
	protected function generateSource()
	{
		$dataType 	= $this->dataType;	
		$primaryKey = $this->primaryKey;
		$dataSource = $this->dataSource;		
		$dataFields = array();
		
		foreach ($this->dataFields as $dataField)
		{			
			$field = array();
			$field['name'] = $dataField['dataField'];
			
			if(isset($dataField['type']))
				$field['type'] = $dataField['type'];

			$dataFields[] = $field;
		}
		
		$dataFields 	= json_encode($dataFields);
		
		return "							
			var source =
			{			
				dataType: '$dataType',
				dataFields: $dataFields,
				id: '$primaryKey',
				url: '$dataSource'
			};		
		";
	}
	
	
	/**
	 * generate dataAdapter object
	 */
	protected function generateDataAdapter()
	{
		return "					
			var dataAdapter = new $.jqx.dataAdapter(source,
			{
				formatData: function (data) {
					data.\$skip = data.pagenum * data.pagesize;
                    data.\$top = data.pagesize;
                    data.\$inlinecount = 'allpages';
			
					return data;
				},
                downloadComplete: function (data, status, xhr) {
                	if (!source.totalRecords) {
                    	source.totalRecords = parseInt(data['odata.count']);
                    }
                },
                loadError: function (xhr, status, error) {
                    throw new Error('Unfortunately an exception has been occurred');
                }
			});			
		";
	}
	
	/**
	 * Generate Datatable HTML
	 * @return string
	 */
	protected function generateDatatable()
	{		
		
		if(isset($this->localization))
			$localization = "localization:'" . $this->localization . "',";
		
		if(isset($this->width))
			$width 	= "width:'" . $this->width . "',";	

		if(isset($this->height))
			$height = "height:'" . $this->height . "',";
		
		if(isset($this->filterable) && $this->filterable === true)
			$filterable = "filterable:true,";
		
		if(isset($this->sortable) && $this->sortable === true)
			$sortable = "sortable:true,";
		
		if(isset($this->altRows) && $this->altRows === true)
			$altRows = "altRows: true,";
		
		if(isset($this->editable) && $this->editable === true)
			$editable = "editable:true,";
		
		if(isset($this->editSettings))
			$editSettings = "editSettings:" . $this->editSettings . ",";
		
		if(isset($this->selectionmode))
			$selectionmode = "selectionmode:" . $this->selectionmode . ',';
		
		/*
		 * set default to true
		 */
		if(isset($this->showToolbar) && $this->showToolbar === false)
			$showToolbar = "showToolbar:false,";
		else 
			$showToolbar = "showToolbar:true,";
		
		if(isset($this->toolbarHeight))
			$toolbarHeight = "toolbarHeight:" . $this->toolbarHeight . ',';
		
		/*
		 * Set standard toolbar is not set
		 */
		if(isset($this->renderToolbar))
		{
			$renderToolbar = "renderToolbar:" . $this->renderToolbar . ',';		
		}
		else 
		{
			$this->setToolbarButtons(array(
					Raman_View_Helper_Datatable::DATATABLE_TOLLBAR_BUTTON_ADD,				
					Raman_View_Helper_Datatable::DATATABLE_TOLLBAR_BUTTON_UPDATE,
					Raman_View_Helper_Datatable::DATATABLE_TOLLBAR_BUTTON_DELETE,
					Raman_View_Helper_Datatable::DATATABLE_TOLLBAR_BUTTON_PRINT,
					Raman_View_Helper_Datatable::DATATABLE_TOLLBAR_BUTTON_EXCEL
			));
			
			$renderToolbar = "renderToolbar:" . $this->renderToolbar . ',';
		}
		
		if(isset($this->pageable) && $this->pageable === true)
			$pagable = "pageable:true,";
		
		if(isset($this->pagerButtonsCount))
			$pagerButtonsCount = "pagerButtonsCount:" . $this->pagerButtonsCount . ',';
		
		if(isset($this->serverProcessing) && $this->serverProcessing === true)
			$serverProcessing = 'serverProcessing:true,';				
		
		if(isset($this->columnsResize) && $this->columnsResize === true)
			$columnsResize = "columnsResize:true,";
		
		
		
		$columns = $this->removeQoutes(json_encode($this->dataFields));
		
		$tagName = $this->getTagName();
		
		return "					
			$('#$tagName').jqxDataTable(
			{				
				$localization
				$width
				$height
				$filterable
				$sortable
				$altRows
				$editable
				$editSettings
				$selectionmode
				$showToolbar
				$toolbarHeight
				$renderToolbar				
				$pagable
				$pagerButtonsCount
				$serverProcessing								
				$columnsResize				
				source: dataAdapter,
				columns: $columns
			});			
		";
	}
	
	public function generateDependencies($callback)
	{
		
		$JQwidgetsPath 	= $this->getJQwidgetsPath();
				
		
		$scriptsPath 	= array();
		$stylesPath 	= array();


		$extPattern 	= "@^.*\.([^.]*)$@";
		
		foreach ($this->getDependencies() as $depend)
		{

			preg_match($extPattern, $depend, $matches);
			$extention 	= $matches[1];
			
			switch($extention)
			{
				case 'js':
					$scriptsPath[] 	= "$JQwidgetsPath/$depend";					
					break;
					
				case 'css':
					$stylesPath[] 	= "$JQwidgetsPath\/styles\/$depend";					
					break;						
			}						
			
		}
		
		$scripts 	= $this->loadJavascripts($scriptsPath, $callback);
		$styles 	= $this->loadStyles($stylesPath);
		
		Zend_Registry::set('loadedScripts', $loadedScripts);
		
		return "$styles  $scripts" ;
	}
	
	protected function loadJavascripts(array $paths, $callback)
	{
		if(sizeof($paths) == 0)
			return;
		
		$currentPath = array_pop($paths);
		
		if(sizeof($paths) > 0)
			$nextScript 	= $this->loadJavascripts($paths, $callback);
		else 
			$nextScript 	= $callback;
		
		return "$.getScript('$currentPath', function(data, textStatus, jqxhr){ $nextScript }); ";

	}
	
	protected function loadStyles(array $paths)
	{
		if(sizeof($paths) == 0)
			return;
		
		$currentPath = array_pop($paths);
		
		if(sizeof($paths) > 0)
			$callback 	= $this->loadStyles($paths);
		
		return "$('<link>').appendTo('head').attr({type : 'text\/css', rel : 'stylesheet'}).attr('href', '$currentPath'); $callback";
	}
	

	
	/**
	 * Remove Qoutes from determinated locations
	 * @param string $jsonString
	 */
	protected function removeQoutes($jsonString)
	{
		return str_replace(array(
				'"QOUTE_REMOVER',
				'QOUTE_REMOVER"',
				"'QOUTE_REMOVER",
				"QOUTE_REMOVER'"
		), '', $jsonString);
	}
}