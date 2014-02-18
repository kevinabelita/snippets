<center>
<table border="0" cellpadding="0" cellspacing="0" align="center">
<?php foreach($maze as $key_row => $value_row): ?>
	<tr>
	<?php foreach($value_row as $key_column => $value_column): ?>
		<?php if($maze[$key_row][$key_column] == 1): ?>
			<td bgcolor="black">WALL</td>
		<?php elseif($maze[$key_row][$key_column] == 2): ?>
			<td bgcolor="yellow">start</td>
		<?php elseif($maze[$key_row][$key_column] == 3): ?>
			<td bgcolor="yellow">end</td>
		<?php else: ?>
			<td bgcolor="white">&nbsp;</td>
		<?php endif; ?>
	<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
</table>
<form method="POST" action="">
	<input type="submit" value="Generate Map" onClick="window.location.reload();" /><br/>
	Width: <input type="text" name="dimension_x" value="<?php echo $dimension_x; ?>" />
	Height: <input type="text" name="dimension_y" value="<?php echo $dimension_y; ?>" />
</form>
</center>