

function initialize_text(obj){
	for (let key in obj){
		let item = document.getElementById(key);
		if(item.value.trim() === ""){
			item.value = obj[key];
		}
	}
}

//loop and set listeners
function add_change_listeners(obj){
	for (let key in obj){
		let item = document.getElementById(key);
		item.addEventListener('input', () => set_values(item, obj[key]) );
		item.addEventListener('click', () => set_values(item, obj[key]) );
		item.addEventListener('focusin', () => set_values(item, obj[key]) );
		item.addEventListener('focusout', () => reset_values(item, obj[key]) );
	}
}


function set_password_text_listeners(obj){
	for (let key in obj){
		let item = document.getElementById(key);

		item.value = obj[key];
			item.addEventListener('input', () =>  show_pass(item) );
			item.addEventListener('click', () => show_pass(item) );
			item.addEventListener('focusin', () => show_pass(item) );
			item.addEventListener('focusout', () => show_text(item, obj[key]) );
	}
}

function set_cc_listeners(obj){
	for (let key in obj){
		let item = document.getElementById(key);

		item.value = obj[key];
		item.addEventListener('input', () => {set_values(item, obj[key]), numbers_only(item) });
		item.addEventListener('click', () => set_values(item, obj[key]) );
		item.addEventListener('focusin', () => set_values(item, obj[key]) );
		item.addEventListener('focusout', () => reset_values(item, obj[key]) );
	}
}

//change to password
function show_pass(item){
	if(item.type === "text"){
		item.value = "";
		item.type = "password";
	}
}

//reset to text and enter original message
function show_text(item, name){
	if(item.type === "password"){
		if(item.value.trim() === ""){
			item.type = "text";
			item.value = name;
		}
	}
}

function disallow_spaces(item){
	item.value = item.value.replace(" ","");
}

function numbers_only(item){
	item.value = item.value.replace(/\D/g,"");
}

//set values for fields on the event
function set_values(item, textval){
	if(item.value === textval){
		item.value = "";
	}
}

//add values back if empty field
function reset_values(item, textval){
	if(item.value.trim() === ""){
		item.value = textval;
	}
}
