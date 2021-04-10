'use strict';


const el = (selector) => document.querySelector(selector);

function toggleClass(elem, classToggle) {
	elem.classList.toggle(classToggle);
}

document.addEventListener("DOMContentLoaded", () => {
	const btn = document.querySelectorAll('.btn');
	const signInBtn = el('.btn-signin');
	const signUpBtn = el('.btn-signup');

	btn.forEach(item => {
		item.addEventListener('click', (e) => {

			toggleClass(el(".form-signin"), "form-signin-left");
			toggleClass(el(".form-signup"), "form-signup-left");
			toggleClass(el(".frame"), "frame-long");
			toggleClass(el(".signup-inactive"), "signup-active");
			toggleClass(el(".signin-active"), "signin-inactive");
			toggleClass(el(".forgot"), "forgot-left");
			item.classList.remove('idle');
			item.classList.add('active');

		});
	});


	signUpBtn.addEventListener('click', (e) => {
		e.preventDefault();
		toggleClass(el(".nav"), "nav-up");
		toggleClass(el(".form-signup-left"), "form-signup-down");
		toggleClass(el(".success"), "success-left");
		toggleClass(el(".frame"), "frame-short");
	});

	signInBtn.addEventListener('click', (e) => {
		e.preventDefault();

		toggleClass(el(".btn-animate"), "btn-animate-grow");
		toggleClass(el("#check"), "hide");
		toggleClass(el(".welcome"), "welcome-left");
		toggleClass(el(".success"), "success-left");
		toggleClass(el(".cover-photo"), "cover-photo-down");
		toggleClass(el(".frame"), "frame-short");
		toggleClass(el(".profile-photo"), "profile-photo-down");
		toggleClass(el(".btn-goback"), "btn-goback-up");
		toggleClass(el(".forgot"), "forgot-fade");
	});

});
