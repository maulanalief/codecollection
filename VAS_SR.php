<?php

	// include '/app/htdocs/config_ijep.php';
    // $conn=OCILogon($dbuser,$dbpass,$dbconn); 
	 include '/app/htdocs/config.php';
     $conn=OCILogon($user_occ,$user_pass,$ser_OCC); 
	include "tempMaster.php";
    //include "dbConnEHF.php";
	
	
	if(!$conn) {
		echo "Connection Failed".
		var_dump( OCIError() );
	}
	
	//$tgl
	$time = date('Y-m-d H:00:00', strtotime ('+1 day'));
	$tgl = date('Y-m-d'); 
	$dt = date('dmY');	
#	$tgl = date('dmy');
	$PARTISI = "PART_".$tgl;
	
if(isset($_POST['submit']))
{

	if( $_POST[start_date]=="" && $_POST[end_date]=="" ) 
	{
		echo "START DATE or END DATE is EMPTY please fill correct value !!!";
	}
	else
	{
		if ( $_POST[period]=="MINWISE" ) {
			$prd="to_char(DATE_TIME,'YYYY-MM-DD HH24:MI')";
			$clause="where a.date_time between to_date('".$_POST[start_date]."'||'000000','DDMMYYYYHH24MISS') and to_date('".$_POST[end_date]."'||'235959','DDMMYYYYHH24MISS')";
					
		}
		elseif ( $_POST[period]=="HOURWISE" ) {
			$prd="to_char(DATE_TIME,'YYYY-MM-DD HH24')";
			$clause="where a.date_time between to_date('".$_POST[start_date]."'||'000000','DDMMYYYYHH24MISS') and to_date('".$_POST[end_date]."'||'235959','DDMMYYYYHH24MISS')";
			
		}
		elseif ( $_POST[period]=="DAYWISE" ) {
			$prd="to_char(DATE_TIME,'YYYY-MM-DD')";
			$clause="where a.date_time between to_date('".$_POST[start_date]."'||'000000','DDMMYYYYHH24MISS') and to_date('".$_POST[end_date]."'||'235959','DDMMYYYYHH24MISS')";
			
		}		
		else {	
			$prd="to_char(DATE_TIME,'YYYY-MM-DD HH24:MI')";
			$clause="where a.date_time between to_date('".$_POST[start_date]."'||'000000','DDMMYYYYHH24MISS') and to_date('".$_POST[end_date]."'||'235959','DDMMYYYYHH24MISS')";

		}
	}	
}
else
{
	$prd="to_char(DATE_TIME,'YYYY-MM-DD HH24:MI')";
	$clause="where a.date_time between to_date('".$dt."'||'000000','DDMMYYYYHH24MISS') and to_date('".$dt."'||'235959','DDMMYYYYHH24MISS')";
}	
	
	
	$sql = "select a.time,a.req,a.sc,a.bf,a.sf, round ((req-sf)/req *100,2) SR from (
SELECT ".$prd." TIME,SERVICE_NAME,SERVICE_TYPE,sum(request) req,sum(success) sc,sum(BUSSINESS_FAILURE) bf,sum(SYSTEM_FAILURE) sf
FROM OPS_VAS_SUCCESS_RATE@OCC_TO_EHFDB a
--where DATE_TIME >= trunc(sysdate)
".$clause."
and service_name='ETOPUP'
group by ".$prd.",SERVICE_NAME,SERVICE_TYPE
ORDER BY 1 desc
) a 
--where ROWNUM <=150
";

	$pars = OCIParse($conn, $sql);
	OCIExecute($pars);

	$sql1 = "select a.time,a.req,a.sc,a.bf,a.sf, round ((req-sf)/req *100,2) SR from (
SELECT ".$prd." TIME,SERVICE_NAME,SERVICE_TYPE,sum(request) req,sum(success) sc,sum(BUSSINESS_FAILURE) bf,sum(SYSTEM_FAILURE) sf
FROM OPS_VAS_SUCCESS_RATE@OCC_TO_EHFDB a
--where DATE_TIME >= trunc(sysdate)
".$clause."
and service_name='VTOPUP'
group by ".$prd.",SERVICE_NAME,SERVICE_TYPE
ORDER BY 1 desc
) a 
--where ROWNUM <=150
";

	$pars1 = OCIParse($conn, $sql1);
	OCIExecute($pars1);

	$sql2 = "select a.time,a.req,a.sc,a.bf,a.sf, round ((req-sf)/req *100,2) SR from (
