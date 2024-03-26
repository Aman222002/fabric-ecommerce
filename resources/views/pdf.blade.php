<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1, h2, h3 {
            margin-top: 0;
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        .section th, .section td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center;">Resume</h1>
        <div class="section">
            <h2>Personal Information</h2>
            <p><strong>Name:</strong> {{ $userdata['name'] }}</p>
            <p><strong>Email:</strong> {{ $userdata['email'] }}</p>
            <p><strong>Phone:</strong> {{ $userdata['phone'] }}</p>
            <img src="data:assest/png;base64,{{ base64_encode(file_get_contents(public_path('/storage/assest/' . $userdata['user_image']))) }}">
        </div>
        <div class="section">
            <h2>Qualifications</h2>
            <table>
                <thead>
                    <tr>
                        <th>Education Type</th>
                        <th>School/University</th>
                        <th>Passing Year</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userdata['qualifications'] as $qualification)
                    <tr>
                        <td>{{ $qualification['education_type'] }}</td>
                        <td>{{ $qualification['school_university'] }}</td>
                        <td>{{ $qualification['passing_year'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="section">
            <h2>Skills</h2>
            <ul>
                @foreach ($userdata['skill_name'] as $skill)
                    <li>{{ $skill[0]}}</li>
                @endforeach
            </ul>
        </div>
        <div class="section">
    <h2>Address</h2>
    @foreach ($userdata['address'] as $addresses)
    <p>

    <strong>Address Line 1:</strong> {{ $addresses['address1'] }}<br>
            <strong>Address Line 2:</strong> {{ $addresses['address2'] }}<br>
            <strong>City:</strong> {{ $addresses['city'] }}<br>
            <strong>State:</strong> {{ $addresses['state'] }}<br>
            <strong>Zip Code:</strong> {{ $addresses['zip_code'] }}
    </p>
    @endforeach
</div>
<div class="section">
            <h2>Experience</h2>
            <table>
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Company Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userdata['experience'] as $exp)
                    <tr>
                        <td>{{ $exp['position'] }}</td>
                        <td>{{ $exp['company_name'] }}</td>
                        <td>{{ $exp['start_date'] }}</td>
                        <td>{{ $exp['end_date'] }}</td>
                        <td>{{ $exp['description'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="section">
            <h2>Achievements</h2>
            <table>
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Certificate Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userdata['achievements'] as $achievement)
                    <tr>
                        <td>{{ $achievement['company_name'] }}</td>
                        <td>{{ $achievement['certification_name'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="section">
            <h2>Hobbies</h2>
            <ul>
                @foreach ($userdata['profile'] as $profiles)
                    <li>{{ $profiles['hobbies']}}</li>
                @endforeach
            </ul>
        </div>
        <div class="section">
            <h2>Strength</h2>
            <ul>
                @foreach ($userdata['profile'] as $profiles)
                    <li>{{ $profiles['strengths']}}</li>
                @endforeach
            </ul>
        </div>
    </div>
   
</body>
</html>