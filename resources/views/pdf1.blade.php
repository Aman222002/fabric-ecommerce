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

    <div class="resume_1" style="color: #444;border: solid #666;border-width: 0px 0 0px 0;margin: 30px auto;border-top-left-radius: 15px;border-top-right-radius: 15px;">
        <table style="width: 100%;text-align: center;font-family: Biryani;">
            <tbody>
                <tr>
                    <td colspan="2">
                        <h1 style="margin: 0; margin: 15px; font-family:  Biryani;    text-transform: capitalize;
">{{ $userdata['name'] }}</h1>

                    </td>
                </tr>
                <tr>
                    <td  style="width: 50%;text-align: right;padding-right: 10px;     text-transform: capitalize;
">{{ $userdata['email'] }}</td>
                    <td style="width: 50%;text-align: left;padding-left: 10px;text-transform: capitalize;">{{ $userdata['phone'] }}</td>
                </tr>
            </tbody>
        </table>


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
        <div style="margin-top: 25px;">
        <table style="border-bottom: 2px solid;width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
                <thead>
                    <tr>
                        <th>
                            <h2 style="margin: 0;margin-top: 10px; font-family: Biryani; text-align: cnater;    text-transform: capitalize;
">
                                Experience
                            </h2>
                        </th>
                    </tr>
                </thead>
           </table>
            <table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">

                @foreach ($userdata['experience'] as $exp)
                @if ($exp['company_name'] !== null && $exp['company_name'] !== "null")
                <tbody>
                    <tr>
                        <td style="width: 70%;">
                            <h3 style="margin: 0;text-transform: capitalize;">{{ $exp['company_name'] }}</h3>
                        </td>
                        <td style="width: 30%; text-align: right;text-transform: capitalize;">
                            @if ($exp['end_date'] !== null)
                            <strong>{{ $exp['start_date'] }} - {{ $exp['end_date'] }}</strong>
                            @else
                            <strong>{{$exp['start_date']}} - Currently Working</strong>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-transform: capitalize;">{{ $exp['position'] }} </td>
                    </tr>
                    <tr>
                        <td style="text-transform: capitalize;">{{ $exp['description'] }}</td>
                    </tr>
                </tbody>
                @endif
                @endforeach
            </table>
        </div>

        @endif
        @endif



        <div style="margin-top: 25px;">
        <table style="border-bottom: 2px solid;width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
                <thead>
                    <tr>
                        <th>
                            <h2 style="margin: 0;margin-top: 10px; font-family: Biryani; text-align: center;    text-transform: capitalize;
">
                            Education (Qualifications)
                            </h2>
                        </th>
                    </tr>
                </thead>
           </table>
            <table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
                @foreach ($userdata['qualifications'] as $qualification)
                <tbody>
                    <tr>
                        <td style="width: 70%;">
                            <h3 style="margin: 0;text-transform: capitalize;">{{ $qualification['school_university'] }}</h3>
                        </td>
                        <td style="width: 30%; text-align: right;text-transform: capitalize;"><strong>{{ $qualification['passing_year'] }}</strong></td>
                    </tr>
                    <!-- <tr>
						<td>{{ $qualification['school_university'] }}</td>
					</tr> -->
                    <tr>
                        <td style="text-transform: capitalize;">{{ $qualification['education_type'] }}</td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
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
        <div style="margin-top: 25px;">
        <table style="border-bottom: 2px solid;width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
                <thead>
                    <tr>
                        <th>
                            <h2 style="margin: 0;margin-top: 10px; font-family: Biryani; text-align: center;    text-transform: capitalize;
">
                            Achievements
                            </h2>
                        </th>
                    </tr>
                </thead>
           </table>
            <table style="width: 90%;text-align: left;margin: 0 auto;font-family: Biryani;">
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

</body>

</html>