SELECT ".$prd." TIME,SERVICE_NAME,SERVICE_TYPE,sum(request) req,sum(success) sc,sum(BUSSINESS_FAILURE) bf,sum(SYSTEM_FAILURE) sf
FROM OPS_VAS_SUCCESS_RATE@OCC_TO_EHFDB a
--where DATE_TIME >= trunc(sysdate)
".$clause."
and service_name='PACKAGE_REGISTRATION'
group by ".$prd.",SERVICE_NAME,SERVICE_TYPE
ORDER BY 1 desc
) a 
--where ROWNUM <=150
";

	$pars2 = OCIParse($conn, $sql2);
	OCIExecute($pars2);

	$sql3 = "select a.time,a.req,a.sc,a.bf,a.sf, round ((req-sf)/req *100,2) SR from (
SELECT ".$prd." TIME,SERVICE_NAME,SERVICE_TYPE,sum(request) req,sum(success) sc,sum(BUSSINESS_FAILURE) bf,sum(SYSTEM_FAILURE) sf
FROM OPS_VAS_SUCCESS_RATE@OCC_TO_EHFDB a
--where DATE_TIME >= trunc(sysdate)
".$clause."
and service_name='SIM_ACTIVATION'
group by ".$prd.",SERVICE_NAME,SERVICE_TYPE
ORDER BY 1 desc
) a 
--where ROWNUM <=150
";

	$pars3 = OCIParse($conn, $sql3);
	OCIExecute($pars3);
	
	$sql4 = "select a.time,a.req,a.sc,a.bf,a.sf, round ((req-sf)/req *100,2) SR from (
SELECT ".$prd." TIME,SERVICE_NAME,SERVICE_TYPE,sum(request) req,sum(success) sc,sum(BUSSINESS_FAILURE) bf,sum(SYSTEM_FAILURE) sf
FROM OPS_VAS_SUCCESS_RATE@OCC_TO_EHFDB a
--where DATE_TIME >= trunc(sysdate)
".$clause."
and service_name='FRC_ONLINE'
group by ".$prd.",SERVICE_NAME,SERVICE_TYPE
ORDER BY 1 desc
) a 
--where ROWNUM <=150
";

	$pars4 = OCIParse($conn, $sql4);
	OCIExecute($pars4);
	
	$sql5 = "select a.time,a.req,a.sc,a.bf,a.sf, round ((req-sf)/req *100,2) SR from (
SELECT ".$prd." TIME,SERVICE_NAME,SERVICE_TYPE,sum(request) req,sum(success) sc,sum(BUSSINESS_FAILURE) bf,sum(SYSTEM_FAILURE) sf
FROM OPS_VAS_SUCCESS_RATE@OCC_TO_EHFDB a
--where DATE_TIME >= trunc(sysdate)
".$clause."
and service_name='SPV_ONLINE'
group by ".$prd.",SERVICE_NAME,SERVICE_TYPE
ORDER BY 1 desc
) a 
--where ROWNUM <=150
";

	$pars5 = OCIParse($conn, $sql5);
	OCIExecute($pars5);	

	$sqlNG_PULSA_TOPUP = "select a.time,a.req,a.sc,a.bf,a.sf, round ((req-sf)/req *100,2) SR from (
SELECT ".$prd." TIME,SERVICE_NAME,SERVICE_TYPE,sum(request) req,sum(success) sc,sum(BUSSINESS_FAILURE) bf,sum(SYSTEM_FAILURE) sf
FROM OPS_VAS_SUCCESS_RATE@OCC_TO_EHFDB a
--where DATE_TIME >= trunc(sysdate)
".$clause."
and service_name='NG_PULSA_TOPUP'
and request <> 0
group by ".$prd.",SERVICE_NAME,SERVICE_TYPE
ORDER BY 1 desc
) a 
--where ROWNUM <=150
";

	$parsNG_PULSA_TOPUP = OCIParse($conn, $sqlNG_PULSA_TOPUP);
	OCIExecute($parsNG_PULSA_TOPUP);	
	
	?>
<?php 

