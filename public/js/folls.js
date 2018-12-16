


class LatestFolls{

	constructor(){
		this.retrieved = new Array();
	}

	set_retrieved(the_val){
		if(this.retrieved.includes(the_val)){
			return true;
		}
		else{
			this.retrieved.push(the_val);
			return false;
		}
	}

	retrieved_shown(the_val){
		if(this.retrieved.includes(the_val)){
			return true;
		}
		else{
			return false;
		}
	}

	set_cur_page(the_val){
		this.cur_page = the_val;
	}

	get_cur_page(the_val){
		return this.cur_page;
	}


	//shows the followers - each row must be equal to 3 cols otherwise there
	//will be a mismatch in display style
	show_followers(ajax_data, url){
		let target_div = document.getElementById("show_followers");
		let new_div = document.createElement('div');


		let enclosed_div_row_one = document.createElement('div');
		enclosed_div_row_one.className = "row mb-4";

		ajax_data.forEach( (data_set) => {

			let col = document.createElement('div');
			col.className = "col-md-4 mb-4";
			let user_info = this.set_url(data_set.username, url, data_set.user_image);
			col.appendChild(user_info);
			enclosed_div_row_one.appendChild(col);
		});

		target_div.appendChild(enclosed_div_row_one);

	}
//.dataset.likeCounterSplatId

	set_url(username, url, img){

		let img_src = url + "/storage/profile_pics/" + img;
		let profile_pic = document.createElement('img');
		profile_pic.src = img_src;
		profile_pic.className = "user-splat profile-pic-med rounded-circle";
		profile_pic.dataset.username = username;

		let br = document.createElement('br');

		let user_info = document.createElement('span');
		user_info.dataset.username = username;
		user_info.className = "user-splat";

		let url_add = url + "/profile/" + username;

		let newlink = document.createElement('a');
		newlink.className = "user-splat";
		newlink.dataset.username = username;
		newlink.setAttribute('href', url_add);

		let the_text = document.createTextNode("@" + username);

    newlink.appendChild(the_text);


		let imglink = document.createElement('a');
		imglink.setAttribute('href', url_add);



		imglink.appendChild(profile_pic);

		user_info.appendChild(imglink);
		user_info.appendChild(br);
		user_info.appendChild(newlink);

		return user_info;
	}

}

//set different titles dpeneding on status
function get_title(type){
	let title = "SPLATTER!";
	switch (type){
		case '1':
			title = "Following";
		break;
		case '2':
			title = "Followers";
		break;
	}
	return title;
}

//sets the header text
function set_heads(title, headname){

	let heads = document.getElementsByClassName(headname);

	for (let item of heads) {
	    item.innerHTML = title;
	}
}

let the_title = get_title(followtype);
set_heads(the_title, "follset");


//initialize Class instances
let folls_get_me = new SplatsGetme(url);
let latest_folls = new LatestFolls();


//set mouse locations with each mouse move
document.onmousemove = (event) =>{
	user_track.mousex = event.clientX;
	user_track.mousey = event.clientY;
};



//show the splats on loading of window
window.addEventListener('load', () =>{ grab_show(base_url) });

//show more splats when the user scrolls
window.addEventListener('scroll',() =>{ cond_grab(base_url) });



//get the data from the database and pass to calling function
async function getData(url, folls_get_me){
		folls_get_me.set_is_loading(true);
		 //await the response of the fetch call
		let response = await fetch(url);
		 //proceed once the first promise is resolved.
		let data = await response.json()
	 	//proceed only when the second promise is resolved
	 	return data;
 }


//conditional slat grab for scrolling.
//only get splats if the scroll is at or near bottom of page and if there is not
//a current splat load pending
function cond_grab(url){
	if (!folls_get_me.get_is_loading() && window.innerHeight + window.scrollY >= document.body.offsetHeight) {
		grab_show(url);
		//latest_folls.get_retrieved(3);
	}
}

	//	latest_folls.check_retrieved(data.current_page);
//grab the followers / followings from the database and display them on the page
function grab_show(url){
	//check that the current page has not already been retrieved
	getData(folls_get_me.get_splat_url(), folls_get_me)
		.then((re_returned_data) => {
			//only show if not already shown
				if(!latest_folls.retrieved_shown(re_returned_data.current_page)){
					//show the followers
					latest_folls.show_followers(re_returned_data.data, url);
					//Next, set the next splat url
					folls_get_me.set_splat_url(re_returned_data.next_page_url);
					//set the current page as complete
					latest_folls.set_retrieved(re_returned_data.current_page);
				}
				//set the loader to false to allow for future loading
				folls_get_me.set_is_loading(false);
		});
}
