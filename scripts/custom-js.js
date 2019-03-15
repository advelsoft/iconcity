$(function() {
    $('#side-menu').metisMenu();
    $('#form-menu').metisMenu();
    $('#jmb-menu').metisMenu();
    $('#use-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
     return this.href == url;
    }).addClass('active').parent();

    while(true){
        if (element.is('li')){
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});

function enable_dropdown(container) {
	$(container).dropdown();
}

function enable_sidebar() {
	$('.navbar-toggle').click(function(evt) {
		if($('.sidebar-left').hasClass('shown')) {
			$('.sidebar-left').animate({'left':'-300px'}, 300).removeClass('shown');
			$('.navbar-toggle').removeClass('active');
		}else{
			$('.sidebar-left').animate({'left':'0px'}, 300).addClass('shown');
			$('.navbar-toggle').addClass('active');
		}
	});
	
	$('ul.navigation > li > a').click(function(evt) {
		var t = $(this);
		
		if($(this).next().hasClass('dropdown') === false)
			return;
		
		evt.preventDefault();
		
		// Is this one open? Just close it
		if($(this).next().is(':visible')) {
			t.next().removeClass('animated');
			t.next().slideUp(300);
			t.children('span.arrow').children('i.fa-angle-down').removeClass('fa-angle-down').addClass('fa-angle-right');
			return;
		}
		
		// Close all dropdowns
		$('ul.navigation ul.dropdown.animated').removeClass('animated');
		$('ul.navigation ul.dropdown').slideUp(300);
		$('ul.navigation i.fa-angle-down').removeClass('fa-angle-down').addClass('fa-angle-right');
		
		// Open new
		$(this).next().slideDown(300, function() {
			t.next().addClass('open');
			t.children('span.arrow').children('i.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-down');
			t.next().addClass('animated');
		});
	});
}


$(document).ready(function(){
	$('tr').click(function(evt) {
		if($(this).data('href') !== undefined)
			location.href = $(this).data('href');
	});
});


//Technician Create
function getEmailC(str) {
	if (str == "") {
		document.getElementById("EmailName").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("EmailName").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","Email?name="+str,true);
	xmlhttp.send();
}

//Technician Update
function getEmailU(str) {
	if (str == "") {
		document.getElementById("EmailName").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("EmailName").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","../Email?name="+str,true);
	xmlhttp.send();
}

//NameEmail Create
function getPositionC(str) {
	if (str == "") {
		document.getElementById("DeptPos").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("DeptPos").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","Position?dept="+str,true);
	xmlhttp.send();
}

//NameEmail Update
function getPositionU(str) {
	if (str == "") {
		document.getElementById("DeptPos").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("DeptPos").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","../Position?dept="+str,true);
	xmlhttp.send();
}

//Categories Create
function getCategoriesC(str) {
	if (str == "") {
		document.getElementById("EmailDept").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("EmailDept").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","Email?dept="+str,true);
	xmlhttp.send();
}

//Categories Update
function getCategoriesU(str) {
	if (str == "") {
		document.getElementById("EmailDept").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("EmailDept").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","../Email?dept="+str,true);
	xmlhttp.send();
}

//SubCategories Create
function getSubCategoriesC(str) {
	if (str == "") {
		document.getElementById("EmailCat").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("EmailCat").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","Email?cat="+str,true);
	xmlhttp.send();
}

//SubCategories Update
function getSubCategoriesU(str) {
	if (str == "") {
		document.getElementById("EmailCat").innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("EmailCat").innerHTML = this.responseText;
		}
	}
	xmlhttp.open("GET","../Email?cat="+str,true);
	xmlhttp.send();
}


$(document).ready(function(){
    $("#Amount").toggle();
    $("#Desc").toggle();
    $("#chk").change(function () {
        $("#Amount").toggle();
        $("#Desc").toggle();
    });
});


$(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var x = 2; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
	var fieldHTML = '<div class="col-md-10 remove_field">'+
					'<input class="col-md-6" type="file" name="Attachment'+x+'" value=""/>'+
					'<a href="javascript:void(0);" class="remove_button col-md-6" title="Remove field">'+
					'<img src="http://localhost/menarabangsar/content/img/remove-icon.png" /></a></div>'; //New input field html 
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

$(document).ready(function(){
	$('#select_all').click(function() {
        $('#PropertyNo option').prop('selected', true);
    });
});
