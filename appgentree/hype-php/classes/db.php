<?php



/**



 * WordPress Database Access Abstraction Object



 *



 * It is possible to replace this class with your own



 * by setting the $wpdb global variable in wp-content/db.php



 * file to your class. The wpdb class will still be included,



 * so you can extend it or simply use your own.



 *



 * @link http://codex.wordpress.org/Function_Reference/wpdb_Class



 *



 * @package WordPress



 * @subpackage Database



 * @since 0.71



 */



 



define( 'EZSQL_VERSION', 'WP1.25' );







/**



 * @since 0.71



 */



define( 'OBJECT', 'OBJECT', true );







/**



 * @since 2.5.0



 */



define( 'OBJECT_K', 'OBJECT_K' );







/**



 * @since 0.71



 */



define( 'ARRAY_A', 'ARRAY_A' );







/**



 * @since 0.71



 */



define( 'ARRAY_N', 'ARRAY_N' );











class wpdb {







	/**



	 * Whether to show SQL/DB errors



	 *



	 * @since 0.71



	 * @access private



	 * @var bool



	 */



	var $show_errors = false;







	/**



	 * Whether to suppress errors during the DB bootstrapping.



	 *



	 * @access private



	 * @since 2.5.0



	 * @var bool



	 */



	var $suppress_errors = false;







	/**



	 * The last error during query.



	 *



	 * @since 2.5.0



	 * @var string



	 */



	var $last_error = '';







	/**



	 * Amount of queries made



	 *



	 * @since 1.2.0



	 * @access private



	 * @var int



	 */



	var $num_queries = 0;







	/**



	 * Count of rows returned by previous query



	 *



	 * @since 0.71



	 * @access private



	 * @var int



	 */



	var $num_rows = 0;







	/**



	 * Count of affected rows by previous query



	 *



	 * @since 0.71



	 * @access private



	 * @var int



	 */



	var $rows_affected = 0;







	/**



	 * The ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT).



	 *



	 * @since 0.71



	 * @access public



	 * @var int



	 */



	var $insert_id = 0;







	/**



	 * Last query made



	 *



	 * @since 0.71



	 * @access private



	 * @var array



	 */



	var $last_query;







	/**



	 * Results of the last query made



	 *



	 * @since 0.71



	 * @access private



	 * @var array|null



	 */



	var $last_result;







	/**



	 * MySQL result, which is either a resource or boolean.



	 *



	 * @since 0.71



	 * @access protected



	 * @var mixed



	 */



	protected $result;







	/**



	 * Saved info on the table column



	 *



	 * @since 0.71



	 * @access protected



	 * @var array



	 */



	protected $col_info;







	/**



	 * Saved queries that were executed



	 *



	 * @since 1.5.0



	 * @access private



	 * @var array



	 */



	var $queries;







	/**



	 * WordPress table prefix



	 *



	 * You can set this to have multiple WordPress installations



	 * in a single database. The second reason is for possible



	 * security precautions.



	 *



	 * @since 2.5.0



	 * @access private



	 * @var string



	 */



	var $prefix = '';







	/**



	 * Whether the database queries are ready to start executing.



	 *



	 * @since 2.3.2



	 * @access private



	 * @var bool



	 */



	var $ready = false;







	/**



	 * List of WordPress global tables



	 *



	 * @since 3.0.0



	 * @access private



	 * @see wpdb::tables()



	 * @var array



	 */



	var $tables = array( 'users', 'usermeta' );







	/**



	 * WordPress Comments table



	 *



	 * @since 1.5.0



	 * @access public



	 * @var string



	 */



	var $comments;







	/**



	 * WordPress Comment Metadata table



	 *



	 * @since 2.9.0



	 * @access public



	 * @var string



	 */



	var $commentmeta;







	/**



	 * WordPress Links table



	 *



	 * @since 1.5.0



	 * @access public



	 * @var string



	 */



	var $links;







	/**



	 * WordPress Options table



	 *



	 * @since 1.5.0



	 * @access public



	 * @var string



	 */



	var $options;







	/**



	 * WordPress Post Metadata table



	 *



	 * @since 1.5.0



	 * @access public



	 * @var string



	 */



	var $postmeta;







