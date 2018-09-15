$(document).ready(function(){

	updateTimestamps();
	setInterval(function(){
		updateTimestamps();
	},10000);
	
	function updateTimestamps(){
		let elements = $('time[datetime]');

		let current = new Date();

		for (let i = 0; i < elements.length; i++) {
			let element = $(elements[i]);
			let initial = new Date(element.attr('datetime'));
			
			//console.log(element.attr('datetime'));
			//console.log(initial.getTime());
			//console.log(current.getTime());

			let ellapsedSeconds = (Math.abs(current.getTime() - initial.getTime()) / 1000).toFixed(0);
			let ellapsedMinutes =  (ellapsedSeconds / 60).toFixed(0);
			let ellapsedHours = (ellapsedMinutes / 60).toFixed(0);		
			let ellapsedDays = (ellapsedHours / 24).toFixed(0);
			let ellapsedYears = (ellapsedDays / 365).toFixed(0);
			
			// console.log(ellapsedSeconds);
			// console.log(ellapsedMinutes);
			// console.log(ellapsedHours);
			// console.log(ellapsedDays);
			// console.log(ellapsedYears);
			
			if(ellapsedYears > 1) {
				element.text(ellapsedYears+' years ago');
				continue;
			}
			if(ellapsedDays > 1) {
				element.text(ellapsedDays+' days ago');
				continue;
			}
			if(ellapsedHours > 1) {
				element.text(ellapsedHours+' hours ago');
				continue;
			}
			if(ellapsedHours == 1) {
				element.text('about an hour ago');
				continue;
			}
			if(ellapsedMinutes > 1) {
				element.text(ellapsedMinutes+' minutes ago');
				continue;
			}
			if(ellapsedMinutes == 1) {
				element.text('about a minute ago');
				continue;
			}
			else
			{
				element.text('less than a minute ago');
			}

		}
	}
});