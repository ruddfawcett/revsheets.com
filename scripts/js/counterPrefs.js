$(function(){
		$('#remainingCharacters2').textCounter({
			target: '#inputTitle', // required: string
			count: 50, // optional: integer [defaults 140]
			alertAt: 20, // optional: integer [defaults 20]
			warnAt: 10, // optional: integer [defaults 0]
			stopAtLimit: true // optional: defaults to false
		});
		$('#remainingCharacters').textCounter({
			target: '#sheetDescription', // required: string
			count: 200, // optional: integer [defaults 140]
			alertAt: 20, // optional: integer [defaults 20]
			warnAt: 10, // optional: integer [defaults 0]
			stopAtLimit: true // optional: defaults to false
		});
	});
