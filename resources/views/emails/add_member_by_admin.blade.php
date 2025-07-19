<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CodeGraphi Account Details</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap');
		body {
			font-family: 'Manrope', sans-serif;
			background-color: #ffffff;
			margin: 0;
			padding: 0;
		}
		.container {
			max-width: 600px;
			margin: 20px auto;
			border: 1px solid #F0F0F0;
			padding: 20px;
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
			border-radius: 10px;
		}
		.header, .footer {
			text-align: center;
			padding: 15px 0;
			background-color: #4CAF50;
			color: white;
			font-size: 20px;
			font-weight: 700;
			border-radius: 10px 10px 0 0;
		}
		.footer {
			font-size: 14px;
			border-radius: 0 0 10px 10px;
		}
		.content {
			padding: 20px;
			text-align: center;
		}
		.user-info {
			background-color: #F9F9F9;
			padding: 15px;
			border-radius: 8px;
			margin: 15px 0;
		}
		.info-item {
			font-size: 16px;
			font-weight: 500;
			margin: 5px 0;
		}
		.highlight {
			color: #4CAF50;
			font-weight: 700;
		}
		.note {
			font-size: 14px;
			color: #FF0000;
			font-weight: 600;
			margin-top: 15px;
		}
		@media screen and (max-width: 600px) {
			.container {
				width: 90%;
				padding: 15px;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">Welcome to CodeGraphi</div>
		<div class="content">
			<p>Dear <b class="highlight">{{ $name }}</b>,</p>
			<p>Your account has been successfully created. Below are your credentials:</p>
			
			<div class="user-info">
				<p class="info-item">
					{{ $role == 'Retailer' ? 'Retailer ID' : ($role == 'distributor' ? 'Distributor ID' : 'User ID') }}: 
					<b class="highlight">{{ $user_id }}</b>
				</p>
				<p class="info-item">Phone: <b class="highlight">{{ $phone }}</b></p>
				<p class="info-item">Password: <b class="highlight">{{ $password }}</b></p>
			</div>
			
			<p>Please keep this information safe and do not share it with anyone.</p>
			<p class="note">If you did not request this, please contact our support team immediately.</p>
		</div>
		<div class="footer">Thanks, CodeGraphi Team</div>
	</div>
</body>
</html>