function generate_value($error_value, $server_name, $time) {
	$error_value = $error_value;
	$server_name = $server_name;
	$time = $time;

        if ( $server_name == 'SR' && $error_value < 96 ) {
                $class_value = "class = bg-danger";
        }
	else if ( $server_name == 'SR' && $error_value >= 96 && $error_value < 99) { 
		$class_value = "class = bg-warning"; 
	} 
        else if ( $server_name == 'SR' && $error_value >= 99) {
        	$class_value = "class = bg-success";
        }
        else if ( $server_name == 'SF' && $error_value >= 5) {
                $class_value = "class = bg-danger";
        }
        else if ( $server_name == 'SF' && $error_value > 0 && $error_value < 5) {  
                $class_value = "class = bg-warning"; 
        }
        else if ( $server_name == 'SF' && $error_value == 0) {
                $class_value = "class = bg-success";
        }
        else if ( $server_name == 'BF' && $error_value >= 10) {
                $class_value = "class = bg-warning";
        }
        else if ( $server_name == 'BF' && $error_value == 0) {
                $class_value = "class = bg-success";
        }
        else if ( $server_name == 'REQ' && $error_value == 0) {
                $class_value = "class = bg-danger";
        }
        else if ( $server_name == 'SC' && $error_value == 0) {
                $class_value = "class = bg-danger";
        }
        else if ( $server_name == 'SC' && $error_value > 0) {
                $class_value = "class = bg-success";
        }
        else if ( $server_name == 'AVG_DUR' && $error_value >= 30000) {
                $class_value = "class = bg-danger";
        }		
        else if ( $server_name == 'MAX_DUR' && $error_value >= 30000) {
                $class_value = "class = bg-danger";
        }	
        else if ( $server_name == 'AVG_DUR' && $error_value >= 10000 && $error_value < 30000) {
                $class_value = "class = bg-warning";
        }		
        else if ( $server_name == 'MAX_DUR' && $error_value >= 10000 && $error_value < 30000) {
                $class_value = "class = bg-warning";
        }			
	else {
		$class_value = "class = bg-light"; 
	}

	if ($error_value < 100 && $server_name == 'SR' ) {
		$concat = "${server_name}|$time";
		$line = "<input type=\"radio\" name=\"command_detail\" value=\"". $concat  ."\"><font color=\"black\">". $error_value ."</font></input>";
		#$line = "<input type=\"text\" name=\"command_detail\" value=\"". $concat  ."\"><font color=\"black\">". $error_value ."</font></input>";
		#$line = $line_1 + $line_2;
		echo "<td ". $class_value ."><div align=\"center\">". $error_value ." </div></td>";
	} 
	else {
		$line = "<font color=black>". $error_value ."</font>"; 
		echo "<td ". $class_value ."><div align=\"center\"> ". $line ." </div></td>";
	}

	#echo "<td ". $class_value ."><div align=\"center\"> ". $line ." </div></td>";
}

?>

<!--<meta http-equiv="refresh" content="60">-->
<link href="css/styles_vhub.css" rel="stylesheet" type="text/css"  /> 
<link ref="css/component/calendar/dhtmlgoodies_calendar.css?random=20051112" rel="stylesheet" h media="screen"></LINK>
<link rel="stylesheet" type="text/css" href="../joy/plugins/bootstrap/css/bootstrap.min.css" />
<!--<link rel="stylesheet" href="../joy/new_table/css/master.css" />-->
<SCRIPT type="text/javascript" src="css/component/calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

<html>

<head>
        <title>VAS SR</title>
</head>

<body>

<div id="leftside">
   <div class="cLeft">
		<fieldset class="adminformnew">
			<legend>VAS SUCCESS RATE</legend>	

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table> 
    <tr>

		<td><b>PERIOD  : </b> </td>
		<td><select name="period">
		<option value="MINWISE" >Minute</option>
		<option value="HOURWISE" >Hourly</option>
		<option value="DAYWISE" >Daily</option>
		</select>
		</td>
	</tr>
 <tr>
   	 <td><b>START DATE  (DDMMYYYY) : </b></td>
         <td><input type="text" onfocus="this.value=''" autocomplete="off" name="start_date" value="<?php echo ""; ?>" onClick="displayCalendar(start_date,'ddmmyyyy',this)"><br></td> 

    </tr>
    <tr>
         <td><b>END DATE  (DDMMYYYY) : </b></td>
         <td><input type="text" onfocus="this.value=''" autocomplete="off" name="end_date" value="<?php echo ""; ?>" onClick="displayCalendar(end_date,'ddmmyyyy',this)"><br></td>

    </tr>


   <tr>
   	  <td><td><input type="submit" name="submit" value="Submit Form"><br></td></td>
   </tr>
