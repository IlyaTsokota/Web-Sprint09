

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

window.addEventListener('load', () => {

	postData("index.php", JSON.stringify({ isadmin: true }))
		.then(({ result }) => {
			document.querySelector('h1').textContent = !result ? 'Admin' : 'User';
		});


});


document.querySelector('a').addEventListener('click', (e) => {
	e.preventDefault();
	postData("index.php", JSON.stringify({ clear: true }))
		.then(() => {
			document.location.href = 'index.html';
		});

});