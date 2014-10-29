DROP TABLE IF EXISTS privilege;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS users;

CREATE TABLE  user (
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	email VARCHAR(64) NOT NULL,
	passwordHash CHAR(128) NOT NULL,
	salt CHAR(64) NOT NULL,
	authToken CHAR(32),
	PRIMARY KEY(userId),
	UNIQUE(email)
);

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userId INT UNSIGNED NOT NULL,
	firstName VARCHAR(32) NOT NULL,
	middleName VARCHAR(32),
	lastName VARCHAR(32) NOT NULL,
	repScore INT UNSIGNED NOT NULL,
	PRIMARY KEY(profileId),
	UNIQUE(userId),
	FOREIGN KEY(userId) REFERENCES user(userId)
);

CREATE TABLE question (
	questionId VARCHAR(32) NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	questionTag VARCHAR(16),
	questionTitle VARCHAR(80),
	questionScore INT UNSIGNED,
	scoreDateTime DATETIME,
	PRIMARY KEY(questionId),
	INDEX(profileId),
	INDEX(questionId),
	INDEX(questionTag),
	INDEX(questionTitle),
	INDEX(questionTag, questionTitle),
	FOREIGN KEY(profileId) REFERENCES profile(profileId)
);

CREATE TABLE privilege (
	privilegeId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	privilegeName VARCHAR(32) NOT NULL,
	privilegeCategory CHAR(13) NOT NULL,
	privilegeDesc MEDIUMTEXT,
	scoreUnlock INT NOT NULL,
	PRIMARY KEY(privilegeId),
	INDEX(profileId),
	INDEX(privilegeName),
	INDEX(privilegeCategory),
	INDEX(privilegeName, privilegeCategory),
	FOREIGN KEY(profileId) REFERENCES profile(profileId)
);