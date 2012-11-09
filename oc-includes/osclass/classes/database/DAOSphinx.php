<?php

/**
 * OSClass – software for creating and publishing online classified advertising platforms
 *
 * Copyright (C) 2010 OSCLASS
 *
 * This program is free software: you can redistribute it and/or modify it under the terms
 * of the GNU Affero General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * DAO base model
 * 
 * @package OSClass
 * @subpackage Model
 * @since 2.3
 */
class DAOSphinx
{
	/**
	 * DBCommandClass object
	 * 
	 * @acces public
	 * @since 2.3
	 * @var DBCommandClass 
	 */
	var $dao ;
	/**
	 * Table name
	 * 
	 * @access private
	 * @since unknown
	 * @var string 
	 */
	var $tableName ;
	/**
	 * Table prefix
	 * 
	 * @access private
	 * @since unknown
	 * @var string 
	 */
	var $tablePrefix ;
	/**
	 * Primary key of the table
	 *
	 * @access private
	 * @since 2.3
	 * @var string 
	 */
	var $primaryKey ;
	/**
	 * Fields of the table
	 * 
	 * @access private
	 * @since 2.3
	 * @var array 
	 */
	var $fields ;
	
	/**
	       * Indicates whether to use SphinxSE
	       * 
	       * @access private
	       * @var bool 
	       */

	/**
	 * Init connection of the database and create DBCommandClass object
	 */
	function __construct( $sphinx = false)
	{
		$conn              = DBConnectionClassSphnix::newInstance() ;
		$data              = $conn->getOsclassDb();
		$this->dao         = new DBCommandClassSphinx($data) ;
		$this->tablePrefix = DB_TABLE_PREFIX ;
	}
	
	/**
	 * Reinitialize connection to the database once the object is unserialized
	 */
	public function __wakeup()
	{
		$conn              = DBConnectionClass::newInstance($this->useSphinx) ;
		$data              = $conn->getOsclassDb();
		$this->dao         = new DBCommandClass($data) ;
	}

	/**
	 * Get the result match of the primary key passed by parameter
	 * 
	 * @access public
	 * @since unknown
	 * @param string $value
	 * @return mixed If the result has been found, it return the array row. If not, it returns false
	 */
	function findByPrimaryKey($value)
	{
		$this->dao->select($this->fields) ;
		$this->dao->from($this->getTableName()) ;
		$this->dao->where($this->getPrimaryKey(), $value) ;
		$result = $this->dao->get() ;

		if( $result === false ) {
			return false ;
		}

		if( $result->numRows() !== 1 ) {
			return false ;
		}

		return $result->row() ;
	}

	/**
	 * Update row by primary key
	 * 
	 * @access public
	 * @since unknown
	 * @param array $values Array with keys (database field) and values
	 * @param string $key Primary key to be updated
	 * @return mixed It return the number of affected rows if the update has been 
	 * correct or false if nothing has been modified
	 */
	function updateByPrimaryKey($values, $key)
	{
		$cond = array(
			$this->getPrimaryKey() => $key
			) ;

		return $this->update($values, $cond) ;
	}

	/**
	 * Delete the result match from the primary key passed by parameter
	 * 
	 * @access public
	 * @since unknown
	 * @param string $value
	 * @return mixed It return the number of affected rows if the delete has been 
	 * correct or false if nothing has been modified
	 */
	function deleteByPrimaryKey($value)
	{
		$cond = array(
			$this->getPrimaryKey() => $value
			) ;

		return $this->delete($cond) ;
	}

	/**
	 * Get all the rows from the table $tableName
	 * 
	 * @access public
	 * @since unknown
	 * @return array 
	 */
	function listAll()
	{
		$this->dao->select($this->getFields()) ;
		$this->dao->from($this->getTableName()) ;
		$result = $this->dao->get() ;

		if($result == false) {
			return array() ;
		}

		return $result->result() ;
	}

	/**
	 * Basic insert
	 * 
	 * @access public
	 * @since unknown
	 * @param array $values
	 * @return boolean 
	 */
	function insert($values)
	{
		if( !$this->checkFieldKeys(array_keys($values)) ) {
			return false ;
		}

		$this->dao->from($this->getTableName()) ;
		$this->dao->set($values) ;
		return $this->dao->insert() ;
	}

