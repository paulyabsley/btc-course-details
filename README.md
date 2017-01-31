#Course Details Retrieval via BTC Web Service

Example of retrieving course details from Bridgwater & Taunton College's internal course management system. Using a simple web service which accepts a course code and when valid, returns the course details. Details include information such as the Offering ID, Level, Location, Start Date, Fees, Availability, etc.

The web service is located at http://www.bridgwater.ac.uk/course-details/. Course codes are passed using the query string parameter ‘code’ e.g. ?code= TAT033B/PM1. The response is returned as JSON.

This example uses cURL to pass the course code to the web service. It displays the entire response in a table, however on a real project a subset of the information would likely be required and the output tailored for the specific display. The information could also be stored following retrieval.

Examples of how this is used on the main Bridgwater & Taunton College website can be seen at the bottom of most Adult Course pages, such as http://www.bridgwater.ac.uk/course.php?sector=2&subject=250&course=1514#course-details. 
