/*
	Important class names
	error message tag: .error-message
	required fields: .required-input
	form to be validated: .validate-submit
	
	Optional classes
	email: email-input
	
	Tag: place at the end of body
	<script src="../config/validator.js"></script>

	support: type = text, date
*/

let required = document.querySelectorAll(".required-input");
let form = document.querySelector(".validate-submit");
let errorMsg = document.querySelector(".error-message");

if (form && required.length != 0 && errorMsg.length != 0)
{

	required.forEach(r => {
		r.addEventListener("change", (e) => {
			let error = validateElement(r);

			if (error) {
				errorMsg.classList.remove("error-hidden");
			}
			else {
				errorMsg.classList.add("error-hidden");
			}
		})
	});

	form.addEventListener("submit", (e) => {
		let error = false;
		required.forEach(r => {
			error = error || validateElement(r);
		});

		let passwords = document.querySelectorAll(".password-pair");
		if (passwords.length != 0) {
			let p = passwords[0].value;
			passwords.forEach(check => {
				if (p != check.value) {
					errorMsg.innerHTML = 'Passwords do not match.';
					error = true;
				}
			});
		}
		if (error) {
			errorMsg.classList.remove("error-hidden");
			e.preventDefault();
		}
		else {
			errorMsg.classList.add("error-hidden");
		}
	});
}

function validateElement(elem) {
	if (elem.value == ""
		|| (elem.type == "date" && elem.value == "0000-00-00"))
	{
		let label = elem.previousElementSibling.innerHTML;
		errorMsg.innerHTML = 'Please fill out the "' + label.toLowerCase() + '" field.';
		return true;
	}
	if (elem.classList.contains("email-input") && elem.value != "") {
		if (validateEmail(elem.value)) {
			errorMsg.innerHTML = 'Please enter a valid email address.';
			return true;
		}
	}
	return false;
}

function validateDate(val) {
	if (val == "0000-00-00") return false;
	return true;
}

function validateText(val) {
	if (val == "") return false;
	return true;
}

function validateEmail(val) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return !re.test(String(val).toLowerCase());
}