
/* Create the EagleEvents schema */
CREATE DATABASE eagleEvents;

/* Specify the database to use */
USE eagleEvents;

/* Create the user table */
CREATE TABLE user
(
  uid INT(5),
  username VARCHAR(16) NOT NULL UNIQUE,
  password VARCHAR(16) NOT NULL,
  CONSTRAINT userPK PRIMARY KEY(uid)
);

/* Create the club table */
CREATE TABLE club
(
  cname VARCHAR(80) NOT NULL,
  logo VARCHAR(1000),
  cdescription VARCHAR(1000) NOT NULL,
  club_id INT(4),
  category VARCHAR(30) NOT NULL,
  CONSTRAINT clubPK PRIMARY KEY (club_id)
);

/* Create the location table */
CREATE TABLE location
(
  building VARCHAR(30) NOT NULL UNIQUE,
  campus VARCHAR(16) NOT NULL,
  latitude DECIMAL(9,6) NOT NULL,
  longitude DECIMAL(9,6) NOT NULL,
  radius DECIMAL(9,6) DEFAULT 0.00012,
  location_id INT(4),
  CONSTRAINT locationPK PRIMARY KEY (location_id)
);

/* Create the event table */
CREATE TABLE event
(
  ename VARCHAR(50) NOT NULL,
  edescription VARCHAR(100),
  edate date NOT NULL,
  startTime time NOT NULL,
  endTime time NOT NULL,
  location_id INT(4),
  room VARCHAR(30),
  event_id INT(4),
  type VARCHAR(25) NOT NULL,
  open BOOLEAN NOT NULL,
  uid INT(5),
  club_id INT(4),
  CONSTRAINT eventFK PRIMARY KEY(event_id),
  CONSTRAINT locationFK FOREIGN KEY(location_id) REFERENCES location(location_id),
  CONSTRAINT userFK FOREIGN KEY(uid) REFERENCES user(uid),
  CONSTRAINT clubFK FOREIGN KEY(club_id) REFERENCES club(club_id)
);

/*Create the student table*/
CREATE TABLE student
(
  fname VARCHAR(30) NOT NULL,
  lname VARCHAR(30) NOT NULL,
  year VARCHAR(16) NOT NULL,
  email VARCHAR(30) NOT NULL,
  uid INT(5),
  picture VARCHAR(1000) NOT NULL,
  CONSTRAINT userStudentFK FOREIGN KEY(uid) REFERENCES user(uid)
);

/* Create the attendance table */
CREATE TABLE attendance
(
  event_id INT(4),
  uid INT(5),
  CONSTRAINT clubEventsPK PRIMARY KEY (event_id, uid),
  CONSTRAINT eventAttendFK FOREIGN KEY(event_id) REFERENCES event(event_id),
  CONSTRAINT userAttendFK FOREIGN KEY(uid) REFERENCES user(uid)
);

/* Create the clubMember table */
CREATE TABLE clubMember
(
  club_id INT(4),
  uid INT(5),
  owner BOOLEAN,
  CONSTRAINT clubMemberPK PRIMARY KEY (club_id, uid),
  CONSTRAINT clubIDFK FOREIGN KEY(club_id) REFERENCES club(club_id),
  CONSTRAINT userIdFK FOREIGN KEY(uid) REFERENCES user(uid)
);

/* Create Following/Followers table */
CREATE TABLE following
(
  mainUser INT(5),
  followingUser INT(5),
  CONSTRAINT followingRelationshipPK PRIMARY KEY (mainUser, followingUser),
  CONSTRAINT mainUserFK FOREIGN KEY(mainUser) REFERENCES user(uid),
  CONSTRAINT followingUserFK FOREIGN KEY(followingUser) REFERENCES user(uid)
);
