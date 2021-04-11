'use strict';






const postData = async (url, data) => {
	const res = await fetch(url, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: data
	});
	return await res.json();
};


postData("index.php", JSON.stringify({ load: true }))
	.then(({ result }) => {
		if (result) {
			document.location.href = 'main.html';
		}
	});


const el = (selector) => document.querySelector(selector);

function toggleClass(elem, classToggle) {
	elem.classList.toggle(classToggle);
}

document.addEventListener("DOMContentLoaded", () => {
	try {
		const btn = document.querySelectorAll('.btn');
		const signInBtn = el('.btn-signin');
		const signUpBtn = el('.btn-signup');

		btn.forEach(item => {
			item.addEventListener('click', () => {
				if (!item.classList.contains('active')) {

					btn.forEach(elem => elem.classList.remove('active'));
					toggleClass(el(".form-signin"), "form-signin-left");
					toggleClass(el(".form-signup"), "form-signup-left");
					toggleClass(el(".frame"), "frame-long");
					toggleClass(el(".signup-inactive"), "signup-active");
					toggleClass(el(".signin-active"), "signin-inactive");
					toggleClass(el(".forgot"), "forgot-left");
					item.classList.remove('idle');
					item.classList.add('active');
				}
			});
		});


		signUpBtn.addEventListener('click', (e) => {
			e.preventDefault();

			signUp();
		});

		signInBtn.addEventListener('click', (e) => {
			e.preventDefault();

			signIn();
		});
	} catch { }

	const passwordValid = el('.password__fail');
	const confirmPasswordValid = el('.confirmpass__fail');

	const passwordInput = el(".form-signup input[name ='password']");
	const confirmPasswordInput = el(".form-signup input[name ='confirmpassword']");

	passwordInput.addEventListener('input', inputPassword);
	confirmPasswordInput.addEventListener('input', confirmPassword);



	function inputPassword() {
		if (checkPassword(this.value)) {
			this.classList.remove('err');
			passwordValid.classList.add('hide');
			confirmPasswordInput.disabled = false;

		} else {
			this.classList.add('err');
			passwordValid.classList.remove('hide');
			confirmPasswordInput.disabled = true;
		}
	}

	function confirmPassword() {
		if (this.value === passwordInput.value) {
			this.classList.remove('err');
			confirmPasswordValid.classList.add('hide');
		} else {
			this.classList.add('err');
			confirmPasswordValid.classList.remove('hide');
		}
	}

	function checkPassword(password) {
		const pattern = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/g;
		return pattern.test(password);
	}


	function checkEmail(email) {
		const pattertn = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
		return pattertn.test(email);
	}

	//forms
	//sign up
	function formDataToJson(form) {
		return JSON.stringify(Object.fromEntries(new FormData(form).entries()));
	}

	function validationForm(form) {
		const inputs = form.querySelectorAll('input');

		let flag = true;
		inputs.forEach(input => {
			if (input.getAttribute('type') !== 'hidden') {
				const nextElem = input.nextElementSibling;
				const value = input.value;

				if (input.getAttribute('password') === 'email' && !checkPassword(value)) {

					if (value.length <= 6) {
						showErrorMsg(input, nextElem, `Поле должно содержать минимум 6 символов!`);
					} else {
						showErrorMsg(input, nextElem, `Пароль ненадежен!`);
					}
					flag = false;

				} else if (value.length <= 3) {
					showErrorMsg(input, nextElem, `Поле должно содержать минимум 3 символа!`);
					flag = false;
				} else if (input.getAttribute('name') === 'email' && !checkEmail(value)) {
					showErrorMsg(input, nextElem, `Поле не похоже на email!`);
					flag = false;
				}
			}
		});
		return flag;
	}

	function showErrorMsg(input, nextElem, text) {
		input.classList.add('err');
		nextElem.textContent = text;
		nextElem.classList.remove('hide');
	}

	function signUp() {

		const formSignUp = el('.form-signup');
		const elMsgForm = el('.sign__up-fail');

		if (validationForm(formSignUp)) {

			const json = formDataToJson(formSignUp);
			console.log(json);

			postData('index.php', json)
				.then(({ result }) => {
					if (result) {
						animationSignUp();
					} else {
						elMsgForm.textContent = 'Пользователь с таким логином или email уже зарегистрирован!';
					}
				}).catch(err => {
					elMsgForm.textContent = err;
				});
		}
	}

	function animationSignUp() {
		toggleClass(el(".nav"), "nav-up");
		toggleClass(el(".form-signup-left"), "form-signup-down");
		toggleClass(el(".success"), "success-left");
		toggleClass(el(".frame"), "frame-short");
	}


	function signIn() {

		const formSignIn = el('.form-signin');
		const elMsgForm = el('.sign__in-fail');

		if (validationForm(formSignIn)) {

			const json = formDataToJson(formSignIn);
			console.log(json);

			postData('index.php', json)
				.then(({ result }) => {
					if (result) {
						const obj = JSON.parse(json);
						animationSignIn(obj.login);
					} else {
						elMsgForm.textContent = 'Неверный логин или парооль!';
					}
				}).catch(err => {
					elMsgForm.textContent = err;
				});
		}
	}

	function animationSignIn(login) {
		toggleClass(el(".btn-animate"), "btn-animate-grow");
		toggleClass(el("#check"), "hide");
		toggleClass(el(".welcome"), "welcome-left");
		el(".welcome").textContent = `Welcome, ${login}`;
		toggleClass(el(".success"), "success-left");
		toggleClass(el(".cover-photo"), "cover-photo-down");
		toggleClass(el(".frame"), "frame-short");
		toggleClass(el(".profile-photo"), "profile-photo-down");
		toggleClass(el(".btn-goback"), "btn-goback-up");
		toggleClass(el(".forgot"), "forgot-fade");
	}


});