	/**



	 * WordPress Posts table



	 *



	 * @since 1.5.0



	 * @access public



	 * @var string



	 */



	var $posts;







	/**



	 * WordPress Terms table



	 *



	 * @since 2.3.0



	 * @access public



	 * @var string



	 */



	var $terms;







	/**



	 * WordPress Term Relationships table



	 *



	 * @since 2.3.0



	 * @access public



	 * @var string



	 */



	var $term_relationships;







	/**



	 * WordPress Term Taxonomy table



	 *



	 * @since 2.3.0



	 * @access public



	 * @var string



	 */



	var $term_taxonomy;







	/*



	 * Global and Multisite tables



	 */







	/**



	 * WordPress User Metadata table



	 *



	 * @since 2.3.0



	 * @access public



	 * @var string



	 */



	var $usermeta;







	/**



	 * WordPress Users table



	 *



	 * @since 1.5.0



	 * @access public



	 * @var string



	 */



	var $users;







	/**



	 * Multisite Blogs table



	 *



	 * @since 3.0.0



	 * @access public



	 * @var string



	 */



	var $blogs;







	/**



	 * Multisite Blog Versions table



	 *



	 * @since 3.0.0



	 * @access public



	 * @var string



	 */



	var $blog_versions;







	/**



	 * Multisite Registration Log table



	 *



	 * @since 3.0.0



	 * @access public



	 * @var string



	 */



	var $registration_log;







	/**



	 * Multisite Signups table



	 *



	 * @since 3.0.0



	 * @access public



	 * @var string



	 */



	var $signups;







	/**



	 * Format specifiers for DB columns. Columns not listed here default to %s. Initialized during WP load.



	 *



	 * Keys are column names, values are format types: 'ID' => '%d'



	 *



	 * @since 2.8.0



	 * @see wpdb::prepare()



	 * @see wpdb::insert()



	 * @see wpdb::update()



	 * @see wpdb::delete()



	 * @see wp_set_wpdb_vars()



	 * @access public



	 * @var array



	 */



	var $field_types = array();







	/**



	 * Database table columns charset



	 *



	 * @since 2.2.0



	 * @access public



	 * @var string



	 */



	var $charset;







	/**



	 * Database table columns collate



	 *



	 * @since 2.2.0



	 * @access public



	 * @var string



	 */



	var $collate;







	/**



	 * Database Username



	 *



	 * @since 2.9.0



	 * @access protected



	 * @var string



	 */



	protected $dbuser;







	/**



	 * Database Password



	 *



	 * @since 3.1.0



	 * @access protected



	 * @var string



	 */



	protected $dbpassword;







	/**



	 * Database Name



	 *



	 * @since 3.1.0



	 * @access protected



	 * @var string



	 */



	protected $dbname;







	/**



	 * Database Host



	 *



	 * @since 3.1.0



	 * @access protected



	 * @var string



	 */



	protected $dbhost;







	/**



	 * Database Handle



	 *



	 * @since 0.71



	 * @access protected



	 * @var string



	 */



	protected $dbh;







	/**



	 * A textual description of the last query/get_row/get_var call



	 *



	 * @since 3.0.0



	 * @access public



	 * @var string



	 */



	var $func_call;







	/**



	 * Whether MySQL is used as the database engine.



	 *



	 * Set in WPDB::db_connect() to true, by default. This is used when checking



	 * against the required MySQL version for WordPress. Normally, a replacement



	 * database drop-in (db.php) will skip these checks, but setting this to true



	 * will force the checks to occur.



	 *



	 * @since 3.3.0



	 * @access public



	 * @var bool



	 */



	public $is_mysql = null;







	/**



	 * Connects to the database server and selects a database



	 *



	 * PHP5 style constructor for compatibility with PHP5. Does



	 * the actual setting up of the class properties and connection



	 * to the database.



	 *



	 * @link http://core.trac.wordpress.org/ticket/3354



	 * @since 2.0.8



	 *



	 * @param string $dbuser MySQL database user



	 * @param string $dbpassword MySQL database password



	 * @param string $dbname MySQL database name



	 * @param string $dbhost MySQL database host



	 */