</table> 

        <div class="row h-100 justify-content-center">
                <div class="px-1">
                        <div class="card shadow-sm">
                                <div class="card-body">
                                        <p class="text-center">
                                                <font size="5" class="font-weight-bold" >ETOPUP SUCCESS RATE</font>
                                        </p>
                                        <table id="pso" class="table table-bordered text-center" border="1">
                                                <thead class="thead-dark">
                                                        <tr>
                                                                <th>TIME</th>
                                                                <th>REQ</th>
                                                                <th>SC</th>																
                                                                <th>BF</th>																
                                                                <th>SF</th>
                                                                <th>SR</th>													
                                                        </tr>
							 <? while ($res = oci_fetch_array ($pars, OCI_BOTH)){ ?>

							<tr>
							        <?php
							        generate_value($res['TIME'], 'TIME', $res['TIME']);							
						            generate_value($res['REQ'], 'REQ', $res['DATETIME']);
						            generate_value($res['SC'], 'SC', $res['DATETIME']);
							        generate_value($res['BF'], 'BF', $res['DATETIME']);							
							        generate_value($res['SF'], 'SF', $res['DATETIME']);
                                    generate_value($res['SR'], 'SR', $res['DATETIME']);								
                						?>

							</tr>

							<?php } //echo $sql;
 							?>

                                                </thead>
                                        </table>
                                </div>
                        </div>
                </div>			
                <div class="px-1">
                        <div class="card shadow-sm">
                                <div class="card-body">
                                        <p class="text-center">
                                                <font size="5" class="font-weight-bold" >VTOPUP SUCCESS RATE</font>
                                        </p>
                                        <table id="pso" class="table table-bordered text-center" border="1">
                                                <thead class="thead-dark">
                                                        <tr>
                                                                <th>TIME</th>
                                                                <th>REQ</th>
                                                                <th>SC</th>																
                                                                <th>BF</th>																
                                                                <th>SF</th>
                                                                <th>SR</th>																		
                                                        </tr>
							 <? while ($res = oci_fetch_array ($pars1, OCI_BOTH)){ ?>

							<tr>
							        <?php
							        generate_value($res['TIME'], 'TIME', $res['TIME']);							
						            generate_value($res['REQ'], 'REQ', $res['DATETIME']);
						            generate_value($res['SC'], 'SC', $res['DATETIME']);
							        generate_value($res['BF'], 'BF', $res['DATETIME']);							
							        generate_value($res['SF'], 'SF', $res['DATETIME']);
                                    generate_value($res['SR'], 'SR', $res['DATETIME']);										
                						?>

							</tr>

							<?php } //echo $sql;
 							?>

                                                </thead>
                                        </table>
                                </div>
                        </div>
                </div>		
                <div class="px-1">
                        <div class="card shadow-sm">
                                <div class="card-body">
                                        <p class="text-center">
                                                <font size="5" class="font-weight-bold" >DATA PACKAGE SUCCESS RATE</font>
                                        </p>
                                        <table id="pso" class="table table-bordered text-center" border="1">
                                                <thead class="thead-dark">
                                                        <tr>
                                                                <th>TIME</th>
                                                                <th>REQ</th>
                                                                <th>SC</th>																
                                                                <th>BF</th>																
                                                                <th>SF</th>
                                                                <th>SR</th>																		
                                                        </tr>
							 <? while ($res = oci_fetch_array ($pars2, OCI_BOTH)){ ?>

							<tr>
							        <?php
							        generate_value($res['TIME'], 'TIME', $res['TIME']);							
						            generate_value($res['REQ'], 'REQ', $res['DATETIME']);
						            generate_value($res['SC'], 'SC', $res['DATETIME']);
							        generate_value($res['BF'], 'BF', $res['DATETIME']);							
							        generate_value($res['SF'], 'SF', $res['DATETIME']);
                                    generate_value($res['SR'], 'SR', $res['DATETIME']);										
                						?>

							</tr>

							<?php } //echo $sql;
 							?>

                                                </thead>
                                        </table>
                                </div>
                        </div>
                </div>	
                <div class="px-1">
                        <div class="card shadow-sm">
                                <div class="card-body">
                                        <p class="text-center">
                                                <font size="5" class="font-weight-bold" >SIM ACTIVATION SUCCESS RATE</font>
                                        </p>
                                        <table id="pso" class="table table-bordered text-center" border="1">
                                                <thead class="thead-dark">
                                                        <tr>
                                                                <th>TIME</th>
                                                                <th>REQ</th>
                                                                <th>SC</th>																
                                                                <th>BF</th>																
                                                                <th>SF</th>
                                                                <th>SR</th>																		
                                                        </tr>
							 <? while ($res = oci_fetch_array ($pars3, OCI_BOTH)){ ?>

							<tr>
							        <?php
							        generate_value($res['TIME'], 'TIME', $res['TIME']);							
						            generate_value($res['REQ'], 'REQ', $res['DATETIME']);
						            generate_value($res['SC'], 'SC', $res['DATETIME']);
							        generate_value($res['BF'], 'BF', $res['DATETIME']);							
							        generate_value($res['SF'], 'SF', $res['DATETIME']);
                                    generate_value($res['SR'], 'SR', $res['DATETIME']);										
                						?>

							</tr>

							<?php } //echo $sql;
 							?>

                                                </thead>
                                        </table>
                                </div>
                        </div>
                </div>			
                <div class="px-1">
                        <div class="card shadow-sm">
                                <div class="card-body">
                                        <p class="text-center">
                                                <font size="5" class="font-weight-bold" >FRC ONLINE SUCCESS RATE</font>
                                        </p>
                                        <table id="pso" class="table table-bordered text-center" border="1">
                                                <thead class="thead-dark">
                                                        <tr>
                                                                <th>TIME</th>
                                                                <th>REQ</th>
                                                                <th>SC</th>																
                                                                <th>BF</th>																
                                                                <th>SF</th>
                                                                <th>SR</th>																		
                                                        </tr>
							 <? while ($res = oci_fetch_array ($pars4, OCI_BOTH)){ ?>

							<tr>
							        <?php
							        generate_value($res['TIME'], 'TIME', $res['TIME']);							
						            generate_value($res['REQ'], 'REQ', $res['DATETIME']);
						            generate_value($res['SC'], 'SC', $res['DATETIME']);
							        generate_value($res['BF'], 'BF', $res['DATETIME']);							
							        generate_value($res['SF'], 'SF', $res['DATETIME']);
                                    generate_value($res['SR'], 'SR', $res['DATETIME']);										
                						?>

							</tr>

							<?php } //echo $sql;
 							?>

                                                </thead>
                                        </table>
                                </div>
                        </div>
                </div>	
                <div class="px-1">
                        <div class="card shadow-sm">
                                <div class="card-body">
                                        <p class="text-center">
                                                <font size="5" class="font-weight-bold" >SPV ONLINE SUCCESS RATE</font>
                                        </p>
                                        <table id="pso" class="table table-bordered text-center" border="1">
                                                <thead class="thead-dark">
                                                        <tr>
                                                                <th>TIME</th>
                                                                <th>REQ</th>
                                                                <th>SC</th>																
                                                                <th>BF</th>																
                                                                <th>SF</th>
                                                                <th>SR</th>																		
                                                        </tr>
							 <? while ($res = oci_fetch_array ($pars5, OCI_BOTH)){ ?>

							<tr>
							        <?php
							        generate_value($res['TIME'], 'TIME', $res['TIME']);							
						            generate_value($res['REQ'], 'REQ', $res['DATETIME']);
						            generate_value($res['SC'], 'SC', $res['DATETIME']);
							        generate_value($res['BF'], 'BF', $res['DATETIME']);							
							        generate_value($res['SF'], 'SF', $res['DATETIME']);
                                    generate_value($res['SR'], 'SR', $res['DATETIME']);										
                						?>

							</tr>

							<?php } //echo $sql;
 							?>

                                                </thead>
                                        </table>
                                </div>
                        </div>
                </div>	
                <div class="px-1">
                        <div class="card shadow-sm">
                                <div class="card-body">
                                        <p class="text-center">
                                                <font size="5" class="font-weight-bold" >NG PULSA TOPUP SUCCESS RATE</font>
                                        </p>
                                        <table id="pso" class="table table-bordered text-center" border="1">
                                                <thead class="thead-dark">
                                                        <tr>
                                                                <th>TIME</th>
                                                                <th>REQ</th>
                                                                <th>SC</th>																
                                                                <th>BF</th>																
                                                                <th>SF</th>
                                                                <th>SR</th>																		
                                                        </tr>
							 <? while ($res = oci_fetch_array ($parsNG_PULSA_TOPUP, OCI_BOTH)){ ?>

							<tr>
							        <?php
							        generate_value($res['TIME'], 'TIME', $res['TIME']);							
						            generate_value($res['REQ'], 'REQ', $res['DATETIME']);
						            generate_value($res['SC'], 'SC', $res['DATETIME']);
							        generate_value($res['BF'], 'BF', $res['DATETIME']);							
							        generate_value($res['SF'], 'SF', $res['DATETIME']);
                                    generate_value($res['SR'], 'SR', $res['DATETIME']);										
                						?>

							</tr>

							<?php } //echo $sql;
 							?>

                                                </thead>
                                        </table>
                                </div>
                        </div>
                </div>
				
	</div>

</form>

</body>
</html>
