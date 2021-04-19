$(function() {
	
	food_update();
	change_balance();
	change_avatar();
	satiety();

	$('.drag_elem').draggable({
		helper: "clone"
	});
	$('#avatar').droppable({
		drop: function(event, ui) {
			let current_id = ui.draggable.attr('id'),
				current_item = document.getElementById(current_id),
				count = current_item.getAttribute('count'),
				food_value = current_item.getAttribute('food-value');
			current_item.setAttribute('count', count-1);
			food_update();

			let prog_val = document.querySelector('#progress-satiety .value').getAttribute('value'),
				prog_per = document.querySelector('#satiety-persent').getAttribute('value');

			document.querySelector('#progress-satiety .value').style.width = parseInt(prog_val)+parseInt(food_value)+'%';
			document.querySelector('#progress-satiety .value').setAttribute('value', parseInt(prog_val)+parseInt(food_value));

			document.querySelector('#satiety-persent').innerText = parseInt(prog_per)+parseInt(food_value)+'%';
			document.querySelector('#satiety-persent').setAttribute('value', parseInt(prog_val)+parseInt(food_value));
        }
	});
});

function food_update() {
	var food_items = ['drink', 'donuts', 'hamburger'];
	for (i in food_items) {
		var node = document.getElementById(food_items[i]),
			count = node.getAttribute('count'),
			children = $(node).children()[0];
		$(children).text(count);
	}
}

function satiety() {
	setInterval(() => {
		let progress = document.querySelector('#progress-satiety .value'),
			persent = document.querySelector('#satiety-persent'),
			val_progress = progress.getAttribute('value'),
			val_persent = persent.getAttribute('value');
			persent.innerText = val_persent+'%';
			progress.style.width = val_progress+'%';
		progress.setAttribute('value', val_persent-1);
		persent.setAttribute('value', val_persent-1);
		val_progress = progress.getAttribute('value');
			val_persent = persent.getAttribute('value');
		persent.innerText = val_persent+'%';
		progress.style.width = val_progress+'%';
	}, 5000)
}

function change_avatar() {
	let avatar = document.getElementById('avatar'),
		active = localStorage.getItem('active_avatar');
	if (!active) {
		avatar.setAttribute('src', './assets/pers2chisty.png');
	} else {
		avatar.setAttribute('src', active);
	}
}

function change_balance() {
	fetch("https://shsq.ru/mascot-rest/get_userinfo.php?id=2")
		.then(resp => resp.text())
		.then(text => {
			var bal = JSON.parse(text).balance;
			localStorage.setItem('balance', bal);
			let balance_array = ['main-balance', 'clothes-balance', 'food-balance'];
			for (i in balance_array) {
				document.getElementById(balance_array[i]).innerText = bal + ' монет';
			}
		});
	
}

function buy( _type, _name, _value ) {
	count = localStorage.getItem('balance');
	if (count < _value) {
		alert('Недостаточно баллов!');
	} else {
		if (_type == 'clothes') {
			fetch('https://shsq.ru/mascot-rest/set_balance.php?id=2&inc=-'+ _value)
				.then(resp => resp.text())
				.then(text => {
					change_balance();
					localStorage.setItem('active_avatar', './assets/' + _name);
					change_avatar();
					modal_food(' ' ,'none');
					modal_view(' ' ,'none');
				})
		}
	}
}

function modal_view( _item, _state ) {
	var items = ['clothing-modal', 'food-modal', 'artifacts-modal'];
	if (_state == 'none') {
		for (let i in items) {
			$('.' + items[i]).removeClass('active');
		}
	} else {
		$('.'+_item).addClass('active');
	}
	$('#skin-shop').css('display', _state);
}

function modal_food( _item, _state ) {
	var items = ['clothing-modal', 'food-modal', 'artifacts-modal'];
	if (_state == 'none') {
		for (let i in items) {
			$('.' + items[i]).removeClass('active');
		}
	} else {
		$('.'+_item).addClass('active');
	}
	$('#food-shop').css('display', _state);
}