	function __construct( $dbuser, $dbpassword, $dbname, $dbhost ) {



		register_shutdown_function( array( $this, '__destruct' ) );







		$this->dbuser = $dbuser;



		$this->dbpassword = $dbpassword;



		$this->dbname = $dbname;



		$this->dbhost = $dbhost;







		$this->db_connect();



	}







	/**



	 * PHP5 style destructor and will run when database object is destroyed.



	 *



	 * @see wpdb::__construct()



	 * @since 2.0.8



	 * @return bool true



	 */



	function __destruct() {



		return true;



	}







	/**



	 * Magic function, for backwards compatibility



	 *



	 * @since 3.5.0



	 *



	 * @param string $name  The private member to check



	 *



	 * @return bool If the member is set or not



	 */



	function __isset( $name ) {



		return isset( $this->$name );



	}







	/**



	 * Magic function, for backwards compatibility



	 *



	 * @since 3.5.0



	 *



	 * @param string $name  The private member to unset



	 */



	function __unset( $name ) {



		unset( $this->$name );



	}







	/**



	 * Selects a database using the current database connection.



	 *



	 * The database name will be changed based on the current database



	 * connection. On failure, the execution will bail and display an DB error.



	 *



	 * @since 0.71



	 *



	 * @param string $db MySQL database name



	 * @param resource $dbh Optional link identifier.



	 * @return null Always null.



	 */



	function select( $db, $dbh = null ) {



		if ( is_null($dbh) )



			$dbh = $this->dbh;







		if ( !@mysql_select_db( $db, $dbh ) ) {



			$this->ready = false;



			return;



		}



	}







	/**



	 * Real escape, using mysql_real_escape_string()



	 *



	 * @see mysql_real_escape_string()



	 * @since 2.8.0



	 * @access private



	 *



	 * @param  string $string to escape



	 * @return string escaped



	 */



	function _real_escape( $string ) {



		if ( $this->dbh )



			return mysql_real_escape_string( $string, $this->dbh );







		$class = get_class( $this );



		return addslashes( $string );



	}







	/**



	 * Escape data. Works on arrays.



	 *



	 * @uses wpdb::_real_escape()



	 * @since  2.8.0



	 * @access private



	 *



	 * @param  string|array $data



	 * @return string|array escaped



	 */



	function _escape( $data ) {



		if ( is_array( $data ) ) {



			foreach ( $data as $k => $v ) {



				if ( is_array($v) )



					$data[$k] = $this->_escape( $v );



				else



					$data[$k] = $this->_real_escape( $v );



			}



		} else {



			$data = $this->_real_escape( $data );



		}







		return $data;



	}







	/**



	 * Do not use, deprecated.



	 *



	 * Use esc_sql() or wpdb::prepare() instead.



	 *



	 * @since 0.71



	 * @deprecated 3.6.0



	 * @see wpdb::prepare()



	 * @see esc_sql()



	 *



	 * @param mixed $data



	 * @return mixed



	 */



	function escape( $data ) {



		if ( func_num_args() === 1 && function_exists( '_deprecated_function' ) )



			_deprecated_function( __METHOD__, '3.6', 'wpdb::prepare() or esc_sql()' );



		if ( is_array( $data ) ) {



			foreach ( $data as $k => $v ) {



				if ( is_array( $v ) )



					$data[$k] = $this->escape( $v, 'recursive' );



				else



					$data[$k] = $this->_weak_escape( $v, 'internal' );



			}



		} else {



			$data = $this->_weak_escape( $data, 'internal' );



		}







		return $data;



	}







	/**



	 * Escapes content by reference for insertion into the database, for security



	 *



	 * @uses wpdb::_real_escape()



	 * @since 2.3.0



	 * @param string $string to escape



	 * @return void



	 */



	function escape_by_ref( &$string ) {



		if ( ! is_float( $string ) )



			$string = $this->_real_escape( $string );



	}







