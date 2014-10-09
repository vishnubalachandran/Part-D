<HTML>
<body>
<style>
			table, td, tr{
				border: 1px SOLID #848484;
			}

			tr {
				padding: 15px;
				background-color: #848484;
				color: white;
			}
			td {
				padding: 15px;
				 background-color: #848484;
			}

</style>
<BR/>
<BR/>
<?php

		
		set_include_path('C:\wamp\bin\php\php5.5.12\pear');
        require_once "HTML/Template/IT.php";
        require "db2.inc";
		
		$tpl = new HTML_Template_IT(".");
		$tpl->loadTemplatefile("Pear_Question.tpl", true, true);

		  if (!($connection = @ mysql_connect($hostName, $username, $password)))
			 die("Cannot connect");

		  if (!(mysql_select_db($databaseName, $connection)))
			 showerror();

		  if (!($regionresult = @ mysql_query ("SELECT region_name FROM   region",
											   $connection)))
			 showerror();	

		
		
	    echo'<form name ="FORM1" action="Answer.php" method="get">';
	
	    echo '<center><table>';
	     //Question 1 
		echo '<tr>';
		
	    echo '<td>'; echo 'WINE NAME';  echo '</td>';
		echo '<td>';  echo '<INPUT TYPE = "TEXT" NAME ="WINENAME" width = "50px"/>';echo '</td>';
	    echo '</tr>';
	    //echo '<br/>';
	
     	//Question 2
	    echo '<tr>';
		echo '<td>'; echo 'REGION';	echo '</td>';
		echo '<td>'; 
		//echo'<select name="region">';

						while($row=mysql_fetch_array($regionresult))
						 { $tpl->setCurrentBlock("REGION");
							
							$tpl->setVariable("region_name",$row["region_name"]);
							
							
						 
							$tpl->parseCurrentBlock();
						   
						   
						 
							
						}
						
						
						$tpl->show();
					echo'</select>';
		echo '</td>';
        echo '</tr>';
        
		//Question 3
		
		echo '<tr>';
		echo '<td>';echo 'WINERY NAME'; echo '</td>';
		echo '<td>';echo  '<INPUT TYPE = "TEXT" NAME ="WINERY_NAME">';echo '</td>';
		 echo '</tr>';
		
		//Question 4
		
		echo '<tr>';
		echo '<td>';echo 'START YEAR  ';

		echo '<INPUT TYPE = "TEXT" NAME ="years1">'; echo '</td>';
		echo '<td>'; echo 'END YEAR  '; echo '<INPUT TYPE = "TEXT" NAME ="years2">';
		echo '</td>';
		 echo '</tr>';

		//Question 5 
			echo '<tr>';
		echo '<td>';echo 'MIN NUMBER OF WINES';echo '</td>';
		echo '<td>';echo '<INPUT TYPE = "TEXT" NAME ="min_wine">';echo '</td>';
		 echo '</tr>';
		
		//Question 6
		echo '<tr>';
		echo '<td>';echo 'MIN NUMBER OF CUSTOMERS :'; echo '</td>';
		echo '<td>';echo '<INPUT TYPE = "TEXT" NAME ="MIN_CUST">';	echo '</td>';	
		 echo '</tr>';
		
		
		//question 7
		echo '<tr>';
		echo '<td>';echo 'MIN COST : <INPUT TYPE = "TEXT" NAME ="min_cost">';echo '</td>';
		echo '<td>';echo 'MAX COST : <INPUT TYPE = "TEXT" NAME ="max_cost">';echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td COLSPAN="2">';
		echo '<CENTER>
		<input type="submit"  VALUE ="SEARCH" style="color:#842DCE;
											   font-family:Andalus;
											   font-size:20pt;  
											  border-color:#842DCE;	  
											  border-style:dashed; 
											  background-color:#000000;
											   border-width:1;
											   border-style:dashed;
       
												margin-top:7px;"/>
		</CENTER>';
		echo '</td>';	
		 echo '</tr>';
 echo '</table></center>';
 echo '</form>';
//mysqli_close();
?>
