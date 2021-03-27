<?php

// Google Calender Link Create Function 

function getGoogleCalendarLink()
{
	global $zoom_webinars;

	// Check Start time for repeat webinar 

	if (!empty($zoom_webinars->type) && $zoom_webinars->type === 9) {
		if (!empty($zoom_webinars->occurrences)) {
			$now = new DateTime('now -1 hour', new DateTimeZone($zoom_webinars->timezone));
			$closest_occurence = false;
			$duration = false;
			if (!empty($zoom_webinars->type) && $zoom_webinars->type === 9 && !empty($zoom_webinars->occurrences)) {
				foreach ($zoom_webinars->occurrences as $occurrence) {
					if ($occurrence->status === "available") {
						$start_date = new DateTime($occurrence->start_time, new DateTimeZone($zoom_webinars->timezone));
						if ($start_date >= $now) {
							$closest_occurence = $occurrence->start_time;
							$duration = $occurrence->duration;
							break;
						}
					}
				}
			}
		}
	} else {

		$closest_occurence = $zoom_webinars->start_time;
		$duration = $zoom_webinars->duration;
	}

	// Get your start & end date
	// The start and end date below are Carbon objects
	$startDate = $closest_occurence;
	$endDate   = $closest_occurence;

	// Set your timezone if it is set
	if ($zoom_webinars->timezone) {
		$startDate = new DateTime($startDate);
		$startDate->setTimezone(new DateTimeZone($zoom_webinars->timezone));
	}
	// end time create 
	if ($zoom_webinars->timezone) {
		$minutes_to_add = $duration;
		$endDate = new DateTime($endDate);
		$endDate->setTimezone(new DateTimeZone($zoom_webinars->timezone));
		$endDate->add(new DateInterval('PT' . $minutes_to_add . 'M'));
	}
	// Create the full calendar link
	$queryString = sprintf(
		'action=%s&text=%s&details=%s%sWebinar+link:+%s&location=%s&dates=%s/%s&ctz=%s',
		// action
		'TEMPLATE',
		// text
		urlencode($zoom_webinars->topic),
		// details
		urlencode(strip_tags($zoom_webinars->agenda)),
		//break
		'%0A',
		urlencode(strip_tags($zoom_webinars->join_url)),
		// location
		'Online',
		// dates
		urlencode($startDate->format("Ymd\THis")),
		urlencode($endDate->format("Ymd\THis")),
		// ctz
		urlencode($zoom_webinars->timezone)
	);

	return 'https://www.google.com/calendar/event?' . $queryString;
}



?>