	/**



	 * Prepares a SQL query for safe execution. Uses sprintf()-like syntax.



	 *



	 * The following directives can be used in the query format string:



	 *   %d (integer)



	 *   %f (float)



	 *   %s (string)



	 *   %% (literal percentage sign - no argument needed)



	 *



	 * All of %d, %f, and %s are to be left unquoted in the query string and they need an argument passed for them.



	 * Literals (%) as parts of the query must be properly written as %%.



	 *



	 * This function only supports a small subset of the sprintf syntax; it only supports %d (integer), %f (float), and %s (string).



	 * Does not support sign, padding, alignment, width or precision specifiers.



	 * Does not support argument numbering/swapping.



	 *



	 * May be called like {@link http://php.net/sprintf sprintf()} or like {@link http://php.net/vsprintf vsprintf()}.



	 *



	 * Both %d and %s should be left unquoted in the query string.



	 *



	 * <code>



	 * wpdb::prepare( "SELECT * FROM `table` WHERE `column` = %s AND `field` = %d", 'foo', 1337 )



	 * wpdb::prepare( "SELECT DATE_FORMAT(`field`, '%%c') FROM `table` WHERE `column` = %s", 'foo' );



	 * </code>



	 *



	 * @link http://php.net/sprintf Description of syntax.



	 * @since 2.3.0



	 *



	 * @param string $query Query statement with sprintf()-like placeholders



	 * @param array|mixed $args The array of variables to substitute into the query's placeholders if being called like



	 * 	{@link http://php.net/vsprintf vsprintf()}, or the first variable to substitute into the query's placeholders if



	 * 	being called like {@link http://php.net/sprintf sprintf()}.



	 * @param mixed $args,... further variables to substitute into the query's placeholders if being called like



	 * 	{@link http://php.net/sprintf sprintf()}.



	 * @return null|false|string Sanitized query string, null if there is no query, false if there is an error and string



	 * 	if there was something to prepare



	 */



	function prepare( $query, $args ) {



		if ( is_null( $query ) )



			return;







		$args = func_get_args();



		array_shift( $args );



		// If args were passed as an array (as in vsprintf), move them up



		if ( isset( $args[0] ) && is_array($args[0]) )



			$args = $args[0];



		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it



		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting



		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware



		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s



		array_walk( $args, array( $this, 'escape_by_ref' ) );



		return @vsprintf( $query, $args );



	}







	/**



	 * Print SQL/DB error.



	 *



	 * @since 0.71



	 * @global array $EZSQL_ERROR Stores error information of query and error string



	 *



	 * @param string $str The error to display



	 * @return bool False if the showing of errors is disabled.



	 */



	function print_error( $str = '' ) {



		global $EZSQL_ERROR;







		if ( !$str )



			$str = mysql_error( $this->dbh );

			

			print "<div id='error'>



			<p class='wpdberror'><strong>Database error:</strong> [$str]<br />



			<code>$this->last_query</code></p>



			</div>";



	}







	/**



	 * Enables showing of database errors.



	 *



	 * This function should be used only to enable showing of errors.



	 * wpdb::hide_errors() should be used instead for hiding of errors. However,



	 * this function can be used to enable and disable showing of database



	 * errors.



	 *



	 * @since 0.71



	 * @see wpdb::hide_errors()



	 *



	 * @param bool $show Whether to show or hide errors



	 * @return bool Old value for showing errors.



	 */



	function show_errors( $show = true ) {



		$errors = $this->show_errors;



		$this->show_errors = $show;



		return $errors;



	}







	/**



	 * Disables showing of database errors.



	 *



	 * By default database errors are not shown.



	 *



	 * @since 0.71



	 * @see wpdb::show_errors()



	 *



	 * @return bool Whether showing of errors was active



	 */



	function hide_errors() {



		$show = $this->show_errors;



		$this->show_errors = false;



		return $show;



	}







	/**



	 * Whether to suppress database errors.



	 *



	 * By default database errors are suppressed, with a simple



	 * call to this function they can be enabled.



	 *



	 * @since 2.5.0



	 * @see wpdb::hide_errors()



	 * @param bool $suppress Optional. New value. Defaults to true.



	 * @return bool Old value



	 */



	function suppress_errors( $suppress = true ) {



		$errors = $this->suppress_errors;



		$this->suppress_errors = (bool) $suppress;



		return $errors;



	}







	/**



	 * Kill cached query results.



	 *



	 * @since 0.71



	 * @return void



	 */



