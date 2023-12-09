<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Add New Student</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <!-- Select2 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="p-5 text-center">Add New Student</h2>

        <div class="container mx-5">
            <form method="post" action="{{ route('storeStudent') }}" enctype="multipart/form-data">
                @csrf

                <x-input type="text" name="name" />
                <x-input type="email" name="email" />

                <div class="mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="gender"><b>Gender</b></label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender"
                            required>
                            <option value="select" selected disabled>Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <span class="text-danger">
                        @error('gender')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <x-input type="date" name="dob" />

                <div class="mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="address"><b>Address</b></label>
                        <textarea class="form-control @error('state') is-invalid @enderror" name="address" required></textarea>
                    </div>
                    <span class="text-danger">
                        @error('state')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="state"><b>State</b></label>
                        <select class="form-select @error('state') is-invalid @enderror" id="state" name="state"
                            required>
                            <option value="" selected disabled>Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="text-danger">
                        @error('state')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="city"><b>City</b></label>
                        <select class="form-select @error('city') is-invalid @enderror" id="city" name="city"
                            required>
                            <option value="" selected disabled>Select City</option>
                            {{-- @foreach ($cities as $city)
                                <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <span class="text-danger">
                        @error('city')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <x-input type="file" name="photo" />

                <div class="mb-3">
                    <div class="input-group" style="flex-wrap:initial">
                        <label class="input-group-text" for="skills"><b>Skills</b></label>
                        <select class="form-select @error('skills') is-invalid @enderror" id="skills" name="skills[]"
                            multiple="multiple" required>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->skill_id }}">{{ $skill->skill_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="text-danger">
                        @error('skills')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="certificates"><b>Certificates</b></label>
                        <input class="form-control @error('certificates') is-invalid @enderror" type="file"
                            name="certificates[]" value="{{ old('certificates') }}" multiple required>
                    </div>
                    <span class="text-danger">
                        @error('certificates')
                            {{ $message }}
                        @enderror
                    </span>
                </div>


                <div>
                    <input type="submit" class="btn btn-success btn-sm" name="submit" value="Submit">
                    <a type="button" class="btn btn-info btn-sm" href="{{ route('index') }}">Home</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#skills').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#state').on('change', function() {
                var state_id = this.value;
                // $("#city").html('');
                $('#city').html('<option value="" selected disabled>Select City</option>');
                $.ajax({
                    url: "{{ url('get-cities-by-state') }}",
                    type: "POST",
                    data: {
                        state_id: state_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        // $('#city').html('<option value="">Select City</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city").append('<option value="' + value.city_id +
                                '">' + value.city_name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
