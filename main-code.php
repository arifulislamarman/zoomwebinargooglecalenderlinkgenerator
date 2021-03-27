<?php  
public function getGoogleCalendarLink()
    {
        // Get your start & end date
        // The start and end date below are Carbon objects
        $startDate = $this->start_date;
        $endDate   = $this->end_date;
 
        // Set your timezone if it is set
        if ($this->timezone) {
            $startDate = $startDate->setTimezone($this->timezone);
            $endDate = $endDate->setTimezone($this->timezone);
        }
 
        // Create the full calendar link
        $queryString = sprintf(
            'action=%s&text=%s&details=%s&location=%s&dates=%s/%s&ctz=%s',
            // action
            'TEMPLATE',
            // text
            urlencode($this->title),
            // details
            urlencode(strip_tags($this->description)),
            // location
            urlencode($this->address),
            // dates
            urlencode($startDate->format("Ymd\THis")),
            urlencode($endDate->format("Ymd\THis")),
            // ctz
            urlencode($startDate->timezoneName)
        );
 
        return 'https://www.google.com/calendar/event?' . $queryString;
    }
    
    
?>