	function flush() {



		$this->last_result = array();



		$this->col_info    = null;



		$this->last_query  = null;



		$this->rows_affected = $this->num_rows = 0;



		$this->last_error  = '';







		if ( is_resource( $this->result ) )



			mysql_free_result( $this->result );



	}







	/**



	 * Connect to and select database



	 *



	 * @since 3.0.0



	 */



	function db_connect() {







		$this->is_mysql = true;







		$new_link = defined( 'MYSQL_NEW_LINK' ) ? MYSQL_NEW_LINK : true;



		$client_flags = defined( 'MYSQL_CLIENT_FLAGS' ) ? MYSQL_CLIENT_FLAGS : 0;







		if ( WP_DEBUG ) {



			$this->dbh = mysql_connect( $this->dbhost, $this->dbuser, $this->dbpassword, $new_link, $client_flags );



		} else {



			$this->dbh = @mysql_connect( $this->dbhost, $this->dbuser, $this->dbpassword, $new_link, $client_flags );



		}







		if ( !$this->dbh ) {



			



			$this->bail( sprintf( __( "



<h1>Error establishing a database connection</h1>



<p>This either means that the username and password information in your <code>wp-config.php</code> file is incorrect or we can't contact the database server at <code>%s</code>. This could mean your host's database server is down.</p>



<ul>



	<li>Are you sure you have the correct username and password?</li>



	<li>Are you sure that you have typed the correct hostname?</li>



	<li>Are you sure that the database server is running?</li>



</ul>



<p>If you're unsure what these terms mean you should probably contact your host. If you still need help you can always visit the <a href='http://wordpress.org/support/'>WordPress Support Forums</a>.</p>



" ), htmlspecialchars( $this->dbhost, ENT_QUOTES ) ), 'db_connect_fail' );







			return;



		}







		$this->ready = true;







		$this->select( $this->dbname, $this->dbh );



	}







	/**



	 * Perform a MySQL database query, using current database connection.



	 *



	 * More information can be found on the codex page.



	 *



	 * @since 0.71



	 *



	 * @param string $query Database query



	 * @return int|false Number of rows affected/selected or false on error



	 */



	function query( $query ) {



		if ( ! $this->ready )



			return false;



		/**



		 * Filter the database query.



		 *



		 * Some queries are made before the plugins have been loaded, and thus cannot be filtered with this method.



		 *



		 * @since 2.1.0



		 * @param string $query Database query.



		 */



		//$query = apply_filters( 'query', $query );







		$return_val = 0;



		$this->flush();







		// Log how the function was called



		$this->func_call = "\$db->query(\"$query\")";







		// Keep track of the last query for debug..



		$this->last_query = $query;







		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES )



			$this->timer_start();







		$this->result = @mysql_query( $query, $this->dbh );



		$this->num_queries++;







		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES )



			$this->queries[] = array( $query, $this->timer_stop(), $this->get_caller() );







		// If there is an error then take note of it..



		if ( $this->last_error = mysql_error( $this->dbh ) ) {



			// Clear insert_id on a subsequent failed insert.



			if ( $this->insert_id && preg_match( '/^\s*(insert|replace)\s/i', $query ) )



				$this->insert_id = 0;







			$this->print_error($query);



			return false;



		}







		if ( preg_match( '/^\s*(create|alter|truncate|drop)\s/i', $query ) ) {



			$return_val = $this->result;



		} elseif ( preg_match( '/^\s*(insert|delete|update|replace)\s/i', $query ) ) {



			$this->rows_affected = mysql_affected_rows( $this->dbh );



			// Take note of the insert_id



			if ( preg_match( '/^\s*(insert|replace)\s/i', $query ) ) {



				$this->insert_id = mysql_insert_id($this->dbh);



			}



			// Return number of rows affected



			$return_val = $this->rows_affected;



		} else {



			$num_rows = 0;



			while ( $row = @mysql_fetch_object( $this->result ) ) {



				$this->last_result[$num_rows] = $row;



				$num_rows++;



			}







			// Log number of rows the query returned



			// and return number of rows selected



			$this->num_rows = $num_rows;



			$return_val     = $num_rows;



		}







		return $return_val;



	}







	/**



	 * Insert a row into a table.



	 *



	 * <code>



	 * wpdb::insert( 'table', array( 'column' => 'foo', 'field' => 'bar' ) )



	 * wpdb::insert( 'table', array( 'column' => 'foo', 'field' => 1337 ), array( '%s', '%d' ) )



	 * </code>



	 *



	 * @since 2.5.0



	 * @see wpdb::prepare()



	 * @see wpdb::$field_types



	 * @see wp_set_wpdb_vars()



	 *



	 * @param string $table table name



	 * @param array $data Data to insert (in column => value pairs). Both $data columns and $data values should be "raw" (neither should be SQL escaped).



	 * @param array|string $format Optional. An array of formats to be mapped to each of the value in $data. If string, that format will be used for all of the values in $data.



	 * 	A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.



	 * @return int|false The number of rows inserted, or false on error.



	 */



	function insert( $table, $data, $format = null ) {



		return $this->_insert_replace_helper( $table, $data, $format, 'INSERT' );



	}







	/**



	 * Replace a row into a table.



	 *



	 * <code>



	 * wpdb::replace( 'table', array( 'column' => 'foo', 'field' => 'bar' ) )



	 * wpdb::replace( 'table', array( 'column' => 'foo', 'field' => 1337 ), array( '%s', '%d' ) )



	 * </code>



	 *



	 * @since 3.0.0



	 * @see wpdb::prepare()



	 * @see wpdb::$field_types



	 * @see wp_set_wpdb_vars()



	 *



	 * @param string $table table name



	 * @param array $data Data to insert (in column => value pairs). Both $data columns and $data values should be "raw" (neither should be SQL escaped).



	 * @param array|string $format Optional. An array of formats to be mapped to each of the value in $data. If string, that format will be used for all of the values in $data.



	 * 	A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.



	 * @return int|false The number of rows affected, or false on error.



	 */



	function replace( $table, $data, $format = null ) {



		return $this->_insert_replace_helper( $table, $data, $format, 'REPLACE' );



	}







	/**



	 * Helper function for insert and replace.



	 *



	 * Runs an insert or replace query based on $type argument.



	 *



	 * @access private



	 * @since 3.0.0



	 * @see wpdb::prepare()



	 * @see wpdb::$field_types



	 * @see wp_set_wpdb_vars()



	 *



	 * @param string $table table name



	 * @param array $data Data to insert (in column => value pairs). Both $data columns and $data values should be "raw" (neither should be SQL escaped).



	 * @param array|string $format Optional. An array of formats to be mapped to each of the value in $data. If string, that format will be used for all of the values in $data.



	 * 	A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.



	 * @param string $type Optional. What type of operation is this? INSERT or REPLACE. Defaults to INSERT.



	 * @return int|false The number of rows affected, or false on error.



	 */



	function _insert_replace_helper( $table, $data, $format = null, $type = 'INSERT' ) {



		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) )



