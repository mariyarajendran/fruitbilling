<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bill Sheet</title>

	<style>

		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th {

			text-align: left;
			padding: 8px;
		}



		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 30px;
			border: 1px solid #eee;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
			font-size: 16px;
			line-height: 24px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
		}

		.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
		}

		.invoice-box table td {
			padding: 5px;
			vertical-align: top;
		}

		.invoice-box table tr td:nth-child(4) {
			text-align: right;
		}

		.invoice-box table tr.top table td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
		}

		.invoice-box table tr.information table td {
			padding-bottom: 40px;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #ddd;
			font-weight: bold;
		}

		.invoice-box table tr.details td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.item td{
			border-bottom: 1px solid #eee;
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:nth-child(2) {
			border-top: 2px solid #eee;
			font-weight: bold;
		}

		table tr:not(:last-child) td:first-child::first-letter {
			text-transform: capitalize;
		}

		@media only screen and (max-width: 600px) {
			.invoice-box table tr.top table td {
				width: 100%;
				display: block;
				text-align: center;
			}

			.invoice-box table tr.information table td {
				width: 100%;
				display: block;
				text-align: center;
			}
		}

		/** RTL **/
		.rtl {
			direction: rtl;
			font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		}

		.rtl table {
			text-align: right;
		}

		.rtl table tr td:nth-child(4) {
			text-align: left;
		}




	</style>
</head>

<body>
	<div class="invoice-box" id="content">
		<table cellpadding="0" cellspacing="0">
			<p>
				<script> document.write(new Date().toLocaleDateString()); </script>
			</p>

			<tr class="heading">
				<td colspan="4">
					<table>
						
						<tr>
							<?php
							echo "<td>".'ஆர்டர் ஐடி'.": ".'#'.$orderId."<br>";
							echo 'வாடிக்கையாளர் பெயர்'.": ".$customer->customer_billing_name."<br>";
							echo 'முகவரி'.": ".$customer->customer_address."<br>";
							echo 'அலைபேசி எண்'.": ".$customer->customer_mobile_no."<br>";
							echo "</td>";
							?> 

						</tr>
					</table>
				</td>
			</tr>



			<tr class="heading">
				<td>
					பொருள்
				</td>

				<td>
					விலை
				</td>
				
				<td>
					கிலோகிராம் / பெட்டி
				</td>
				<td>
					மொத்தம்
				</td>
			</tr>


			<?php
			$total=0;
			foreach($utility_array as $row)
			{
				echo "<tr class='item'>";
				echo "<td>".$row['product_name']."</td>";
				echo "<td>".'₹'.(int)$row['product_cost']."</td>";
				if($row['purchase_box_flag']){
					echo "<td>".$row['product_stock_kg'].' பெட்டி'."</td>";
				}else{
					echo "<td>".$row['product_stock_kg'].' கிலோ'."</td>";
				}
				echo "<td>".'₹'.(int)$row['product_total_cost']."</td>";
				echo "</tr>";
				$total+= (int)$row['product_total_cost'];
			}
			echo "<tr class='total'>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "<td>".'மொத்தம்:'.'₹'.$total."</td>";
			echo "</tr>";
			?>

		</table>
	</div>






	<div class="invoice-box" id="content">
		<table cellpadding="0" cellspacing="0">

			<tr class="heading">
				<td>
					முந்தையது
				</td>

				<td>
					பெறப்பட்டது
				</td>
				
				<td>
					நிலுவையில் உள்ளது
				</td>
				<td>
					தேதி
				</td>
			</tr>


			<?php
			//$total=0;
			foreach($pending_reports as $row)
			{
				echo "<tr class='item'>";
				echo "<td>".'₹'.$row['order_summary_pending_amount']."</td>";
				echo "<td>".'₹'.(int)$row['order_pending_history_received']."</td>";
				echo "<td>".'₹'.$row['order_pending_history_pending']."</td>";
				echo "<td>".$row['order_pending_history_date']."</td>";
				echo "</tr>";
				//$total+= (int)$row['product_total_cost'];
			}
			echo "<tr class='total'>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "</tr>";
			?>

		</table>
	</div>


</body>
</html>