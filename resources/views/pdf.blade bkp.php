<!DOCTYPE html>
<html>

<head>
	<title>resume 2</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Biryani:wght@200;300;400;600;700;800;900&family=Questrial&display=swap');

		/* font-family:  Biryani;
  font-family: Biryani; */

		* {
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>

	<div class="resume_1" style="color: #444;border: solid #666;border-width: 8px 0 2px 0;margin: 30px auto;">
		<div style="width: 70%;float: left;">
			<!-- Candidates Name -->
			<div style="margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<tbody>
						<tr>
							<td style="width: 100%;">
								<h1 style="margin: 0; margin-top: 15px ; font-family:  Biryani;">{{ $userdata['name'] }}</h1>
								<h2 style="margin: 0; margin-top: 10px ;">
								{{ $userdata['experience'][0]['position'] }} 
								 </h2>
							</td>
						</tr>
						<tr>
							<td>
								<span>{{ $userdata['email'] }}</span>
							 <span> {{ $userdata['phone'] }}</span>
							</td>

						</tr>
					</tbody>
				</table>
			</div>
			<!-- Summary -->
			<div style="border-top: 2px solid; margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; text-align: left;">Summary</h2>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Result-orientated project team leader with 5 years of experience covering project and
								product management including developing, implementing and supporting complex
								infrastructures for fast growing startups. A fast and eager learner, I am detail
								oriented and adapt to changing project requirements quickly to meet business goals.
								Comfortable with ambiguity and able to thrive in a fast-paced environment.
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- Experience -->
			<div style="border-top: 2px solid;margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0;margin-top: 10px; font-family:  Biryani; text-align: left;">
									Experience
								</h2>
							</th>
						</tr>
					</thead>
					@foreach ($userdata['experience'] as $exp)
					<tbody>
						<tr>
							<td style="width: 60%;">
								<h3 style="margin: 0;">{{ $exp['company_name'] }}</h3>
							</td>
							<td style="width: 40%; text-align: right;">
								<strong>{{ $exp['start_date'] }} - {{ $exp['end_date'] }}</strong>
							</td>
						</tr>
						<tr>
							<td>{{ $exp['position'] }} </td>
						</tr>
						<tr>
							<td colspan="3">{{ $exp['description'] }}</td>
						</tr>
					</tbody>
					@endforeach
				</table>
			</div>
			<!-- Education(Qualifications) -->
			<div style="border-top: 2px solid;margin-top: 25px;">

				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; font-family:  Biryani; text-align: left;">
									Education(Qualifications)
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
						<tr>
							<td>{{ $qualification['education_type'] }}</td>
						</tr>
					</tbody>
					@endforeach
				</table>
			</div>
			<!-- Courses and Certificates -->
			<div style="border-top: 2px solid;margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0;margin-top: 10px; font-family:  Biryani; text-align: left;">
									<!-- Courses and Certificates -->Achievements
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
						
						<!-- <tr>
							<td style="width: 70%;">
								PMI Professional in Business Analysis (PBA) — <strong>PMI</strong>, 2019
							</td>
						</tr>
						<tr>
							<td style="width: 70%;">
								PMI Professional in Business Analysis (PBA) — <strong>PMI</strong>, 2019
							</td>
						</tr> -->
					</tbody>
				</table>
			</div>
			<!-- Adress -->
			<div style="border-top: 2px solid;margin-top: 25px;">
				<table
					style="width: 90%;text-align: center;margin: 25px auto;margin-bottom: 30px;font-family: Biryani;">
					@foreach ($userdata['address'] as $addresses)
				<tbody>
					<tr>
						<td style="width: 100%;">
							{{ $addresses['city'] }}, Chennai, {{ $addresses['state'] }}  {{ $addresses['zip_code'] }}, India
						</td>
					</tr>
				</tbody>
				@endforeach
				</table>
			</div>
		</div>
		<!-- Hobbies And Strengths -->
		<div style="width: 30%;float: left;background-color: #22405c;height: 100%;color: #fff;">
			<!-- Candidates Image  -->
			<div style="width: 100%;">
				<table style="width: 100%;text-align: center;font-family: Biryani;margin-top: 20px;">
					<tbody>
						<tr>
							<td colspan="2">
							<img src="data:assest/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/assest/' . $userdata['user_image']))) }}">
									
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- Skills(Technical) -->
			<div style="border-top: 2px solid; margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; text-align: left;">Skills(Technical)</h2>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($userdata['skill_name'] as $skill)
                    <tr>
						<td>
							<strong>{{ $skill[0]}}, </strong>
						</td>
					</tr>
                @endforeach
					</tbody>
				</table>
			</div>
			<!-- Hobbies And Strengths -->
			<div style="border-top: 2px solid; margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; text-align: left;">Hobbies And Strengths</h2>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<strong>Adrealine sport, Composing music</strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- languages -->
			<div style="border-top: 2px solid; margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; text-align: left;">languages</h2>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<strong>Englisg</strong>
							</td>
							<td>
								<strong>Native</strong>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Spanish </strong>
							</td>
							<td>
								<strong>Advances</strong>
							</td>
						</tr>
						<tr>
							<td>
								<strong>German </strong>
							</td>
							<td>
								<strong>Intermediate</strong>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>


</body>

</html>