			return false;



		$this->insert_id = 0;



		$formats = $format = (array) $format;



		$fields = array_keys( $data );



		$formatted_fields = array();



		foreach ( $fields as $field ) {



			if ( !empty( $format ) )



				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];



			elseif ( isset( $this->field_types[$field] ) )



				$form = $this->field_types[$field];



			else



				$form = '%s';



			$formatted_fields[] = $form;



		}



		$sql = "{$type} INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";



		return $this->query( $this->prepare( $sql, $data ) );



	}







	/**



	 * Update a row in the table



	 *



	 * <code>



	 * wpdb::update( 'table', array( 'column' => 'foo', 'field' => 'bar' ), array( 'ID' => 1 ) )



	 * wpdb::update( 'table', array( 'column' => 'foo', 'field' => 1337 ), array( 'ID' => 1 ), array( '%s', '%d' ), array( '%d' ) )



	 * </code>



	 *



	 * @since 2.5.0



	 * @see wpdb::prepare()



	 * @see wpdb::$field_types



	 * @see wp_set_wpdb_vars()



	 *



	 * @param string $table table name



	 * @param array $data Data to update (in column => value pairs). Both $data columns and $data values should be "raw" (neither should be SQL escaped).



	 * @param array $where A named array of WHERE clauses (in column => value pairs). Multiple clauses will be joined with ANDs. Both $where columns and $where values should be "raw".



	 * @param array|string $format Optional. An array of formats to be mapped to each of the values in $data. If string, that format will be used for all of the values in $data.



	 * 	A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.



	 * @param array|string $where_format Optional. An array of formats to be mapped to each of the values in $where. If string, that format will be used for all of the items in $where. A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $where will be treated as strings.



	 * @return int|false The number of rows updated, or false on error.



	 */



	function update( $table, $data, $where, $format = null, $where_format = null ) {



		if ( ! is_array( $data ) || ! is_array( $where ) )



			return false;







		$formats = $format = (array) $format;



		$bits = $wheres = array();



		foreach ( (array) array_keys( $data ) as $field ) {



			if ( !empty( $format ) )



				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];



			elseif ( isset($this->field_types[$field]) )



				$form = $this->field_types[$field];



			else



				$form = '%s';



			$bits[] = "`$field` = {$form}";



		}







		$where_formats = $where_format = (array) $where_format;



		foreach ( (array) array_keys( $where ) as $field ) {



			if ( !empty( $where_format ) )



				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];



			elseif ( isset( $this->field_types[$field] ) )



				$form = $this->field_types[$field];



			else



				$form = '%s';



			$wheres[] = "`$field` = {$form}";



		}







		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );



		return $this->query( $this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ) );



	}







	/**



	 * Delete a row in the table



	 *



	 * <code>



	 * wpdb::delete( 'table', array( 'ID' => 1 ) )



	 * wpdb::delete( 'table', array( 'ID' => 1 ), array( '%d' ) )



	 * </code>



	 *



	 * @since 3.4.0



	 * @see wpdb::prepare()



	 * @see wpdb::$field_types



	 * @see wp_set_wpdb_vars()



	 *



	 * @param string $table table name



	 * @param array $where A named array of WHERE clauses (in column => value pairs). Multiple clauses will be joined with ANDs. Both $where columns and $where values should be "raw".



	 * @param array|string $where_format Optional. An array of formats to be mapped to each of the values in $where. If string, that format will be used for all of the items in $where. A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $where will be treated as strings unless otherwise specified in wpdb::$field_types.



	 * @return int|false The number of rows updated, or false on error.



	 */



	function delete( $table, $where, $where_format = null ) {



		if ( ! is_array( $where ) )



			return false;







		$bits = $wheres = array();







		$where_formats = $where_format = (array) $where_format;







		foreach ( array_keys( $where ) as $field ) {



			if ( !empty( $where_format ) ) {



				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];



			} elseif ( isset( $this->field_types[ $field ] ) ) {



				$form = $this->field_types[ $field ];



			} else {



				$form = '%s';



			}







			$wheres[] = "$field = $form";



		}







		$sql = "DELETE FROM $table WHERE " . implode( ' AND ', $wheres );



		return $this->query( $this->prepare( $sql, $where ) );



	}







	/**



	 * Retrieve one row from the database.



	 *



	 * Executes a SQL query and returns the row from the SQL result.



	 *



	 * @since 0.71



	 *



	 * @param string|null $query SQL query.



	 * @param string $output Optional. one of ARRAY_A | ARRAY_N | OBJECT constants. Return an associative array (column => value, ...),



	 * 	a numerically indexed array (0 => value, ...) or an object ( ->column = value ), respectively.



	 * @param int $y Optional. Row to return. Indexed from 0.



	 * @return mixed Database query result in format specified by $output or null on failure



	 */



	function get_row( $query = null, $output = OBJECT, $y = 0 ) {



		$this->func_call = "\$db->get_row(\"$query\",$output,$y)";



		if ( $query )



			$this->query( $query );



		else



			return null;







		if ( !isset( $this->last_result[$y] ) )



			return null;







		if ( $output == OBJECT ) {



			return $this->last_result[$y] ? $this->last_result[$y] : null;



		} elseif ( $output == ARRAY_A ) {



			return $this->last_result[$y] ? get_object_vars( $this->last_result[$y] ) : null;



		} elseif ( $output == ARRAY_N ) {



			return $this->last_result[$y] ? array_values( get_object_vars( $this->last_result[$y] ) ) : null;



		} else {



			$this->print_error( " \$db->get_row(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N" );



		}



	}







	/**



	 * Retrieve one column from the database.



	 *



	 * Executes a SQL query and returns the column from the SQL result.



	 * If the SQL result contains more than one column, this function returns the column specified.



	 * If $query is null, this function returns the specified column from the previous SQL result.



	 *



	 * @since 0.71



	 *



	 * @param string|null $query Optional. SQL query. Defaults to previous query.



	 * @param int $x Optional. Column to return. Indexed from 0.



	 * @return array Database query result. Array indexed from 0 by SQL result row number.



	 */



	function get_col( $query = null , $x = 0 ) {



		if ( $query )



			$this->query( $query );







		$new_array = array();



		// Extract the column values



		for ( $i = 0, $j = count( $this->last_result ); $i < $j; $i++ ) {



			$new_array[$i] = $this->get_var( null, $x, $i );



		}



		return $new_array;



	}







	/**



	 * Retrieve an entire SQL result set from the database (i.e., many rows)



	 *



	 * Executes a SQL query and returns the entire SQL result.



	 *



	 * @since 0.71



	 *



	 * @param string $query SQL query.



	 * @param string $output Optional. Any of ARRAY_A | ARRAY_N | OBJECT | OBJECT_K constants. With one of the first three, return an array of rows indexed from 0 by SQL result row number.



	 * 	Each row is an associative array (column => value, ...), a numerically indexed array (0 => value, ...), or an object. ( ->column = value ), respectively.



	 * 	With OBJECT_K, return an associative array of row objects keyed by the value of each row's first column's value. Duplicate keys are discarded.



	 * @return mixed Database query results



	 */



	function get_results( $query = null, $output = OBJECT ) {



		$this->func_call = "\$db->get_results(\"$query\", $output)";







		if ( $query )



			$this->query( $query );



		else



			return null;







		$new_array = array();



		if ( $output == OBJECT ) {



			// Return an integer-keyed array of row objects



			return $this->last_result;



		} elseif ( $output == OBJECT_K ) {



			// Return an array of row objects with keys from column 1



			// (Duplicates are discarded)



			foreach ( $this->last_result as $row ) {



				$var_by_ref = get_object_vars( $row );



				$key = array_shift( $var_by_ref );



				if ( ! isset( $new_array[ $key ] ) )



					$new_array[ $key ] = $row;



			}



			return $new_array;



		} elseif ( $output == ARRAY_A || $output == ARRAY_N ) {



			// Return an integer-keyed array of...



			if ( $this->last_result ) {



				foreach( (array) $this->last_result as $row ) {



					if ( $output == ARRAY_N ) {



						// ...integer-keyed row arrays



						$new_array[] = array_values( get_object_vars( $row ) );



					} else {



						// ...column name-keyed row arrays



						$new_array[] = get_object_vars( $row );



					}



				}



			}



			return $new_array;



		}



		return null;



	}







	/**



	 * Load the column metadata from the last query.



	 *



	 * @since 3.5.0



	 *



	 * @access protected



	 */



	protected function load_col_info() {



		if ( $this->col_info )



			return;







		for ( $i = 0; $i < @mysql_num_fields( $this->result ); $i++ ) {



			$this->col_info[ $i ] = @mysql_fetch_field( $this->result, $i );



		}



	}







	/**



	 * Retrieve column metadata from the last query.



	 *



	 * @since 0.71



	 *



	 * @param string $info_type Optional. Type one of name, table, def, max_length, not_null, primary_key, multiple_key, unique_key, numeric, blob, type, unsigned, zerofill



	 * @param int $col_offset Optional. 0: col name. 1: which table the col's in. 2: col's max length. 3: if the col is numeric. 4: col's type



	 * @return mixed Column Results



	 */



	function get_col_info( $info_type = 'name', $col_offset = -1 ) {



		$this->load_col_info();







		if ( $this->col_info ) {



			if ( $col_offset == -1 ) {



				$i = 0;



				$new_array = array();



				foreach( (array) $this->col_info as $col ) {



					$new_array[$i] = $col->{$info_type};



					$i++;



				}



				return $new_array;



			} else {



				return $this->col_info[$col_offset]->{$info_type};



			}



		}



	}



}



