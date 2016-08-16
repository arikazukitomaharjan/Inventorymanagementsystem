<script type="text/javascript" charset="utf-8">
        $(function()
{

// initialise the "Select date" link
$('#date-pick')
	.datePicker(
		// associate the link with a date picker
		{
			createButton:false,
			startDate:'01/01/2005',
			endDate:'31/12/2020'
		}
	).bind(
		// when the link is clicked display the date picker
		'click',
		function()
		{
			updateSelects($(this).dpGetSelected()[0]);
			$(this).dpDisplay();
			return false;
		}
	).bind(
		// when a date is selected update the SELECTs
		'dateSelected',
		function(e, selectedDate, $td, state)
		{
			updateSelects(selectedDate);
		}
	).bind(
		'dpClosed',
		function(e, selected)
		{
			updateSelects(selected[0]);
		}
	);
	
var updateSelects = function (selectedDate)
{
	var selectedDate = new Date(selectedDate);
	$('#d option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
	$('#m option[value=' + (selectedDate.getMonth()+1) + ']').attr('selected', 'selected');
	$('#y option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
}
// listen for when the selects are changed and update the picker
$('#d, #m, #y')
	.bind(
		'change',
		function()
		{
			var d = new Date(
						$('#y').val(),
						$('#m').val()-1,
						$('#d').val()
					);
			$('#date-pick').dpSetSelected(d.asString());
		}
	);

// default the position of the selects to today
//var today = new Date();
//updateSelects(today.getTime());

// and update the datePicker to reflect it...
//$('#d').trigger('change');
});

$(function()
{

// initialise the "Select date" link
$('#date-pick2')
	.datePicker(
		// associate the link with a date picker
		{
			createButton:false,
			startDate:'01/01/2005',
			endDate:'31/12/2020'
		}
	).bind(
		// when the link is clicked display the date picker
		'click',
		function()
		{
			updateSelects($(this).dpGetSelected()[0]);
			$(this).dpDisplay();
			return false;
		}
	).bind(
		// when a date is selected update the SELECTs
		'dateSelected',
		function(e, selectedDate, $td, state)
		{
			updateSelects(selectedDate);
		}
	).bind(
		'dpClosed',
		function(e, selected)
		{
			updateSelects(selected[0]);
		}
	);
	
var updateSelects = function (selectedDate)
{
	var selectedDate = new Date(selectedDate);
	$('#d2 option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
	$('#m2 option[value=' + (selectedDate.getMonth()+1) + ']').attr('selected', 'selected');
	$('#y2 option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
}
// listen for when the selects are changed and update the picker
$('#d2, #m2, #y2')
	.bind(
		'change',
		function()
		{
			var d = new Date(
						$('#y2').val(),
						$('#m2').val()-1,
						$('#d2').val()
					);
			$('#date-pick2').dpSetSelected(d.asString());
		}
	);

// default the position of the selects to today
//var today = new Date();
//updateSelects(today.getTime());

// and update the datePicker to reflect it...
//$('#d2').trigger('change');
});
</script>

<?php
//print_r($_POST);
if(isset($_POST['btnList']))
{
	$from = $_POST['y1'].'-'.$_POST['m1'].'-'.$_POST['d1'];
	$to = $_POST['y2'].'-'.$_POST['m2'].'-'.$_POST['d2'];
	//echo $from.'---'.$to;
	if($from<=$to)
	{
		$resReport = $mydb->getQuery('*','tbl_sale','sale_date BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY id');
	} 
	else
	{
		$error = 1;
		$message = 'From date must be earlier than to date';	
	}
}
$month = array('mmm','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

if((isset($message) && !empty($message)) || (isset($_GET['message']) && !empty($_GET['message'])))
{
	if(isset($_GET['code']) && $_GET['code']==1) $ccode = 'green';
	else  $ccode = 'red';
	
	if(isset($_GET['message']) && !empty($_GET['message']))
		$message = $_GET['message'];
?>

<div id="message-<?php echo $ccode;?>" style="padding-top:10px;">
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td class="<?php echo $ccode;?>-left"><?php echo $message;?></td>
      <td class="<?php echo $ccode;?>-right"><a class="close-<?php echo $ccode;?>"><img src="images/table/icon_close_<?php echo $ccode;?>.gif"   alt="" /></a></td>
    </tr>
  </table>
</div>
<?php
}
?>

<form action="" method="post" name="frmReport">
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">
<tr>
  <th style="width:50px; min-width:50px;">From  :</th>
  <td style="width:220px; min-width: 250px;">
  <table border="0" cellpadding="0" cellspacing="0">
  <tr  valign="top">
    <td>
      <select name="d1" id="d" class="styledselect-day">
        <option value="">dd</option>
        <?php for($i=1;$i<32;$i++){?>
        <option value="<?php echo $i;?>" <?php if(isset($_POST['d1']) && $_POST['d1']==$i) echo 'selected';?>><?php echo $i;?></option>
        <?php } ?>
      </select>
      </td>
      <td><select name="m1" id="m" class="styledselect-month">
          <?php for($i=0;$i<count($month);$i++){?>
          <option value="<?php echo $i;?>" <?php if(isset($_POST['m1']) && $_POST['m1']==$i) echo 'selected';?>><?php echo $month[$i];?></option>
          <?php } ?>
        </select></td>
      <td><select name="y1" id="y"  class="styledselect-year">
          <option value="">yyyy</option>
          <?php
		  $y = date('Y');
		  for($i = $y-10;$i<=$y;$i++)
		  {
		  ?>
          <option value="<?php echo $i;?>" <?php if(isset($_POST['y1']) && $_POST['y1']==$i) echo 'selected';?>><?php echo $i;?></option>
          <?php } ?>
        </select>
    </td>
    <td><a href=""  id="date-pick"><img src="images/forms/icon_calendar.jpg"   alt="" /></a></td>
  </tr>
</table></td>
  <th style="width:50px; min-width: 50px;">To  :</th>
  <td style="width:220px; min-width: 250px;"><table border="0" cellpadding="0" cellspacing="0">
  <tr  valign="top">
    <td>
      <select name="d2" id="d2" class="styledselect-day">
        <option value="">dd</option>
        <?php for($i=1;$i<32;$i++){?>
        <option value="<?php echo $i;?>" <?php if(isset($_POST['d2']) && $_POST['d2']==$i) echo 'selected';?>><?php echo $i;?></option>
        <?php } ?>
      </select>
      </td>
      <td><select name="m2" id="m2" class="styledselect-month">
          <?php for($i=0;$i<count($month);$i++){?>
          <option value="<?php echo $i;?>" <?php if(isset($_POST['m2']) && $_POST['m2']==$i) echo 'selected';?>><?php echo $month[$i];?></option>
          <?php } ?>
        </select></td>
      <td><select name="y2" id="y2"  class="styledselect-year">
          <option value="">yyyy</option>
          <?php
		  $y = date('Y');
		  for($i = $y-10;$i<=$y;$i++)
		  {
		  ?>
          <option value="<?php echo $i;?>" <?php if(isset($_POST['y2']) && $_POST['y2']==$i) echo 'selected';?>><?php echo $i;?></option>
          <?php } ?>
        </select>
    </td>
    <td><a href=""  id="date-pick2"><img src="images/forms/icon_calendar.jpg"   alt="" /></a></td>
  </tr>
</table></td>
  <td><input name="btnList" id="btnList" type="submit" value="List" class="button" /></td>
</tr>
</table>
</form>

<?php
//print_r($_POST);
if(isset($_POST['btnList']) && !isset($error))
{
?>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class="product-table">
    <tr class="no-hover">
      <th class="table-header-check">S.N </th>
      <th class="table-header-repeat line-left minwidth-1">Sold Date</th>
      <th class="table-header-repeat line-left">Service Type</th>
      <th class="table-header-repeat line-left minwidth-1">Name</th>
      <th class="table-header-repeat line-left">Quantity</th>
      <th class="table-header-repeat line-left align-right">Amount</th>
      <th class="table-header-repeat line-left minwidth-1">Sold By</th>
      <th class="table-header-options line-left">Remarks</th>
    </tr>
    <?php
    $counter = 0;
    while($rasReport = $mydb->fetch_array($resReport))
    {
    ?>
    <tr>
      <td style="text-align:center"><?php echo ++$counter;?></td>
      <td><?php echo stripslashes($rasReport['sale_datetime']);?></td>
      <td><?php echo $rasReport['saletype'];?></td>
      <td><?php echo stripslashes($mydb->getValue('name','tbl_product','id='.$rasReport['pid']));?></td>
      <td><?php echo stripslashes($rasReport['quantity']);?></td>
      <td class="price">Rs. <?php echo $rasReport['saleprice'];?></td>
      <td><?php echo stripslashes($mydb->getValue('title','tbl_admin','id='.$rasReport['sold_by']));?></td>
      <td class="options-width"><?php echo $rasReport['remarks'];?></td>
    </tr>
    <?php
    }
    ?>
  </table>
<?php
}
?>