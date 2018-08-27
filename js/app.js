let main_div;

(function() {

	window.addEventListener('popstate', history_nav_listener);
	history_nav_listener();
	set_nav_listeners();

	setTimeout(function() {
		hide_preload();
	},1000);

}());

function show_preload() {
	document.getElementsByClassName('pre_load')[0].style.display = 'block';
}

function hide_preload() {
	document.getElementsByClassName('pre_load')[0].style.display = 'none';
}


function load_content(target) {
	if(!isFinite(main_div)) {
		main_div = document.querySelector("#current");
	}
	window.history.pushState("",null,target);
	let template 		= document.querySelector(`#${target}`);
	let top_nav_links 	= document.querySelectorAll('.nav ul li');
	main_div.innerHTML 	= template.innerHTML;

	top_nav_links.forEach(elem=>{

		let anchor_tag = elem.querySelector('a');
		if(anchor_tag.getAttribute("href") === `/${target}`) {
			anchor_tag.classList.add('active');
		}
		else {
			anchor_tag.classList.remove('active');
		}
	});
	set_nav_listeners();
}

function set_nav_listeners() {
	let all_anchor_tags = document.querySelectorAll('.loads_content');

	all_anchor_tags.forEach((link)=>{

		link.removeEventListener("click", nav_item_click, false);
		link.addEventListener("click", nav_item_click, false);
	});
}

function nav_item_click(e) {
	e.preventDefault();
	load_content(e.target.getAttribute('href').replace("/",""));
}


function history_nav_listener() {
	let current_path = location.pathname.replace('/','');
	if(current_path.length > 1 &&document.querySelector("#"+current_path)) {
		load_content(current_path);
	}
	else {
		load_content("home");
	}
}