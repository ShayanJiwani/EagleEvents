/* Show all events for a specific user */
SELECT ename AS Name, edescription AS Description,
DATE_FORMAT(e.edate, "%b %e, %Y") AS Day, TIME_FORMAT(e.startTime, "%l:%i %p") AS Starts,
TIME_FORMAT(e.endTime, "%l:%i %p") AS Ends, l.building AS Building, l.room AS Room,c.cname AS Club
FROM attendance a, event e, location l, club c
WHERE a.uid = 1002
AND a.event_id = e.event_id
AND l.location_id = e.location_id
AND c.club_id = e.club_id
ORDER BY edate ASC, startTime ASC;

/* Show all clubs a user is a part of */
SELECT cname AS Name, cdescription AS Description, category AS Category
FROM club c, clubMember m
WHERE m.uid = 1002
AND m.club_id = c.club_id
ORDER BY cname ASC;

/* Show all events at Emory */
SELECT ename AS Name, edescription AS Description,
DATE_FORMAT(e.edate, "%b %e, %Y") AS Day, TIME_FORMAT(e.startTime, "%l:%i %p") AS Starts,
TIME_FORMAT(e.endTime, "%l:%i %p") AS Ends, l.building AS Building, l.room AS Room,c.cname AS Club
FROM event e, location l, club c
WHERE l.location_id = e.location_id
AND c.club_id = e.club_id
ORDER BY edate ASC, startTime ASC;

/* Show all clubs at Emory */
SELECT cname AS Name, cdescription AS Description, category AS Category
FROM club
ORDER BY cname ASC;

/* Insert new user information into database */
SELECT MAX('$uid') FROM user;
$newUserId = maxOfUserID + 1
INSERT INTO user VALUES('$newUserId', '$username', '$password');
INSERT INTO student VALUES('$fname', '$lname', '$year', '$email', '$newUserId', '$picture');