	/**
	 * Basic update. It returns false if the keys from $values or $where doesn't
	 * match with the fields defined in the construct
	 * 
	 * @access public
	 * @since unknown
	 * @param array $values Array with keys (database field) and values
	 * @param array $where
	 * @return mixed It returns the number of affected rows if the update has been 
	 * correct or false if an error happended
	 */
	function update($values, $where)
	{
		if( !$this->checkFieldKeys(array_keys($values)) ) {
			return false ;
		}

		if( !$this->checkFieldKeys(array_keys($where)) ) {
			return false ;
		}

		$this->dao->from($this->getTableName()) ;
		$this->dao->set($values) ;
		$this->dao->where($where) ;
		return $this->dao->update() ;
	}

	/**
	 * Basic delete. It returns false if the keys from $where doesn't
	 * match with the fields defined in the construct
	 * 
	 * @access public
	 * @since unknown
	 * @param array $where
	 * @return mixed It returns the number of affected rows if the delete has been 
	 * correct or false if an error happended
	 */
	function delete($where)
	{
		if( !$this->checkFieldKeys(array_keys($where)) ) {
			return false ;
		}

		$this->dao->from($this->getTableName()) ;
		$this->dao->where($where) ;
		return $this->dao->delete() ;
	}

	/**
	 * Set table name, adding the DB_TABLE_PREFIX at the beginning
	 * 
	 * @access private
	 * @since unknown
	 * @param string $table 
	 */
	function setTableName($table)
	{
		$this->tableName = $this->tablePrefix . $table ;
	}

	/**
	 * Get table name
	 * 
	 * @access public
	 * @since unknown
	 * @return string 
	 */
	function getTableName()
	{
		return $this->tableName ;
	}

	/**
	 * Set primary key string
	 * 
	 * @access private
	 * @since unknown
	 * @param string $key 
	 */
	function setPrimaryKey($key)
	{
		$this->primaryKey = $key ;
	}

	/**
	 * Get primary key string
	 * 
	 * @access public
	 * @since unknown
	 * @return string 
	 */
	function getPrimaryKey()
	{
		return $this->primaryKey ;
	}

	/**
	 * Set fields array
	 * 
	 * @access private
	 * @since 2.3
	 * @param array $fields 
	 */
	function setFields($fields)
	{
		$this->fields = $fields ;
	}

	/**
	 * Get fields array
	 * 
	 * @access public
	 * @since 2.3
	 * @return array 
	 */
	function getFields()
	{
		return $this->fields ;
	}

	/**
	 * Check if the keys of the array exist in the $fields array
	 * 
	 * @access private
	 * @since 2.3
	 * @param array $aKey
	 * @return boolean 
	 */
	function checkFieldKeys($aKey)
	{
		foreach($aKey as $key) {
			if( !in_array($key, $this->getFields()) ) {
				return false ;
			}
		}

		return true ;
	}

	/**
	 * Get table prefix
	 * 
	 * @access public
	 * @since 2.3
	 * @return string 
	 */
	function getTablePrefix()
	{
		return $this->tablePrefix ;
	}

	/**
	 * Returns the last error code for the most recent mysqli function call
	 * 
	 * @access public
	 * @since 2.3
	 * @return int 
	 */
	function getErrorLevel()
	{
		return $this->dao->getErrorLevel() ;
	}

	/**
	 * Returns a string description of the last error for the most recent MySQLi function call
	 * 
	 * @access public
	 * @since 2.3
	 * @return string 
	 */
	function getErrorDesc()
	{
		return $this->dao->getErrorDesc() ;
	}

	/**
	 * Returns the number of rows in the table represented by this object.
	 * 
	 * @access public
	 * @since unknown
	 * @return int
	 */
	public function count()
	{
		$this->dao->select('COUNT(*) AS count') ;
		$this->dao->from($this->getTableName()) ;
		$result = $this->dao->get() ;

		if( $result == false ) {
			return 0 ;
		}

		if( $result->numRows() == 0 ) {
			return 0 ;
		}

		$row = $result->row() ;
		return $row['count'] ;
	}
}

/* file end: ./oc-includes/osclass/classes/database/DAO.php */
?>