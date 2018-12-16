class SplatsGetme{

	constructor(init_url){
		this.splat_url = init_url;
		this.is_loading = false;
	}

	//kee[ track of the loading url for data retrieval
	set_splat_url(url){
		this.splat_url = url;
	}

	get_splat_url(){
		return this.splat_url;
	}

	//variable to keep track of whether a splat load is pending
	set_is_loading(setting){
		this.is_loading = setting;
	}

	get_is_loading(){
		return this.is_loading;
	}
}



//class for user popups
class UserTrack{

	constructor(){
		this.timer_set = false;
		this.user_popup = document.createElement('div');
		this.user_popup.className = "hider";
		document.body.appendChild(this.user_popup);
		this.mousex = 0;
		this.mousey = 0;
	}



	get_timer_set(){
		return this.timer_set;
	}

	set_timer_set(setme){
		this.timer_set = setme;
	}

	//creates an info box when user hovers over user info
	create_popup(user_info, base_url){
		let offset_x = -100;
		let offset_y = this.set_y_offset();
		this.user_popup.style.left =  this.mousex + offset_x +  "px";
		this.user_popup.style.top = this.mousey + offset_y + "px";
		this.user_popup.className = "user-popup-visible rounded p-3 small";


		this.user_popup.innerHTML = "<div class='text-center'><img class='rounded-circle profile-pic-med' src='" + base_url  + "/storage/profile_pics/" +  user_info.profile_image + "' alt='"+ user_info.username +"'></div>";

		this.user_popup.innerHTML += "<div class='mt-2 text-center'><b>" + user_info.name + "</b> <i>&#64;" + user_info.username +"</i></div>";

		this.user_popup.innerHTML += "<div class='mt-2'>" + user_info.profile_text + "</div>";

	}

	//changes offset for positioning of the user window
	set_y_offset(){
		let offset_y = -250;
		if(this.mousey < 240){
			offset_y = 35;
		}
		return offset_y;
	}

	remove_popup(){
		this.user_popup.className = "hider";
	}
}//end class

//set class instance to track user popup
let user_track = new UserTrack();


//set mouse locations with each mouse move
document.onmousemove = (event) =>{
	user_track.mousex = event.clientX;
	user_track.mousey = event.clientY;
};

//set even listener for hover
document.addEventListener('mouseover', (event) => {
//user_track.timer_set
	//hover over user to get user info popup only if another session is not in progress
	if(!user_track.timer_set){
		//hovering over user info
		if(event.target.matches('.user-splat')){
			 user_track.timer_set = true;
			 user_track.timer_set = setTimeout(() => {

				 let the_username = event.target.dataset.username;

				 url_send = base_url  + '/user-get-api/' + the_username;

				 getBasicData(url_send)
			 		//get the user info - async wait for success response before proceeding
			 		.then((re_returned_data) => {
			 			//set the counts
			 			if(re_returned_data.success){
			 				//get the text for like
				 			user_track.create_popup(re_returned_data, base_url);
			 			}
			 		});

				 user_track.timer_set = false;
			 }, 300);
		}
		else{
			clearTimeout(user_track.timer_set);
			user_track.remove_popup();
			user_track.timer_set = false;
		}
	}

	else{
		if(!event.target.matches('.user-splat')){
			clearTimeout(user_track.timer_set);
			user_track.remove_popup();
			user_track.timer_set = false;
		}
	}

});



//get the data from the database and pass to calling function
async function getBasicData(url){
		 //await the response of the fetch call
		let response = await fetch(url);
		 //proceed once the first promise is resolved.
		let data = await response.json()
	 	//proceed only when the second promise is resolved
	 	return data;
 }
