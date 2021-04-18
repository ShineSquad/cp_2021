$(function() {
	var food_items = ['drink', 'donuts', 'hamburger'];
	for (i in food_items) {
		var node = document.getElementById(food_items[i]),
			count = node.getAttribute('count'),
			children = $(node).children()[0];
		$(children).text(count);
	}

	change_balance();
	change_avatar();
	satiety();

	$('.drag_elem').draggable({
		helper: "clone"
	});
	$('#avatar').droppable({
		drop: function() {
            alert('Вкусно');
            console.log(this)
        }
	});
});

function satiety() {
	let val = document.querySelector('#progress-satiety .value');
		val.style.width = '100%';
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
			localStorage.setItem('balance', JSON.parse(text).balance);
		});
	let balance_array = ['main-balance', 'clothes-balance', 'food-balance'],
		count = localStorage.getItem('balance');
	for (i in balance_array) {
		document.getElementById(balance_array[i]).innerText = count + ' монет';
	}
}

function buy( _type, _name, _value ) {
	count = localStorage.getItem('balance');
	if (count < _value) {
		alert('Недостаточно баллов!');
	} else {
		if (_type == 'clothes') {
			fetch('https://shsq.ru/mascot-rest/set_balance.php?id=2&inc=-'+ _value);
			change_balance();
			localStorage.setItem('active_avatar', './assets/' + _name);
			change_avatar();
			modal_food(' ' ,'none');
			modal_view(' ' ,'none');
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

const min_delay = 2000;
const max_delay = 3000;
const shake_duration = 300;
const messages = {
	"games": [
    	"Мне скучно", 
    	"Поиграй со мной", 
    	"Время играть!", 
    	"Мячик?"
    ],
    "foods": [
    	"Хочу кушать", 
    	"Время перекусить", 
    	"Кууушать!!!!", 
    	"Пора кушать", 
    	"Я голоден"
    ]
};
const sarcasm = [
	"sarcasm",
	"сарказм",
	"@!#?@!",
	"F"
];

function _feed() {
	// TODO:
	// update data on databse
	console.log("_feed");

	var node = document.querySelector("#mas-controls .foods"),
		count = parseInt(node.getAttribute("count"));

	if (count == 0) {
		node.classList.toggle("shake");
        sadPP();
		setTimeout(()=>{node.classList.toggle("shake")}, shake_duration);
	} else {
        hidePP();
    }

	node.setAttribute("count", (count-1 <= 0) ? 0 : count-1);
}
function _play() {
	// TODO:
	// update data on databse
	console.log("_play");

	var node = document.querySelector("#mas-controls .games"),
		count = parseInt(node.getAttribute("count"));

	if (count == 0) {
		node.classList.toggle("shake");
        sadPP();
		setTimeout(()=>{node.classList.toggle("shake")}, shake_duration);
	} else {
        hidePP();
    }

	node.setAttribute("count", (count-1 <= 0) ? 0 : count-1);
}

function sadPP() {
    setPPmsg(sarcasm[getRnd(0,sarcasm.length)])
    setTimeout(hidePP, 1000);
}

function showPP(text="42", type="others") {
	var popup = document.querySelector("#mas-popup");

	popup.innerText = text;
	popup.style.display = "flex";
	popup.setAttribute("type", type);

	setTimeout(()=>{ popup.style.opacity = 1; }, 10)
}

function hidePP() {
	var popup = document.querySelector("#mas-popup");

	popup.style.opacity = 0;

	setTimeout(()=>{ popup.style.display = "none"; }, 500)
}

function getRnd(min, max) { return parseInt(Math.random()*max + min); }

function PPmsg() {
	let key = Object.keys(messages)[getRnd(0,Object.keys(messages).length)];

	return {
		text: messages[key][getRnd(0,messages[key].length)],
		type: key
	}
}

function setPPmsg(text) {
	var popup = document.querySelector("#mas-popup");
	popup.innerText = text;
}

function PPtype() {
	return document.querySelector("#mas-popup").getAttribute("type");
}

function newMsg() {
	let msg = PPmsg();
	setTimeout(showPP, getRnd(min_delay,max_delay), msg.text, msg.type);
}

function bindActions() {
	let controls = document.querySelectorAll("#mas-controls .btn");
	for (node of controls) {
		node.addEventListener("click", (ev)=>{
			let cl = event.target.classList;
			if ( cl.contains(PPtype()) ) {
				if (PPtype() == "games") { _play(); }
				else { _feed() };

				newMsg(); // DEL
			}
		})
	}

	let popup = document.querySelector("#mas-popup");

	popup.addEventListener("click", (ev)=>{
		sadPP();
		newMsg(); // DEL
	})
}

window.addEventListener("load", (ev)=>{
	bindActions();
	newMsg(); // DEL
})