
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
	parse_splats(splats){
		splats.forEach( (big_splat) =>{
				let target_div = document.getElementById("your_splats");
				let new_div = document.createElement('div');
				new_div.innerText += big_splat.splat;
				new_div.innerHTML += "<hr>";
				target_div.appendChild(new_div);
		});
	}

}


let splats_get_me = new SplatsGetme('http://127.0.0.1:8000/customer-splats/');
let latest_splats = new LatestSplats();

//get the data from the database and pass to calling function
async function getData(url, splats_get_me_cl){
		splats_get_me_cl.set_is_loading(true);
		 //await the response of the fetch call
		let response = await fetch(url);
		 //proceed once the first promise is resolved.
		let data = await response.json()
	 	//proceed only when the second promise is resolved
	 	return data;
 }



//show the splats on loading of window
window.addEventListener('load', () =>{ grab_show_splats() });

//show more splats when the user scrolls
window.addEventListener('scroll',() =>{ cond_grab() });

//conditional slat grab for scrolling.
//only get splats if the scroll is at or near bottom of page and if there is not
//a current splat load pending
function cond_grab(){
	if (!splats_get_me.get_is_loading() && window.innerHeight + window.scrollY >= document.body.offsetHeight) {
		grab_show_splats();
	}
}

//grab the splats from the database and display them on the page
function grab_show_splats(){
	getData(splats_get_me.get_splat_url(), splats_get_me)
		.then((re_returned_data) => {
				//displays the splats
				latest_splats.parse_splats(re_returned_data.data);
				//Next, set the next splat url
				splats_get_me.set_splat_url(re_returned_data.next_page_url);
				//set the loader to false to allow for future loading
				splats_get_me.set_is_loading(false);

		});
}
