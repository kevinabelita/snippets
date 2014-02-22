<style type="text/css">
body {
	background-color: #fff;
}
.button_num, .operator, .clear, .decimal {
	width: 30px;
	height: 30px;
	padding: 3px;
}
</style>

<div id="wrapper" style="background-color: #ccc; width: 157px;">
	<input type="text" id="screen" disabled />
	<table style="width: 100%; text-align: left; vertical-align: top; padding: 0;">
		<tbody>
		<!-- BUTTONS -->
			<tr>
				<td></td>
				<td><button class="operator" value="/">/</button></td>
				<td><button class="operator" value="*">*</button></td>
				<td><button class="operator" value="-">-</button></td>
			</tr>
			<tr>
				<td><button class="button_num" value="7">7</button></td>
				<td><button class="button_num" value="8">8</button></td>
				<td><button class="button_num" value="9">9</button></td>
				<td><button class="operator" value="+">+</button></td>
			</tr>
			<tr>
				<td><button class="button_num" value="4">4</button></td>
				<td><button class="button_num" value="5">5</button></td>
				<td><button class="button_num" value="6">6</button></td>
				<td><button class="clear">C</button></td>
			</tr>
			<tr>
				<td><button class="button_num" value="1">1</button></td>
				<td><button class="button_num" value="2">2</button></td>
				<td><button class="button_num" value="3">3</button></td>
				<td rowspan=2><button class="equals" style="width: 30px; height: 65px;">=</button></td>
			</tr>
			<tr>
				<td colspan=2 style="text-align: left;"><button class="button_num" value="0" style="width: 70px; height: 30px;">0</button></td>
				<td><button class="decimal" value=".">.</button></td>
			</tr>
		</tr>
	</tbody>
	</table>
</div>

<script type="text/javascript">
$(document).ready(function(){

	var first_val = null;
	var second_val = null;
	var total = null;
	var current_operation = null;
	
	$('.button_num').click(function(){
	
		var element = $(this).attr('value').toString();
		var screen = $('#screen').val().toString();
		$('#screen').val(screen + element);

	});
	
	$('.operator').click(function(){
 
		if(current_operation == null) {
			current_operation = $(this).attr('value');
		}
		
		if(first_val == null) {
			var screen = $('#screen').val();
			first_val = ($.trim(screen).length > 0) ? screen : '0';
		}
		
		$('#screen').val('');

	});
	
	$('.decimal').click(function(){
	
		var screen = $('#screen').val().toString();
	
		if(screen.indexOf('.') >= 0) {
			return;
		}
	
		$('#screen').val(screen + '.');
	});
	
	$('.equals').click(function(){
		
		if(first_val == null) {
			return;
		} else if(first_val != null && current_operation != null && second_val == null) {
			second_val = $('#screen').val();
		}
		
		if(first_val != null && second_val != null && current_operation != null) {
			total = calculate(first_val, current_operation, second_val);
			second_val = null;
			$('#screen').val(total);
			first_val = total;
			second_val = null;
			current_operation = null;
		}
		
	});
	
	$('.clear').click(function(){
		$('#screen').val('');
		first_val = null;
		second_val = null;
		current_operation = null;
		total = null;
	});
	
	function calculate(first_val, operation, second_val) {
		var result = parseFloat(0.0);
		first_val = (first_val % 1 !== 0) ? parseFloat(first_val) : parseInt(first_val);
		second_val = (second_val % 1 !== 0) ? parseFloat(second_val) : parseInt(second_val);

		switch(operation) {
			case '+':
				result = (first_val+second_val);
			break;
			case '-':
				result = (first_val-second_val);
			break;
			case '*':
				result = (first_val*second_val);
			break;
			case '/':
				result = (first_val/second_val);
			break;
		}
		
		result = (result % 1 !== 0) ? result.toPrecision(3) : result;
		
		return result;
	}
	
	$(document).keydown(function(e){
		e = e || event;
		var key = e.which || e.keyCode;
		if(96 <= key && key <= 105) {
			key = String.fromCharCode(key - 48);
			$('.button_num[value='+key+']').trigger('click');
		} else {
			switch(key) {
				case 106:
					key = '*';
					$(".operator[value='"+key+"']").trigger('click');
					break;
				case 107:
					key = '+';
					$(".operator[value='"+key+"']").trigger('click');
					break;
				case 109:
					key = '-';
					$(".operator[value='"+key+"']").trigger('click');
					break;
				case 110:
					$('.decimal').trigger('click');
					break;	
				case 111:
					key = '/';
					$(".operator[value='"+key+"']").trigger('click');
					break;
				case 13:
					$('.equals').trigger('click');
					break;
				case 27:
				case 8:
					$('.clear').trigger('click');
					break;
				default:
					return;
					break;
			}
		}
		
	});
	
});
</script>