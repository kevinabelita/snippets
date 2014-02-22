<?php echo Asset::js('jquery.easing.1.3.js'); ?>
<style type="text/css">
body {
	background-color: #fff;
	padding:0px;
	margin:0px;
}


.slots {
	font-size:100px;
	font-family:arial,helvetica,sans-serif;
	overflow:hidden;
	width:100px;
	height:100px;
	border:1px solid black;
	float:left;
}

.slots .wrapper{
	margin-top:-6px;
	width:100px;

}

.slots .slot{
	width:100px;
	height:100px;
	text-align:center;

}
</style>

<div style="width: 310px;">
	<div class="slots" id="slots_a">
		<div class="wrapper"></div>
	</div>
	<div class="slots" id="slots_b">
		<div class="wrapper"></div>
	</div>
	<div class="slots" id="slots_c">
		<div class="wrapper"></div>
	</div>
	<div style="text-align: center;">
		<input type="button" value="spin!" onClick="go();" style="margin-top:4px;" />
	</div>
</div>

<script type="text/javascript">
//note parseInt
//note stop

var opts = ['A','B','C','D','F'];

function go(){
	addSlots($("#slots_a .wrapper"));
	moveSlots($("#slots_a .wrapper"));
	addSlots($("#slots_b .wrapper"));
	moveSlots($("#slots_b .wrapper"));
	addSlots($("#slots_c .wrapper"));
	moveSlots($("#slots_c .wrapper"));
}

$(document).ready(function(){
	addSlots($("#slots_a .wrapper"));
	addSlots($("#slots_b .wrapper"));
	addSlots($("#slots_c .wrapper"));
});

function addSlots(jqo){
	for(var i = 0; i < 15; i++){
		var ctr = Math.floor(Math.random()*opts.length);
		jqo.append("<div class='slot'>"+opts[ctr]+"</div>");
	}
}

function moveSlots(jqo){
	var time = 6500;
	time += Math.round(Math.random()*1000);
	jqo.stop(true,true);

	var marginTop = parseInt(jqo.css("margin-top"), 10);
	marginTop -= (7 * 100);
		
	jqo.animate(
		{"margin-top":marginTop+"px"},
		{'duration' : time, 'easing' : "easeOutElastic"}
	);
}
</script>