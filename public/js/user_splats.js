
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

	//sets splats for main user on home page only
	show_user_splats(splats){
			splats.forEach( (big_splat) =>{
				let target_div = document.getElementById("show_splats");
				let new_div = document.createElement('div');

				//set the rows
				let enclosed_div_row_one = document.createElement('div'); // user info row
				let enclosed_div_row_two = document.createElement('div');

				enclosed_div_row_one.className = "row";
				enclosed_div_row_one.className = "row";

				let sub_div_one = document.createElement('div');
				let sub_div_two = document.createElement('div');

				//top user info
				sub_div_one.className = "col-md-12 text-center small";
				let time_wrapper = this.set_time(big_splat.created);

				let like_counter = this.like_count_set(big_splat.likes_count, big_splat.splat_id, true);

				time_wrapper.appendChild(like_counter);

				sub_div_one.appendChild(time_wrapper);



				//actual splat text
				sub_div_two.className = "col-md-12 text-center splat_text";
				sub_div_two.innerHTML = big_splat.splat;

				enclosed_div_row_one.appendChild(sub_div_one);
				enclosed_div_row_two.appendChild(sub_div_two);

				new_div.appendChild(sub_div_one);
				new_div.appendChild(sub_div_two);

				new_div.innerHTML += "<hr>";
				target_div.appendChild(new_div);
			});
	}

	//show splats for non-users
	show_non_user_splats(splats){
		//loop through each splat and set the display and contents
		splats.forEach( (big_splat) =>{

			//main wrapper div for each splat
			let target_div = document.getElementById("show_splats");
			let new_div = document.createElement('div');

			//set the rows
			let enclosed_div_row_one = document.createElement('div'); // user info row
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

			let user_span_one = document.createElement('span');
			user_span_one.className = "user-splat";

			//set data
			user_span_one.dataset.username = big_splat.username;

			user_span_one.innerHTML += user_img + " ";
			user_span_one.innerHTML += big_splat.userfullname + " ";
			user_span_one.innerHTML += big_splat.user_url;

			sub_div_one.appendChild(user_span_one);



			//actual splat text
			sub_div_two.innerHTML = big_splat.splat;

			enclosed_div_row_one.appendChild(sub_div_one);
			enclosed_div_row_two.appendChild(sub_div_two);

			let time_wrapper = this.set_time(big_splat.created);
			sub_div_one.appendChild(time_wrapper);

			//follow and like  - only show follow link if follow and like are valid
			if(big_splat.allow_follow){
				//create the like spans
				let like_span = this.create_like_span(big_splat.liked, big_splat.splat_id);

				//create the follow / unfollow links
				let follow_div_wrapper = document.createElement('div');
				let follow_div = this.create_follow_div(big_splat.userid, big_splat.main_user_id, big_splat.following);

				sub_div_one.appendChild(follow_div_wrapper);
				follow_div_wrapper.appendChild(follow_div);
				follow_div_wrapper.appendChild(like_span);

				//sets the section which displays number of likes a splat has
				let like_counter = this.like_count_set(big_splat.likes_count, big_splat.splat_id);
				follow_div_wrapper.appendChild(like_counter);
			}

			new_div.appendChild(enclosed_div_row_one);
			new_div.appendChild(enclosed_div_row_two);

			new_div.innerHTML += "<hr>";
			target_div.appendChild(new_div);
		});
	}


	//displays the counter displaying number of likes for a splat
	like_count_set(likes_count, splat_id, main_user = false){
		let like_counter = document.createElement('span');
		like_counter.className = "small";
		like_counter.dataset.likeCounterSplatId = splat_id;

		if(likes_count){
			let like_text = this.create_like_text(likes_count);
			like_counter.innerHTML = "<br>( " + likes_count + like_text + " ) ";
		}
		return like_counter;
	}

	create_like_text(likes_count){
		//if the main user then include the word like/s
		let like_text = "";

		if(likes_count == 1){
			like_text = " person likes this"
		}
		else if(likes_count > 1){
			like_text = " people like this"
		}
		return like_text;
	}


	set_time(the_time){
		//time of post
		let time_wrapper = document.createElement('div');
		time_wrapper.className = "small time_show";
		time_wrapper.innerHTML = the_time;
		return time_wrapper;
	}

	create_follow_div(user_id, main_user_id, following){

		let follow_divs = document.createElement('div');

		if(following){
			follow_divs.className = "small unfollow";
			follow_divs.innerText = "UNFOLLOW";
		}
		else{
			follow_divs.className = "small follow";
			follow_divs.innerText = "FOLLOW";
		}

		follow_divs.dataset.followUser = user_id;
		follow_divs.dataset.mainUser = main_user_id;

		return follow_divs;
	}


	create_like_span(liked, splat_id){
			//create the like spans
			let like_spans = document.createElement('span');

			if(liked){
				like_spans.className = "unliker";
				like_spans.innerHTML = this.set_unlike_image_html();
				like_spans.dataset.splatId = splat_id;
			}

			else{
				like_spans.className = "liker";
				like_spans.innerHTML = this.set_like_image_html();
				like_spans.dataset.splatId = splat_id;
			}
			return like_spans;
	}


	set_like_image_html(){
		let likeme = 'LIKE SPLAT';
		return likeme;
	}

	set_unlike_image_html(){
		let likeme = 'UNLIKE SPLAT';
		return likeme;
	}

	set_image_html(username, src_file){
		let image_html = '<img class="rounded-circle profile-pic-small user-splat" data-username="'+username+'" src="' + this.base_url  + '/storage/profile_pics/' + src_file + '" alt="'+ username +'">';
		return image_html;
	}

	add_follow_link(username){
		let follow_html = '<a href=""></a>';
	}

}//end class




