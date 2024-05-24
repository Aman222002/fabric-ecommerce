<!DOCTYPE html>
<html>

<head>
	<title>resume 3</title>
	<style>


		* {
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>

	<div class="resume_1" style="color: #444;margin: 0px auto;">
		<!-- left side -->
		<div style="width: 30%;height: 100%;float: left;background-color: #006666;color: #fff;">
		
			<!-- Hobbies And Strengths -->
			<div>
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<thead>
						<tr>
							<th>
							<h1 style="margin: 0; margin-top: 15px ; font-family:  Biryani;text-align: left;">{{ $userdata['name'] }}</h1>
							</th>
						</tr>
					</thead>
				</table>
			</div>
			<!-- Skills(Technical) -->
			<div style=" margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;margin-bottom:5px;">
				<thead  style="border-bottom: 2px solid;">
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; text-align: left;text-transform: uppercase;font-size:20px;">Skills</h2>
							</th>
						</tr>
					</thead>
			</table>
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
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
			<div style=" margin-top: 25px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;margin-bottom:5px;">
					<thead  style="border-bottom: 2px solid;">
							<tr>
								<th>
									<h2 style="margin: 0; margin-top: 10px; text-align: left;text-transform: uppercase;font-size:20px;">Hobbies</h2>
								</th>
							</tr>
						</thead>
				</table>
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
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
			<div style=" margin-top: 25px;">
			<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;margin-bottom:5px;">
				<thead  style="border-bottom: 2px solid;">
						<tr>
							<th>
								<h2 style="margin: 0; margin-top: 10px; text-align: left;text-transform: uppercase;font-size:20px;">Strengths</h2>
							</th>
						</tr>
					</thead>
	</table>
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">

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
		<!-- right side -->
		<div style="width: 70%;height: 100%;float: left;">
			<!-- Candidates Name -->
			<div style="margin-top: 15px;">
				<table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
					<tbody>
						<tr>
							<td style="width: 100%;">
								<!-- <h1 style="margin: 0; margin-top: 15px ; font-family:  Biryani;">
									Candidates Name</h1> -->
								
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
					style="width: 90%;margin: 25px auto;margin-bottom: 30px;margin-top: 0px;font-family: Biryani;">
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
    <div style="border-top: 2px solid;margin-top: 25px;">
        <table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
            <thead>
                <tr>
                    <th>
                        <h2 style="margin: 0;margin-top: 10px; font-family: Biryani; text-align: left;">
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
                                <strong>
                                    @if ($exp['end_date'] !== null)
                                        {{ $exp['start_date'] }} - {{ $exp['end_date'] }}
                                    @else
									<strong>{{$exp['start_date']}} - Currently Working</strong>
                                    @endif
                                </strong>
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
								<h2 style="margin: 0; margin-top: 10px; font-family:  Biryani; text-align: left;text-transform: uppercase;font-size:20px;">
									Education(Qualifications)
								</h2>
							</th>
						</tr>
					</thead>
					@foreach ($userdata['qualifications'] as $qualification)
					<tbody>
						<tr>
							<td style="width: 70%;">
								<h3 style="margin: 0;text-transform: capitalize;">{{ $qualification['school_university'] }}</h3>
							</td>
							<td style="width: 30%; text-align: right;text-transform: capitalize;"><strong>{{ $qualification['passing_year'] }}</strong></td>
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
    @foreach ($userdata['achievements'] as $achievement)
        @if ($achievement['company_name'] !== null && $achievement['company_name'] !== "null")
            @php
                $hasAchievements = true;
                break;
            @endphp
        @endif
    @endforeach

    @if ($hasAchievements)
    <div style="border-top: 2px solid;margin-top: 25px;">
        <table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
            <thead>
                <tr>
                    <th>
                        <h2 style="margin: 0;margin-top: 10px; font-family: Biryani; text-align: left;">
                            Achievements
                        </h2>
                    </th>
                </tr>
            </thead>
            <tbody>
			@foreach ($userdata['achievements'] as $achievement)
                    @if ($achievement['company_name'] !== null && $achievement['company_name'] !== "null")
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
@endif
		</div>

	</div>
</body>

</html>