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

	<div class="resume_1" style="color: #444;margin: 0px auto;">
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

							<!-- Adress -->
	
				<table
				style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
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
		
		<!-- Experience -->
<!-- Experience -->
@if (isset($userdata['experience']) && !empty($userdata['experience']))
    @php
        $hasExperience = false;
    @endphp
    @foreach ($userdata['experience'] as $exp)
        @if ($exp['company_name'] !== null && $exp['company_name'] !== "null")
            @php
                $hasExperience = true;
                break;
            @endphp
        @endif
    @endforeach

    @if ($hasExperience)
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
                        <tbody>
                            <tr>
                                <td style="width: 60%;">
                                    <h3 style="margin: 0;">{{ $exp['company_name'] }}</h3>
                                </td>
                                <td style="width: 40%; text-align: right;">
                                    @if ($exp['end_date'] !== null)
                                        <strong>{{ $exp['start_date'] }} - {{ $exp['end_date'] }}</strong>
                                    @else
                                        <strong>{{$exp['start_date']}} - Currently Working</strong>
                                    @endif
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
@endif
			<!-- Education(Qualifications) -->
			<div style="border-top: 2px solid;margin-top: 25px;">

				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; font-family:  Biryani; text-align: left;text-transform: uppercase;font-size:25px;">
									Education(Qualifications)
								</h2>
							</th>
						</tr>
					</thead>
					@foreach ($userdata['qualifications'] as $qualification)
					<tbody>
						<tr>
							<td style="width: 70%;">
								<h3 style="margin: 0; text-transform: capitalize;">{{ $qualification['school_university'] }}</h3>
							</td>
							<td style="width: 30%; text-align: right; text-transform: capitalize;"><strong>{{ $qualification['passing_year'] }}</strong></td>
						</tr>
						<tr>
							<td>{{ $qualification['education_type'] }}</td>
						</tr>
					</tbody>
					@endforeach
				</table>
			</div>
			<!-- Courses and Certificates -->
			<!-- Courses and Certificates -->
@if (isset($userdata['achievements']) && !empty($userdata['achievements']))
    @php
        $hasAchievements = false;
    @endphp
    @foreach ($userdata['achievements'] as $achievement)
        @if ($achievement['company_name'] !== null && $achievement['company_name'] !== "null")
            @php
                $hasAchievements = true;
                break;
            @endphp
        @endif
    @endforeach

    @if ($hasAchievements)
        <div style="border-top: 2px solid; margin-top: 25px;">
            <table style="width: 90%; text-align: left; margin: 0 auto; font-family: Biryani;">
                <thead>
                    <tr>
                        <th>
                            <h2 style="margin: 0; margin-top: 10px; font-family: Biryani; text-align: left;text-transform: uppercase;font-size:25px;">
                                Achievements
                            </h2>
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($userdata['achievements'] as $achievement)
                    @if ($achievement['company_name'] !== null && $achievement['company_name'] !== "null")
                        <tr>
                            <td style="width: 70%; text-transform: capitalize;">
                                {{ $achievement['company_name'] }} — <strong>{{ $achievement['certification_name'] }}</strong>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif



		</div>
		<!-- Hobbies And Strengths -->
		<div style="width: 30%;float: left;background-color: #22405c;height: 100%;color: #fff;">
			<!-- Candidates Image  -->
			<div style="width: 100%;">
				<table style="width: 100%;text-align: center;font-family: Biryani;margin-top: 20px;">
					<tbody>
						<tr>
							<td colspan="2">
							<img src="data:assest/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/assest/' . $userdata['user_image']))) }}"  style="width: 120px;height: 120px;border-radius:50%;">
									
									
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
								<h2 style="margin: 0; margin-top: 10px; text-align: left;text-transform: uppercase;font-size:25px;"> 	 Skills
						</tr>
					</thead>
					<tbody>
					@foreach ($userdata['skill_name'] as $skill)
                    <tr>
						<td style="padding-left:10px;color:#e1e1e1; text-transform: capitalize;">
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
								<h2 style="margin: 0; margin-top: 10px; text-align: left;text-transform: uppercase;font-size:25px;"> Hobbies </h2>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($userdata['profile'] as $hobbies)
						<tr>
							<td  style="padding-left:10px;color:#e1e1e1; text-transform: capitalize;">
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
								<h2 style="margin: 0; margin-top: 10px; text-align: left;text-transform: uppercase;font-size:25px;">Strengths</h2>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($userdata['profile'] as $hobbies)
						<tr>
							<td style="padding-left:10px;color:#e1e1e1; text-transform: capitalize;">
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