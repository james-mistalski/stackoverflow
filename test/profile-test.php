<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/profile.php");

// the ProfileTest is a container for all our tests
class ProfileTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli	= null;
	// variable to hold the test database row
	private $profile 	= null;

	// a few "global" variables for creating test data
	private $USER_ID		= 1;
	private $FIRST_NAME	= "Jimmy";
	private $MIDDLE_NAME	= "Crack";
	private $LAST_NAME	= "Corn";
	private $REP_SCORE	= 55;

	// setUp() is a method that is run before each test
	// connect to mySQL
	public function setUp() {
		mysqli_report(MYSQLI_REPORT_STRICT);
		$this->mysqli - new mysqli("localhost", "store_james", "deepdive", "store_james");
	}

	//rearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		// delete the user if we can
		if($this->profile !== null) {
			$this->profile->delete($this->mysqli);
			$this->user = null;
		}

		// disconnect from mySQL
		if($this>mysqli != null) {
			$this->mysqli->close();
		}
	}

	//test creating a new Profile and inserting it to mySQL
	public function testInsertNewProfile() {
		// fist, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->USER_ID, $this->FIRST_NAME, $this->MIDDLE_NAME, $this->LAST_NAME, $this->REP_SCORE);

		// third, insert the user to mySQL
		$this->profile->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(),			$this->USER_ID);
		$this->assertIdentical($this->profile->getFirstName(),		$this->FIRST_NAME);
		$this->assertIdentical($this->profile->getMiddleName(),		$this->MIDDLE_NAME);
		$this->assertIdentical($this->profile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($this->profile->getRepScore(),			$this->REP_SCORE);
	}

	// test updating a Profile in mySQL
	public function testUpdateProfile() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->USER_ID, $this->FIRST_NAME, $this->MIDDLE_NAME, $this->LAST_NAME, $this->REP_SCORE);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, update the profile and post the changes to mySQL
		$newLastName = "Mahnuhtz";
		$this->profile->setLastName($newLastName);
		$this->profile->update($this->mysqli);

		//finally, compare the fields
		$this->asserNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(),			$this->USER_ID);
		$this->assertIdentical($this->profile->getFirstName(),		$this->FIRST_NAME);
		$this->assertIdentical($this->profile->getMiddleName(),		$this->MIDDLE_NAME);
		$this->assertIdentical($this->profile->getLastName(),			$newLastName);
	}

	//test deleting a Profile
	public function testDeleteProfile() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySql
		$this->profile = new Profile(null, $this->USER_ID, $this->FIRST_NAME, $this->MIDDLE_NAME, $this->LAST_NAME, $this->REP_SCORE);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, verify the Profile was inserted
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() >0);

		//fifth, delete the profile
		$this->profile->delete($this->mysqli);
		$this->profile = null;

		// finally, try to get the profile and assert we didn't get a thing
		$staticProfile = Profile::getProfileByProfileId($this->mysqli, $this->PROFILE_ID);
		$this->assertNull($staticProfile);
	}

	// test grabbing a Profile from mySQL
	public function testGetProfileByProfileId() {
		// first, verify mySQL connected O
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->USER_ID, $this->FIRST_NAME, $this->MIDDLE_NAME, $this->LAST_NAME, $this->REP_SCORE);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, get the user using the static method
		$staticProfile = Profile::getProfileByProfileId($this->mysqli, $this->PROFILE_ID);

		// finally, compare the fields
		$this->assertNotNull($staticProfile->getProfileId());
		$this->assertTrue($staticProfile->getProfileId() > 0);
		$this->assertIdentical($staticProfile->getProfileId(),		$this->profile->getProfileId());
		$this->assertIdentical($staticProfile->getUserId(),			$this->USER_ID);
		$this->assertIdentical($staticProfile->getFirstName(),		$this->FIRST_NAME);
		$this->assertIdentical($staticProfile->getMiddleName(),		$this->MIDDLE_NAME);
		$this->assertIdentical($staticProfile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($staticProfile->getRepScore(),			$this->REP_SCORE);
	}
}

?>