class UserTrack{

	constructor(){
		this.timer_set = false;
	}

	get_timer_set(){
		return this.timer_set;
	}

	set_timer_set(setme){
		this.timer_set = setme;
	}
//354
	//creates an info box when user hovers over user info
	create_popup(){
		this.user_popup = document.createElement('div');
		this.user_popup.className = "user-popup-visible";
		document.body.appendChild(this.user_popup);
	}

	remove_popup(){
		alert("REMOVE");
		document.body.removeChild(this.user_popup);
	}
}

let user_track = new UserTrack();
let splats_get_me = new SplatsGetme(the_url);
let latest_splats = new LatestSplats(base_url);



//set event listener for delegation application of event listener to dynamic objects
document.addEventListener('click', (event) => {

	//if the follow user element is clicked
	if (event.target.matches('.follow')) {
		//call the backend follow function and set elements from same user to unfollow
		process_follow(base_url + '/follow_user_ajax', event.target.dataset.followUser, "UNFOLLOW", "small unfollow", "POST");
	}

	//if the follow user element is clicked
	if (event.target.matches('.unfollow')) {
		//call the backend unfollow function
		process_follow(base_url + '/unfollow_user_ajax', event.target.dataset.followUser, "FOLLOW", "small follow", "DELETE");
	}

	if (event.target.matches('.liker')) {
		//call the backend like unlike function
		process_like(base_url + '/like-splat', event.target.dataset.splatId, "UNLIKE SPLAT", "unliker", "POST", true);
		set_counts(event.target.dataset.splatId, base_url);
	}

	if (event.target.matches('.unliker')) {
		//call the backend like unlike function
		process_like(base_url + '/unlike-splat', event.target.dataset.splatId, "LIKE SPLAT", "liker", "DELETE", false);
		set_counts(event.target.dataset.splatId, base_url);
			//splatId
	}
});

//set even listener for hover
document.addEventListener('mouseover', (event) => {
//user_track.timer_set
	document.getElementById('tempo').innerText = user_track.get_timer_set();
	//hover over user to get user info popup only if another session is not in progress
	if(!user_track.timer_set){
		if(event.target.matches('.user-splat')){
			 user_track.timer_set = setTimeout(() => {
				 //alert(event.target.dataset.username);
				 user_track.create_popup();
				 user_track.timer_set = false;
			 }, 1000);
		}
	}
	else{
		user_track.remove_popup();
		//clear timeout if hover out
		if(!event.target.matches('.user-splat')){
			clearTimeout(user_track.timer_set);
			user_track.timer_set = false;
		}
	}



});



//like_count_set(likes_count, splat_id, main_user = false)
//create_like_text(likes_count)

//set the like counts when the like status has changed
function set_counts(splat_id, url){
	url_send = url  + '/get-like-count/' + splat_id;
	let like_count_set = document.querySelector("[data-like-counter-splat-id='"+splat_id+"']");

	//get the like counts
	getBasicData(url_send)
		//like or unlike - async wait for success response before proceeding
		.then((re_returned_data) => {
			//set the counts
			if(re_returned_data.success){
				//get the text for like
				let the_text = latest_splats.create_like_text(re_returned_data.success);
				like_count_set.innerHTML = "<br>( " + re_returned_data.success + the_text + " ) ";
			}
			else{
				like_count_set.innerHTML = "";
			}
		});
}


//Processes the likes and unlikes on a page. Sends like / unlike data to dbase

function process_like(url, splat_id, inner_html, classnames, data_method, to_like){
	let data = {
		"splat_id" : splat_id,
		"to_like" : to_like
	}
	setData(url, data, data_method)

		//like or unlike - async wait for success response before proceeding
		.then((re_returned_data) => {

			if(re_returned_data.success){
				//Get the button and change appearance and state
				let like_set = document.querySelector("[data-splat-id='"+splat_id+"']");
				like_set.innerHTML = inner_html;
				like_set.className = classnames;
			}
		});

}

//processes when user clicks follow buttons - sends follow data to dbase
//and retrieves success failure message, changes button appearance
function process_follow(url, follow_user, inner_html, classnames, data_method){

	let data = {
		"follow_user": follow_user
	}

	setData(url, data, data_method)
	//follow or unfollow - async wait for success response before proceeding
		.then((re_returned_data) => {

			if(re_returned_data.success){

				let followed = document.querySelectorAll("[data-follow-user='"+follow_user+"']");
				//loop through and change all elements from followed user
				followed.forEach( (foll) => {
					foll.innerHTML = inner_html;
					foll.className = classnames;
				});
			}

		});

}


//submit data as post and get success or failure message
async function setData(url, data, data_method){
	let headers = {
	   "Content-Type": "application/json",
	   "Access-Control-Origin": "*",
		 'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
	}
	//wait for a response from the server before proceeding
	let response = await fetch(url, {
									    method: data_method,
									    headers: headers,
									    body:  JSON.stringify(data)
									});
	//proceed once first promise resolved
	//wait until contents has been jsonified before proceeding
  let reply = await response.json();
	//proceed once second promise resolved
	return reply;

}


//show the splats on loading of window
window.addEventListener('load', () =>{ grab_show_splats(usertype) });

//show more splats when the user scrolls
window.addEventListener('scroll',() =>{ cond_grab(usertype) });


//get the data from the database and pass to calling function
async function getBasicData(url){
		 //await the response of the fetch call
		let response = await fetch(url);
		 //proceed once the first promise is resolved.
		let data = await response.json()
	 	//proceed only when the second promise is resolved
	 	return data;
 }



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
