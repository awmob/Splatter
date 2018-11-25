
/*
Get the first lot of splats
parse through json
display
get the next page url
get the next lot of splats
rinse and repeat

if the next page url is null, then stop
*/

/*

Keeps track of loading urls
Also keep track of loading status
*/
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

class LatestSplats{
	/*
		Loop through the passed splats and display them
	*/
	constructor(base_url){
		this.base_url = base_url;
	}

	//sets splats for user only
	show_user_splats(splats){
			splats.forEach( (big_splat) =>{
				let target_div = document.getElementById("show_splats");
				let new_div = document.createElement('div');
				new_div.className = "text-center splat_text";
				new_div.innerHTML = big_splat.splat;

				new_div.innerHTML += "<hr>";
				target_div.appendChild(new_div);
			});
	}

	//show splats for non-users
	show_non_user_splats(splats){
		splats.forEach( (big_splat) =>{

			//main wrapper div for each splat
			let target_div = document.getElementById("show_splats");
			let new_div = document.createElement('div');

			let enclosed_div_row_one = document.createElement('div');
			let enclosed_div_row_two = document.createElement('div');

			enclosed_div_row_one.className = "row";
			enclosed_div_row_one.className = "row";

			let sub_div_one = document.createElement('div');
			let sub_div_two = document.createElement('div');

			//user profile image
			let user_img = this.set_image_html(big_splat.username, big_splat.user_image);

			//top user info
			sub_div_one.className = "col-md-12 text-center small";

			//actual splat text
			sub_div_two.className = "col-md-12 text-center splat_text";

			//top user info
			sub_div_one.innerHTML = user_img + " ";
			sub_div_one.innerHTML += big_splat.userfullname + " ";
			sub_div_one.innerHTML += big_splat.user_url;

			//actual splat text
			sub_div_two.innerHTML = big_splat.splat;

			enclosed_div_row_one.appendChild(sub_div_one);
			enclosed_div_row_two.appendChild(sub_div_two);

			//follow - only show follow link if follow is valid
			if(big_splat.allow_follow){
				let follow_div_wrapper = document.createElement('div');

				let follow_div = document.createElement('div');

				follow_div.className = "small follow";
				follow_div.id = "bb" + big_splat.main_user_id;
				follow_div.innerText = "FOLLOW";

				follow_div.dataset.followUser = big_splat.userid;
				follow_div.dataset.mainUser = big_splat.main_user_id;

				sub_div_one.appendChild(follow_div_wrapper);
				follow_div_wrapper.appendChild(follow_div);

			}

			new_div.appendChild(enclosed_div_row_one);
			new_div.appendChild(enclosed_div_row_two);

			new_div.innerHTML += "<hr>";
			target_div.appendChild(new_div);
		});
	}

	set_image_html(username, src_file){
		let image_html = '<img class="rounded-circle profile-pic-small" src="' + this.base_url  + '/storage/profile_pics/' + src_file + '" alt="'+ username +'">';
		return image_html;
	}

	add_follow_link(username){
		let follow_html = '<a href=""></a>';
	}

}


let splats_get_me = new SplatsGetme(the_url);
let latest_splats = new LatestSplats(base_url);



//set event listener for delegation application of event listener to dynamic objects
document.addEventListener('click', function (event) {
	if (event.target.matches('.follow')) {
		//alert(event.target.dataset.followUser);
		//alert(event.target.dataset.mainUser);
		process_follow(base_url, event.target.dataset.followUser, event.target.dataset.mainUser);
		event.target.innerHTML = "UNFOLLOW";
	}
});


//processes when user clicks follow buttons - sends follow data to dbase
//and retrieves success failure message, changes button appearance
function process_follow(url, follow_user, main_user){
	url = url + '/follow_user_ajax';

	let data = {
		"follow_user": follow_user,
		"main_user": main_user
	}

	setData(url, data)
		.then((re_returned_data) => {
			alert(re_returned_data.data);
		});

}



//submit data as post and get success failure message
async function setData(url, data){
	let headers = {
	   "Content-Type": "application/json",
	   "Access-Control-Origin": "*",
		 'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
	}


	let response = await fetch(url, {
									    method: "POST",
									    headers: headers,
									    body:  JSON.stringify(data)
									});
	//proceed once first promise resolved
  let reply = await response.json();
	//proceed once second promise resolved
	return reply;

}




//show the splats on loading of window
window.addEventListener('load', () =>{ grab_show_splats(usertype) });

//show more splats when the user scrolls
window.addEventListener('scroll',() =>{ cond_grab(usertype) });



//get the data from the database and pass to calling function
async function getData(url, splats_get_me_cl){
		//set_is_loading tracks status of loading
		splats_get_me_cl.set_is_loading(true);
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
function cond_grab(call_type){
	if (!splats_get_me.get_is_loading() && window.innerHeight + window.scrollY >= document.body.offsetHeight) {
		grab_show_splats(call_type);
	}
}

//grab the splats from the database and display them on the page
function grab_show_splats(call_type){
	getData(splats_get_me.get_splat_url(), splats_get_me)
		.then((re_returned_data) => {

				//displays the splats - different depending on type
				if(call_type == "user"){
					latest_splats.show_user_splats(re_returned_data.data);
				}
				else{
					latest_splats.show_non_user_splats(re_returned_data.data);
				}


				//Next, set the next splat url
				splats_get_me.set_splat_url(re_returned_data.next_page_url);
				//set the loader to false to allow for future loading
				splats_get_me.set_is_loading(false);

		});
}
