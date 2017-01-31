<?php

/**
 * Example of retrieving course details from Bridgwater & Taunton College's internal course management system.
 * Using a simple web service which accepts a course code and when valid, returns the course details. Details
 * include information such as the Offering ID, Level, Location, Start Date, Fees, Availability, etc. This
 * example uses cURL to pass the course code to the web service. It displays the entire response in a table,
 * however on a real project a subset of the information would likely be required and the output formatted
 * for the specific display. An example of how we use this on the main Bridgwater & Taunton College website
 * can be seen here http://www.bridgwater.ac.uk/course.php?sector=2&subject=250&course=1514. The information
 * could also be stored after retrieval if necessary. 
 */

/**
 * Retrieve course details
 * @param string $code
 * @return array $events
 */
function get_course_details($code) {
	$curl = curl_init();
	$options = [
		CURLOPT_URL => "http://www.bridgwater.ac.uk/course-details/?code=" . $code,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HEADER => 0
	];
	curl_setopt_array($curl, $options);
	$response = curl_exec($curl);
	return json_decode($response, true);
}

/**
 * Format the response for output
 * @param array $details
 * @return string
 */
function format_response($details) {
	$o = '';
	if (isset($details["error"])) {
		$o .= '<div class="alert alert-danger" role="alert">' . $details["error"] . '</div>';
	} else {
		$o .= '<div class="alert alert-success" role="alert">' . count($details) . ' Course Code(s) found</div>';
		foreach ($details as $code => $detail) {
			$o .= '<table class="table table-bordered"><caption>Retrieved details for: ' . $code . '</caption><tbody>';
			foreach ($detail as $key => $value) {
				$o .= '<tr><th scope="row">' . $key . '</th>';
				$o .= '<td>' . $value . '</td>';
			}
			$o .= '</tbody></table>';
		}
	}
	return $o;
}

$output = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$code = trim(filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING));
	if (!empty($code)) {
		$courses = get_course_details($code);
		$output = format_response($courses);
	} else {
		$output = '<div class="alert alert-danger" role="alert">No code entered</div>';
	}
}

?>
<!DOCTYPE html>
<html lang="en-gb">
<head>
	<title>Retrieve course details via BTC web service</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-10">
				<h1>Course Details retrieval example</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10">
				<form method="post" class="form-inline" style="margin-bottom: 20px;">
					<div class="form-group">
						<label for="code">Course Code</label>
						<input type="text" class="form-control" id="code" name="code" value="<?= isset($code) ? $code : ''; ?>">
					</div>
					<button type="submit" class="btn btn-default">Get Details</button>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10">
				<?php echo $output; ?>
			</div>
		</div>
	</div>
</body>
</html>