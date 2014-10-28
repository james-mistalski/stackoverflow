<?php
/**
 * Created by PhpStorm.
 * User: Kimo
 * Date: 10/28/2014
 * Time: 10:50 AM
 */
class Profile
{
	/**
	 * profile id for the Profile; this is the primary key
	 **$new$/
	 * private $profileId;
	 * /**
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
			throw(new RangeException("Unable to construct User", 0, $range));
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
		return ($this->UserId);
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
	public function getRepId()
	{
		return ($this->repScore);
	}

	/**
	 *sets the value of rep id
	 *
	 * @param @newRepID rep id (or 1 if new object)
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if user id isn't positive
	 **/
	public function setRepID($newRepId) {
		//zeroth, set allow the user id to be 1 if a new object
		if($newRepId === null) {
			$this->repId = 1;
			return;
		}

		// first, ensure the rep id is an integer
		if(filter_var($newRepId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("re id $newRepId is not numeric"));
		}

		// second, convert the rep id to an integer and enforce it's positive
		$newRepId = intval($newRepId);
		if($newRepId <= 0) {
			throw(new RangeException("rep id $newRepId is not positive"));
		}

		// finally, take the rep id out of quarantine and assign it
		$this->repId = $newRepId;
	}


}