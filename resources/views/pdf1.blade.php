<!DOCTYPE html>
<html>

<head>

	<title>resume 1</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<style>

		/* font-family:  Biryani;
  font-family: Biryani; */

		* {
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>

	<div class="resume_1"
		style="color: #444;border: solid #666;border-width: 8px 0 2px 0;margin: 30px auto;border-top-left-radius: 15px;border-top-right-radius: 15px;">
		<table style="width: 100%;text-align: center;font-family: Biryani;">
			<tbody>
				<tr>
					<td colspan="2">
						<h1 style="margin: 0; margin: 15px; font-family:  Biryani;">{{ $userdata['name'] }}</h1>
						
					</td>
				</tr>
				<tr>
					<td>{{ $userdata['email'] }}</td>
					<td>{{ $userdata['phone'] }}</td>
				</tr>
			</tbody>
		</table>
		<div style="border-top: 2px solid; margin-top: 25px;">
			<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
				<thead>
					<tr>
						<th>
							<h2 style="margin: 0; margin-top: 10px; text-align: left;">
							Skills(Technical)
						</h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
						@foreach ($userdata['skill_name'] as $skill)
                    <strong>{{ $skill[0]}}</strong>
              			  @endforeach	
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="border-top: 2px solid;margin-top: 25px;">
			<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
				<thead>
					<tr>
						<th>
							<h2 style="margin: 0;margin-top: 10px; font-family:  Biryani; text-align: left;">Experience
							</h2>
						</th>
					</tr>
				</thead>
				@foreach ($userdata['experience'] as $exp)	
				<tbody>
					<tr>
						<td style="width: 70%;">
							<h3 style="margin: 0;">{{ $exp['company_name'] }}</h3>
						</td>
						<td style="width: 30%; text-align: right;">
							<strong>{{ $exp['start_date'] }} - {{ $exp['end_date'] }}</strong>
						</td>
					</tr>
					<tr>
						<td>{{ $exp['position'] }} </td>
					</tr>
					<tr>
						<td>{{ $exp['description'] }}</td>
					</tr>
				</tbody>
				@endforeach
			</table>
		</div>
		<div style="border-top: 2px solid;margin-top: 25px;">

			<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
				<thead>
					<tr>
						<th>
							<h2 style="margin: 0; margin-top: 10px; font-family:  Biryani; text-align: left;">
							Education (Qualifications)
							</h2>
						</th>
					</tr>
				</thead>
				@foreach ($userdata['qualifications'] as $qualification)
				<tbody>
					<tr>
						<td style="width: 70%;">
							<h3 style="margin: 0;">{{ $qualification['school_university'] }}</h3>
						</td>
						<td style="width: 30%; text-align: right;"><strong>{{ $qualification['passing_year'] }}</strong></td>
					</tr>
					<!-- <tr>
						<td>{{ $qualification['school_university'] }}</td>
					</tr> -->
					<tr>
						<td>{{ $qualification['education_type'] }}</td>
					</tr>
				</tbody>
				@endforeach
			</table>
		</div>
		<div style="border-top: 2px solid;margin-top: 25px;">
			<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
				<thead>
					<tr>
						<th>
							<h2 style="margin: 0;margin-top: 10px; font-family:  Biryani; text-align: left;">
							Achievements
							</h2>
						</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($userdata['achievements'] as $achievement)
					<tr>
						<td style="width: 70%;">
						{{ $achievement['company_name'] }} — <strong>{{ $achievement['certification_name'] }}</strong>, 2019
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div style="border-top: 2px solid;margin-top: 25px;">
			<table style="width: 90%;text-align: center;margin: 25px auto;margin-bottom: 30px;font-family: Biryani;">
			@foreach ($userdata['address'] as $addresses)
				<tbody>
					<tr>
						<td style="width: 100%;">
							{{ $addresses['city'] }} {{ $addresses['state'] }}  {{ $addresses['zip_code'] }}, India
						</td>
					</tr>
				</tbody>
				@endforeach
			</table>
		</div>

	</div>


</body>

</html>