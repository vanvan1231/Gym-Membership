<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chada nga Gem</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Shojumaru&display=swap"
        rel="stylesheet">
</head>

<body>
    <main>
        <header class="header">
            <div class="container">
                <div class="logo"><a href="/" class="logo-link ff-shojumaru">GEM</a></div>
            </div>
        </header>
        <section class="bg-gradient">
            <div class="container">

                <div class="banner-wrapper">
                    <div class="text-content">
                        @if ($record_exist)
                            <div class="results-wrapper">

                                <h2 class="text-md">Hi {{ $full_name }}</h2>
                                <p>See your details below</p>
                                <p><strong>Email: </strong>{{ $email }}</p>
                                <p><strong>Membership Status: </strong>{{ $mem_status }}</p>
                                <p><strong>Subscription Status: </strong>{{ $sub_status }}</p>
                                <p>This tab will close in <span class="second-remain"></span> seconds</p>
                            </div>
                        @else
                            <h1 class="ff-shojumaru">Chada nga Gem</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sit amet ligula odio.
                                Integer ac placerat magna. Nunc pharetra est arcu, sit amet consequat libero mattis a.
                                Nulla facilisi. Integer hendrerit nulla viverra, venenatis dolor et,</p>
                            <form class="form-wrapper" action="/" method="POST">
                                @csrf
                                <input type="text" name="member_code" placeholder="Enter Your Code" />
                                <input type="submit" value="Submit" />
                            </form>
                            @if ($has_submitted)
                                <span class="warning">No such member exist</span>
                            @endif
                        @endif
                    </div>
                    <div class="media-content">
                        <lottie-player src="{{ URL::asset('assets/lottie/Gym.json') }}" background="transparent"
                            speed="1" style="width: 100%; height: auto" direction="1" mode="normal" loop
                            autoplay></lottie-player>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="{{ URL::asset('assets/js/main.js') }}"></script>
</body>

</html>
