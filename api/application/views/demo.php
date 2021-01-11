<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>A simple, clean, and responsive HTML invoice template</title>

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


			<tr class="information">
				<td colspan="4">
					<table>
						<tr>
		<!-- 					<td>
								Sparksuite, Inc.<br>
								12345 Sunny Road<br>
								Sunnyville, CA 12345
							</td> -->

							<?php
							echo "<td>".$customer->customer_billing_name."<br>";
							echo $customer->customer_address."<br>";
							echo $customer->customer_mobile_no."<br>";
							echo "</td>";
							?> 

						</tr>
					</table>
				</td>
			</tr>



			<tr class="heading">
				<td>
					Item
				</td>

				<td>
					Price
				</td>
				
				<td>
					Kilogram
				</td>
				<td>
					Total
				</td>
			</tr>


			<?php
			$total=0;
			foreach($utility_array as $row)
			{
				echo "<tr class='item'>";
				echo "<td>".$row['product_name']."</td>";
				echo "<td>".'₹'.(int)$row['product_cost']."</td>";
				echo "<td>".$row['product_stock_kg'].'Kg'."</td>";
				echo "<td>".'₹'.(int)$row['product_total_cost']."</td>";
				echo "</tr>";
				$total+= (int)$row['product_total_cost'];
			}
			echo "<tr class='total'>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "<td>".'Total:'.'₹'.$total."</td>";
			echo "</tr>";
			?>

		</table>
		<button onclick="convert_HTML_To_PDF()" id="cmd">generate PDF</button>
	</div>
</body>
</html>