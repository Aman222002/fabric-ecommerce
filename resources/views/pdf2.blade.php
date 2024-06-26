<!DOCTYPE html>
<html>

<head>
	<title>resume 2</title>
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

	<div class="resume_1" style="color: #444;border: solid #666;border-width: 8px 0 2px 0;margin: 30px auto;">
		<div style="width: 70%;float: left;">
			<!-- Candidates Name -->
			<div style="margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<tbody>
						<tr>
							<td style="width: 100%;">
								<h1 style="margin: 0; margin-top: 15px ; font-family:  Biryani;">{{ $userdata['name'] }}</h1>
								
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
			
			<!-- Experience -->
			@if (isset($userdata['experience']) && !empty($userdata['experience']))
    @php
        $hasExperience = false;
    @endphp
    <div style="border-top: 2px solid; margin-top: 25px;">
        <table style="width: 90%; text-align: left; margin: 0 auto; font-family: Biryani;">
            <thead>
                <tr>
                    <th>
                        <h2 style="margin: 0; margin-top: 10px; font-family: Biryani; text-align: left;">
                            Experience
                        </h2>
                    </th>
                </tr>
            </thead>
            @foreach ($userdata['experience'] as $exp)
                @if ($exp['company_name'] !== null && $exp['company_name'] !== "null")
                    @php
                        $hasExperience = true;
                    @endphp
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
                            <td>{{ $exp['position'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">{{ $exp['description'] }}</td>
                        </tr>
                    </tbody>
                @endif
            @endforeach
         
        </table>
    </div>
@endif
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
			@if (isset($userdata['achievements']) && !empty($userdata['achievements']))
    @php
        $hasAchievements = false;
    @endphp
    <div style="border-top: 2px solid; margin-top: 25px;">
        <table style="width: 90%; text-align: left; margin: 0 auto; font-family: Biryani;">
            <thead>
                <tr>
                    <th>
                        <h2 style="margin: 0; margin-top: 10px; font-family: Biryani; text-align: left;">
                            Achievements
                        </h2>
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($userdata['achievements'] as $achievement)
                @if ($achievement['company_name'] !== null && $achievement['company_name'] !== "null")
                    @php
                        $hasAchievements = true;
                    @endphp
                    <tr>
                        <td style="width: 70%;">
                            {{ $achievement['company_name'] }} — <strong>{{ $achievement['certification_name'] }}</strong>
                        </td>
                    </tr>
                @endif
            @endforeach

          
            </tbody>
        </table>
    </div>
@endif 
			<!-- Adress -->
			<div style="border-top: 2px solid;margin-top: 25px;">
				<table
					style="width: 90%;text-align: center;margin: 25px auto;margin-bottom: 30px;font-family: Biryani;">
					@foreach ($userdata['address'] as $addresses)
				<tbody>
					<tr>
						<td style="width: 100%;">
							{{ $addresses['city'] }}, {{ $addresses['state'] }}  {{ $addresses['zip_code'] }}, India
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
							<img src="data:assest/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/assest/' . $userdata['user_image']))) }}"  style="width: 120px;height: 120px;">
									
									
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
								<h2 style="margin: 0; margin-top: 10px; text-align: left;">Hobbies </h2>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($userdata['profile'] as $hobbies)
						<tr>
							<td>
								<strong>{{ $hobbies['hobbies']}}</strong>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div style="border-top: 2px solid; margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; text-align: left;">Strengths</h2>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($userdata['profile'] as $hobbies)
						<tr>
							<td>
								<strong>{{ $hobbies['strengths']}}</strong>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			
			

		</div>
	</div>


</body>

</html>