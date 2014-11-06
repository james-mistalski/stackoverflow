<?php
/**
 * mySQl Enabled User
 *
 * This is a mySQL enabled container for User authentication at Stackoverflow.com. It can be easily extended to include more fields as necessary.
 *
 * @author James Mistlaski <james.mistalski@gmail.com
 * @see Profile
 **/
class User {
	/**
	 * user id for the User; this is the primary key
	 **/
	private $userId;
	/**
	 * email for the User; this is a unique field
	 **/
	private $email;
	/**
	 * SHA512 PBKDF2 hash of the password
	 */
	private $passwordHash;
	/**
	 * salt used in the PBKDF2 hash
	 */
	private $salt;
	/**
	 * authentication token used in new accounts and password resets
	 */
	private $authToken;

	/**
	 * constructor for User
	 *
	 * @param mixed $newUserId user id (or null if new object)
	 * @param string $newEmail email
	 * @param string $newPasswordHash PBKDF2 hash of the password
	 * @param string $newSalt salt used in the PBKDF2 hash
	 * @mixed $newAuthToken authentication token used in new accounts and password resets (or null if active User)
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newUserId, $newEmail, $newPasswordHash, $newSalt, $newAuthToken) {
		try {
			$this->setUserId($newUserId);
			$this->setEmail($newEmail);
			$this->setPasswordHash($newPasswordHash);
			$this->setSalt($newSalt);
			$this->setAuthToken($newAuthToken);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct User", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct User", 0, $range));

		}
	}

	/**
	 * sets the value of user id
	 *
	 * @return mixed user id (or null if new object)
	 */
	public function  getUserId() {
		return($this->userId);
	}

	/**
	 * sets the value of user id
	 *
	 * @param mixed $newUserId user id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if user id isn't positive
	 */
	public function setUserId($newUserId) {
		// zeroth, set allow the user id to be null if a new object
		if($newUserId === null) {
			$this->userId = null;
			return;
		}

		// first, ensure the user id is an integer
		if(filter_var($newUserId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("user id $newUserId is not numeric"));
		}

		// second, convert the user id to an integer and enforce it's positive
		$newUserId = intval($newUserId);
		if($newUserId <= 0) {
			throw(new RangeException("user id $newUserId is not positive"));
		}

		// finally, take the user id out of quarantine and assign it
		$this->userId = $newUserId;
	}

	/**
	 * gets the value of email
	 *
	 * @return string value of email
	 */
	public function getEmail() {
		return($this->email);
	}

	/**
	 * sets the value of email
	 *
	 * @param string $newEmail email
	 * @throws UnexpectedValueException if the input doesn't appear to be an Email
	 */
	public function setEmail($newEmail) {
		// sanitize the Email as a likely Email
		$newEmail = trim($newEmail);
		if(($newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL)) == false) {
			throw(new UnexpectedValueException("email $newEmail does not appear to be an email address"));
		}

		// then just take email out of quarantine
		$this->email = $newEmail;
	}

	/**
	 * gets the value of password
	 *
	 * @return string value of password
	 */
	public function getPasswordHash() {
		return($this->passwordHash);
	}

	/**
	 * sets the value of passwordHash
	 *
	 * @param string $newPasswordHash SHA512 PDKDF2 hash of the password
	 * @throws RangeException when input isn't a valid SHA512 PBKDF2 hash
	*/
	public function setPasswordHash($newPasswordHash) {
		// verify the passwordHash is 128 hex characters
		$newPasswordHash	= trim($newPasswordHash);
		$newPasswordHash	= strtolower($newPasswordHash);
		$filterOptions	= array("options" => array("regexp" => "/^[\da-f]{128}$/"));
		if(filter_var($newPasswordHash, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("passwordHash is not a valid SHA512 PBKDF2 hash"));
		}

		// finally, take the password out of quarantine
		$this->passwordHash = $newPasswordHash;
	}

	/**
	 * sets the value of salt
	 *
	 * @param string $newSalt salt (64 hexadecimal bytes)
	 * @throws RangeException when input isn't 64 hexadecimal bytes
	 */
	public function setSalt($newSalt) {
		// verify the salt is 64 hex characters
		$newSalt	= trim($newSalt);
		$newSalt	= strtolower($newSalt);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{64}$/"));
		if(filter_var($newSalt, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("salt is not 64 hexadecimal bytes"));
		}

		// finally, take the salt out of quarantine
		$this->salt = $newSalt;
	}

	/**
	 * gets the value of authentication token
	 *
	 * @param mixed $newAuthenticationToken authentication token (32 hexadecimal bytes) (or null if active User)
	 * @throws RangeException when input isn't 32 hexadecimal bytes
	 */
	public function setAuthToken($newAuthToken) {
		// zeroth, set allow the authentication token to be null if an active object
		if($newAuthToken === null) {
			$this->authToken = null;
			return;
		}

		// verify the authentication token is 32 hex characters
		$newAuthToken	= trim($newAuthToken);
		$newAuthToken	= strtolower($newAuthToken);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{32}$/"));
		if(filter_var($newAuthToken, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("authToken is not 32 hexadecimal bytes"));
		}

		// finally, take the authentication token out of quarantine
		$this->authToken = $newAuthToken;
	}

	/**
	 * insert this User to mySQL
	 *
	 * @param resource $mysqli pointer to ySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("not a new user"));
		}

		// enforce the userId is null (i.e., don't insert a user that already exists)
		if($this->userId !== null) {
			throw(new mysqli_sql_exception("not a new user"));
		}

		// create query template
		$query		= "INSERT INTO user(email, passwordHash, salt, authToken) VALUES(?, ?, ?, ?)";
		$statement	= $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssss", $this->email,	$this->passwordHash,
																 $this->salt,	$this->authToken);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null userId with what mySQL just gave us
		$this->userId = $mysqli->insert_id;
	}

	/**
	 * deletes this User from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the userId is not null (.e., don't delete a user that hasn't been inserted)
		if($this->userId === null) {
			throw(new mysqli_sql_exception("Unable to delete a user that does not exist"));
		}

		// crete query template
		$query		= "DELETE FROM user where userId = ?";
		$statement	= $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->userId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false){
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * updates this User in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the userId is not null (i.e., don't update a user that hasn't been inserted)
		if($this->userId === null) {
			throw(new mysqli_sql_exception("Unable to update a user that does not exist"));
		}

		// create the query template
		$query		= "UPDATE user SET email = ?, passwordHash = ?, salt = ?, authToken = ? WHERE userId = ?";
		$statement	= $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssssi",	$this->email,	$this->passwordHash,
																	$this->salt,	$this->authToken,
																	$this->userId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * gets the User by Email
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $email email to search fo
	 * @return mixed User found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public static function getUserByEmail(&$mysqli, $email) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the Email before searching
		$email = trim($email);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		//create query template
		$query		= "SELECT userId, email, passwordHash, salt, authToken FROM user WHERE email = ?";
		$statement	= $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the statement
		$wasClean = $statement->bind_param("s", $email);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get results from the SELECT query *pound fists*
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a unique field, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a User object normally
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc returns a row as an associative array

		// convert the associative array to a User
		if($row !== null) {
			try {
				$user = new User($row["userId"], $row["email"], $row["passwordHash"], $row["salt"], $row["authToken"]);
			}
			catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to User", 0, $exception));
			}

			// if we got here, the User is good - return it
			return($user);
		} else {
			// 404 User not found - return null instead
			return(null);
		}
	}
}
?>