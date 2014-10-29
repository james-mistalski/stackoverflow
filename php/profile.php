<?php
/**
 * mySWL Enabled User
 *
 * This is a mySQL enabled container for Profile authentication at Stackoverflow.com. It can easily be extended to include more fields as necessary.
 *
 * @author James Mistalski <james.mistalski@gmail.com
 * @see my profile
 */

class Profile
{
	/**
	 * profile id for the Profile; this is the primary key
	 **/
	private $profileId;
	/**
	 * user id for the Profile; this is a foreign key
	 **/
	private $userId;
	/**
	 * first name for the Profile;
	 **/
	private $firstName;
	/**
	 * middle name for the Profile;
	 **/
	private $middleName;
	/**
	 * last name for the Profile;
	 **/
	private $lastName;
	/**
	 * rep score for the Profile;
	 **/
	private $repScore;

	/**
	 * constructor for Profile
	 *
	 * @param mixed  $newProfileId  profile id (or null if new object)
	 * @param mixed  $newUserId     user id
	 * @param string $newFirstName  first name
	 * @param string $newMiddleName middle name
	 * @param string $newLastName   last name
	 * @param string $newRepScore   rep score
	 **/
	public function __construct($newProfileId, $newUserId, $newFirstName, $newMiddleName, $newLastName, $newRepScore)
	{
		try {
			$this->setProfileId($newProfileId);
			$this->setUserId($newUserId);
			$this->setFirstName($newFirstName);
			$this->setMiddleName($newMiddleName);
			$this->setLastName($newLastName);
			$this->setRepScore($newRepScore);
		} catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Profile", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct Profile", 0, $range));
		}
	}

	/**
	 * gets the value of profile id
	 *
	 * @return mixed profile id (or null if new object)
	 **/
	public function getProfileId()
	{
		return ($this->profileId);
	}

	/**
	 * sets the value of profile id
	 *
	 * @param mixed $newProfileId profile id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 **/
	public function setProfileId($newProfileId)
	{
		// zeroth, set allow the profile id to be null if a new object
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// first, ensure the profile id is an integer
		if(filter_var($newProfileId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("profile id $newProfileId is not numeric"));
		}

		// second, convert the profile id to an integer and enforce it's positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("profile id $newProfileId is not positive"));
		}

		// finally, take the profile id out of quarantine and assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * gets the value of user id
	 *
	 * @return mixed user id
	 **/
	public function getUserId()
	{
		return ($this->userId);
	}

	/**
	 * sets the value of user id
	 *
	 * @param mixed $newUserId user id
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if user id isn't positive
	 **/
	public function setUserId($newUserId)
	{
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
	 * gets the value of first name
	 *
	 * @ @return string value of first name
	 **/
	public function getFirstName()
	{
		return ($this->firstName);
	}

	/**
	 *sets the value of first name
	 *
	 * @param string $newFirstName first name
	 * @throws UnexpectedValueException if the input doesn't appear to be a First Name
	 **/
	public function setFirstName($newFirstName)
	{
		// sanitize the First Name as a likely First Name
		$newFirstName = trim($newFirstName);
		if(($newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("firstName $newFirstName does not appear to be a first name"));
		}

		//then just take first name out of quarantine
		$this->firstName = $newFirstName;
	}

	/**
	 * gets the value of middle name
	 *
	 * @ @return string value of middle name
	 **/
	public function getMiddleName()
	{
		return ($this->middleName);
	}

	/**
	 *sets the value of middle name
	 *
	 * @param string $newMiddleName middle name
	 * @throws UnexpectedValueException if the input doesn't appear to be a Middle Name
	 **/
	public function setMiddleName($newMiddleName)
	{
		// sanitize the Middle Name as a likely Middle Name
		$newMiddleName = trim($newMiddleName);
		if(($newMiddleName = filter_var($newMiddleName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("middleName $newMiddleName does not appear to be a middle name"));
		}

		//then just take middle name out of quarantine
		$this->middleName = $newMiddleName;
	}

	/**
	 * gets the value of last name
	 *
	 * @ @return string value of last name
	 **/
	public function getLastName()
	{
		return ($this->lastName);
	}

	/**
	 *sets the value of last name
	 *
	 * @param string $newLastName last name
	 * @throws UnexpectedValueException if the input doesn't appear to be a Last Name
	 **/
	public function setLastName($newLastName)
	{
		// sanitize the Last Name as a likely Last Name
		$newLastName = trim($newLastName);
		if(($newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("lastName $newLastName does not appear to be a last name"));
		}

		//then just take last name out of quarantine
		$this->lastName = $newLastName;
	}

	/**
	 * gets the value of rep score
	 *
	 * @return rep score
	 **/
	public function getRepScore()
	{
		return ($this->repScore);
	}

	/**
	 *sets the value of rep score
	 *
	 * @param $newRepScore rep score (or 1 if new object)
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if user id isn't positive
	 **/
	public function setRepScore($newRepScore)
	{

		// first, ensure the rep score is an integer
		if(filter_var($newRepScore, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("rep score $newRepScore is not numeric"));
		}

		// second, convert the rep score to an integer and enforce it's positive
		$newRepScore = intval($newRepScore);
		if($newRepScore <= 0) {
			throw(new RangeException("rep score $newRepScore is not positive"));
		}

		// finally, take the rep score out of quarantine and assign it
		$this->repScore = $newRepScore;
	}


	/**
	 *  inserts this Profile to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/

	public function insert(&$mysqli)
	{

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new mysqli_sql_exception("not a new profile"));
		}

		// create query template
		$query = "INSERT INTO profile(userId, firstName, middleName, lastName, repScore) VALUES(?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if(statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("isssi", $this->userId, $this->firstName,
			$this->middleName, $this->lastName,
			$this->repScore);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null profileId with what mySQL just gave me
		$this->profileId = $mysqli->insert_id;
	}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is not null (i.e., don't delete a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// create query template
		$query = "DELETE FROM profile WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli)
	{

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to update a profile that does not exist"));
		}

		// create query template
		$query = "UPDATE profile SET userId = ?, firstName = ?, middleName = ?, lastName = ?, repScore = ? WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("isssii", $this->userId, $this->firstName, $this->middleName,
			$this->lastName, $this->repScore, $this->profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * gets the Profile by ProfileId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $profileId profileId to search for
	 * @return mixed Profile found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getProfileByProfileId(&$mysqli, $profileId) {

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class(mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the Profile before searching
		if(($profileId = filter_var($profileId, FILTER_SANITIZE_NUMBER_INT)) == false) {
			throw(new mysqli_sql_exception("Profile does not appear to be an integer"));
		}

		// create query template
		$query = "SELECT profileId, userId, firstName, middleName, lastName, repScore FROM profile WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		//get result from the SELECT query *pounds fists*
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a primary key, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a Profile object normally
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array

		// convert the associative array to a Profile
		if($row !== null) {
			try {
				$profileId = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["middleName"], $row["lastName"], $row["repScore"]);
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Profile", 0, $exception));
			}

			// if we got here, the Profile is good - return it
			return ($profileId);
		} else {
			// 404 Profile not found - return null instead
			return (null);
		}
	}

	/** gets the Profile by First Name
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $firstName firstName to search fo
	 * @return mixed Profile found or null if not found
	 * @throws mysqli_sql)exception when mySQL related errors occur
	 **/
public static function  getProfileByfirstName(&$mysqli, $firstName) {
	// handle degenerate cases
	if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
		throw(new mysqli_sql_exception("input is not a mysqli object"));
	}

	//sanitize the First Name before searching
	$firstName = trim($firstName);
	if(($firstName = filter_var($firstName, FILTER_SANITIZE_STRING)) == false) {
		throw(new UnexpectedValueException("firstName $firstName does not appear to be a first name"));
	}

	// create query template
	$query 		= "SELECT profileId, userId, firstName, middleName, lastName, repScore FROM profile WHERE firstName = ?";
	$statement	= $mysqli->prepare($query);
	if($statement === false) {
		throw(new mysqli_sql_exception("Unable to prepare statement"));
	}

	// bind the firstName to the place holder in the template
	$wasClean = $statement->bind_param("s", $firstName);
	if($wasClean === false) {
		throw(new mysqli_sql_exception("Unable to bind parameters"));
	}

	// execute the statement
	if($statement->execute() === false) {
		throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
	}

	// get result from the SELECT query
	$result = $statement>get_result();
	if($result === false) {
		throw(new mysqli_sql_exception("Unable to get result set"));
	}

	// since this is not a unique field, this can return 0, 1, or many results. So...
	// 1) if there's a result, we can make it into a Profile object normally
	// 2) if there's more than 1 result, we can make all into Profile objects
	// 3) if there's no result, we can just return null
	while(($row = $result->fetch_assoc()) !== null); // fetch_assoc() returns a row as an associative array

	// convert the associative array to a Profile
	if($row !== null) {
		try {
			$profileId = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["middleName"], $row["lastName"], $row["repScore"]);
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new mysqli_sql_exception("Unable to convert row to Profile", 0, $exception));
		}

		// if we got here, the Profile is good - return it
		return ($profileId);
	} else {
		// 404 Profile not found - return null instead
		return (null);
	}

	}
}
?>