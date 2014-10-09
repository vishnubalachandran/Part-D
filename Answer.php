<?PHP
echo "</br>";
echo "</br>";
echo "</br>";

?>
<html>
<body background="black-floor.jpg">
<a href="index.php"> go back </a>
<br>
<style>
		table, td, th {
			border: 1px  #848484;
		}

		th {
			padding: 15px;
			background-color: #848484;
			color: white;
		}
		td {
			padding: 15px;
			 background-color: #848484;
		}
</style>
<?php
	     
   $wine_name_search=$_GET["WINENAME"];
		$region_search=$_GET["region"];
		$winery_search=$_GET["WINERY_NAME"];
		$year1=$_GET["years1"];
		$year2=$_GET["years2"];
		$min_wine_search=$_GET["min_wine"];
		$min_cust=$_GET["MIN_CUST"];
		$min_cost=$_GET["min_cost"];
		$max_cost=$_GET["max_cost"];
		
		
		if ($year1 == NULL)
			$year1 = "1970";
		
		if ($year2 == NULL)
			$year2 = "1999";
		if($region_search == "All")
			$region_search = "";	
			
		if ($min_wine_search== NULL)
			$min_wine_search = "0";
			
		if ($min_cost == NULL)
			$min_cost = "5";
		
		if ($max_cost == NULL)
			$max_cost = "30";
			
		if (($max_cost != NULL) && ($min_cost != NULL) && ($max_cost<$min_cost))
		{
		    echo '<font color = "white">';
		    ECHO "Maximum cost should be greater than Minimum cost";
			echo '</font>';
		}
		if ($min_cust == NULL)
		   $min_cust = "0";

		   
		set_include_path('C:\wamp\bin\php\php5.5.12\pear');
		require_once "HTML/Template/IT.php";
        require "db2.inc";
		
		
		$tpl = new HTML_Template_IT(".");
		$tpl->loadTemplatefile("Pear_Answer.tpl", true, true);

		  if (!($connection = @ mysql_connect($hostName, $username, $password)))
			 die("Cannot connect");

		  if (!(mysql_select_db($databaseName,$connection)))
		   showerror();
		   
  
		
   
  if (!($result = @ mysql_query ("SELECT 	wine_name,
					   (SELECT variety FROM grape_variety where grape_variety.variety_id = wine_variety.variety_id) AS variety,
						winery_name,
						year,
						region_name,
                       (SELECT MIN(cost) FROM inventory WHERE inventory.wine_id = wine.wine_id) AS cost,
					   (SELECT COUNT(orders.cust_id) FROM orders WHERE orders.order_id = items.order_id and items.wine_id = wine.wine_id) AS num_customers,
					   inventory.on_hand as stock
						
					   
						
				FROM   wine 
				INNER JOIN winery ON wine.winery_id = winery.winery_id
				INNER JOIN region on winery.region_id = region.region_id
                INNER JOIN wine_variety on wine.wine_id = wine_variety.wine_id
				LEFT OUTER JOIN items on wine.wine_id = items.wine_id
				INNER JOIN inventory ON wine.wine_id = inventory.wine_id
				
				
				
				
				WHERE (wine.wine_name LIKE '%$wine_name_search%')
						AND (region.region_name LIKE '%$region_search%')
						AND (winery.winery_name LIKE '%$winery_search%')
						AND(year BETWEEN $year1 AND $year2)
						AND ( inventory.on_hand >= $min_wine_search )
						AND (inventory.cost>$min_cost and inventory.cost<$max_cost)",
                                       $connection)))
			showerror();
   
 
		

			
		
		if(mysql_num_rows($result) >0)  //This will shows if the query results any rows
		{
       
			while($row=mysql_fetch_array($result))
			{ 
			$tpl->setCurrentBlock("Results");
			$tpl->setVariable("wine_name",$row["wine_name"]);
			$tpl->setVariable("region_name",$row["region_name"]);
			$tpl->setVariable("winery_name",$row["winery_name"]);
			$tpl->setVariable("year",$row["year"]);
			$tpl->setVariable("variety",$row["variety"]);
			$tpl->setVariable("cost",$row["cost"]);
			$tpl->setVariable("stock",$row["stock"]);
			$tpl->setVariable("num_customers",$row["num_customers"]);
								
			$tpl->parseCurrentBlock();
			  
			}
		$tpl->show();
       // echo '</table></center>';
		
	}
	else
	{
	    echo '<br/>';
		echo '<font color="white">';
		echo "No records match your search criteria";
		echo '</font>';
	}

//mysql_close();


?>

</body>
</html>