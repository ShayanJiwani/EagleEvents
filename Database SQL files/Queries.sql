/* Show all events for a specific user */
SELECT ename AS Name, edescription AS Description,
DATE_FORMAT(e.edate, "%b %e, %Y") AS Day, TIME_FORMAT(e.startTime, "%l:%i %p") AS Starts,
TIME_FORMAT(e.endTime, "%l:%i %p") AS Ends, l.building AS Building, l.room AS Room,c.cname AS Club
FROM attendance a, event e, location l, club c
WHERE a.uid = '$uid'
AND a.event_id = e.event_id
AND l.location_id = e.location_id
AND c.club_id = e.club_id
ORDER BY edate ASC, startTime ASC;

/* Show all clubs a user is a part of */
SELECT cname AS Name, cdescription AS Description, category AS Category
FROM club c, clubMember m
WHERE m.uid = 'uid'
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

INSERT INTO user VALUES(1006, "testerman", "pass");

/* Add a club to a student's list of clubs, i.e., add student info to clubMember table */

INSERT INTO clubMember VALUES('$club_id','$uid', 0);

/* Add an event to a student's list of events, i.e., add student info to event table */

INSERT INTO attendance VALUES('$event_id','$uid');

/* Delete from clubMember table */

DELETE FROM clubMember WHERE club_id = '$club_id' AND uid = '$uid';

/* Delete From event table */

DELETE FROM attendance where event_id = '$event_id' AND uid = '$uid';

/* Get count of each event category for a user */

SELECT COUNT(*) as Count, e.type AS Type
FROM attendance a, event e
WHERE a.uid = 1008
AND a.event_id = e.event_id
GROUP BY e.type
ORDER BY Count;

/* Get count of each club category for a user */
/* Do LIMIT 1 to get max or min, based on orderby DESC or ASC
PICK A RANDOM CLUB NOT IN THE USERS LIST FOR SUGGESTIONS TAB
EACH TIME THEY REFRESH THERE IS A DIFFERENT SUGGESTION */

SELECT COUNT(*) as Count, c.category AS Category
FROM club c
RIGHT OUTER JOIN clubMember m
ON m.club_id = c.club_id
WHERE m.uid = 1009
GROUP BY c.category
ORDER BY Count DESC;


SELECT c.club_id, category, uid FROM clubMember m
LEFT JOIN club c
ON m.club_id = c.club_id
WHERE m.uid = 1009
UNION
SELECT c.club_id, category
FROM club c, clubMember m
WHERE m.uid = 1009
AND m.club_id != c.club_id;

/* get club categories that a person has in their list */
SELECT category
FROM club c, clubMember m
WHERE m.uid = 1009
AND m.club_id = c.club_id
GROUP BY category;

/* This gets all club categories that are not in the user's list of clubs
use this to show people random clubs from this list. For example: our
"discover" clubs will select a random club from each of these categories
*/
SELECT cl.category
FROM club cl
WHERE cl.category NOT IN (SELECT category
               FROM club c, clubMember m
               WHERE m.uid = 1009
               AND m.club_id = c.club_id
               GROUP BY category)
GROUP BY cl.category;

/* Get all students interested in this event */

SELECT COUNT(*)
FROM attendance
WHERE event_id = '$event_id';


SELECT ename AS Name, edescription AS Description,
      DATE_FORMAT(e.edate, '%b %e, %Y') AS Day, TIME_FORMAT(e.startTime, '%l:%i %p') AS Starts,
      TIME_FORMAT(e.endTime, '%l:%i %p') AS Ends, l.building AS Building, e.room AS Room,c.cname AS Club,
      longitude AS Longitude, latitude AS Latitude, (SELECT COUNT(*)
                                                     FROM attendance
                                                     WHERE event_id = e.event_id) AS count
      FROM attendance a, event e, location l, club c
      WHERE a.uid = 1000 AND a.event_id = e.event_id AND l.location_id = e.location_id
      AND c.club_id = e.club_id ORDER BY edate ASC, startTime ASC;
