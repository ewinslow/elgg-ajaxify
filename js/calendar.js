/**
 * Notable interface.  Defines calendaring functions
 */
elgg.Notable = {
	/**
	 * @param {number} start The Unix starting timestamp in seconds
	 * @param {number} duration The duration of the event in seconds
	 * 
	 */
	setCalendarStartTimeAndDuration: function(start, duration) {
		this.calendar_start = start;
		this.calendar_end = start + duration;
	},
	
	/**
	 * @return {number} The Unix starting timestamp in seconds 
	 */
	getCalendarStartTime: function() {
		return this.calendar_start;
	},
	
	/**
	 * @return {number} The Unix ending timestamp in seconds
	 */
	getCalendarEndTime: function() {
		return this.calendar_start;
	}
};