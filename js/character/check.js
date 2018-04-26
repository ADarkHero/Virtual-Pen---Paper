//Checks for illegal inputs; changes wrong inputs to warning color
function checkNoneWarning(input) {
		  var check = $('#'+input+' option:selected').text();
			if(check == "None"){
				$("#"+input).addClass("btn-warning");
				$("#submit").addClass("btn-danger");
				$("#submit").prop('disabled', true);
			}
			else{
				$("#"+input).removeClass("btn-warning");
				$("#submit").removeClass("btn-danger");
				$("#submit").prop('disabled', false);
			}
		};