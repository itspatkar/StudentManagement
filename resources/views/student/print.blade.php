<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Student Information</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <style>
        .container {
            max-width: 700px;
            margin: auto;
            font-size: 1.05rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="comtainer">
            <h2 class="p-5 text-center">Student Information</h2>
            <div>
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <td>:&emsp; {{ $student->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>:&emsp; {{ $student->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>:&emsp; {{ $student->email }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>:&emsp; @if ($student->gender == 'M')
                                Male
                            @else
                                Female
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td>:&emsp; {{ $student->dob }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>:&emsp; {{ $student->address }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>:&emsp;
                            @foreach ($states as $state)
                                @if ($state->state_id == $student->state)
                                    {{ $state->state_name }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>:&emsp;
                            @foreach ($cities as $city)
                                @if ($city->city_id == $student->city)
                                    {{ $city->city_name }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Skills</th>
                        <td>
                            @php
                                $student_skills = explode(',', $student->skills);
                            @endphp
                            @foreach ($student_skills as $student_skill)
                                @foreach ($skills as $skill)
                                    @if ($student_skill == $skill->skill_id)
                                        &emsp; &bull; {{ $skill->skill_name }}<br>
                                    @endif
                                @endforeach
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
