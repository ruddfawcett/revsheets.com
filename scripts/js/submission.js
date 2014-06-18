	function loginForm() {
		$('#login').modal('show'); 
	 $.ajax( {
			type: 'POST',
			url: './scripts/process.php',
			data: $('#loginForm').serialize(), 
			success: function(data) {
				$('#return').html(data);
			}
		} );
	}
	
	function signupForm() {
		$('#signup').modal('show'); 
	 $.ajax( {
			type: 'POST',
			url: './scripts/process.php',
			data: $('#signupForm').serialize(), 
			success: function(data) {
				$('#return2').html(data);
			}
		} );
	}
	
	function addMember() {
	 $.ajax( {
			type: 'POST',
			url: './scripts/process.php',
			data: $('#addMember').serialize(), 
			success: function(data) {
				$('#return3').html(data);
			}
		} );
	}
	
	function addSubject() {
	 $.ajax( {
			type: 'POST',
			url: './scripts/process.php',
			data: $('#addSubject').serialize(), 
			success: function(data) {
				$('#return4').html(data);
			}
		} );
	}
	
	function addGroup() {
	 $.ajax( {
			type: 'POST',
			url: './scripts/process.php',
			data: $('#addGroup').serialize(), 
			success: function(data) {
				$('#return5').html(data);
			}
		} );
	}
	
	function upload() {
	 $.ajax( {
			type: 'POST',
			url: './scripts/upload.php',
			xhr: function() {  // custom xhr
            myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
            }
            return myXhr;
       		},
			data: $('#uploadForm').serialize(), 
			success: function(data) {
				$('#return6').html(data);
			}
		} );
	}
	
	function newMember() {
	 $.ajax( {
			type: 'POST',
			url: './scripts/process.php',
			data: $('#newMemberForm').serialize(), 
			success: function(data) {
				$('#return8').html(data);
			}
		} );
	}
	
	function search() {
	 $.ajax( {
			type: 'POST',
			url: './scripts/search.php',
			data: $('#searchForm').serialize(), 
			success: function(data) {
				$('#searchReturn').html(data);
			}
		} );
	}
	
	function updateAccount() {
	 $.ajax( {
			type: 'POST',
			url: './scripts/process.php',
			data: $('#updateAccountForm').serialize(), 
			success: function(data) {
				$('#return9').html(data);
			}
		} );
	}