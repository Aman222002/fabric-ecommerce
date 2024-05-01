
<!DOCTYPE html>
<html>

<head>
    <title> Verification Mail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        @media (max-width:767px) {
            .email_temp {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <div class="content email_temp"
        style="
                      margin: 0px auto;
                      font-family: Roboto, Helvetica, Arial, sans-serif;
                      background:#f5f5f5;
                      max-width: 900px;
                      margin: 0 auto;
                      border:1px solid #dedede;
                    ">
        <div class="container">

            <div class="email_body"
                style="
                          background-color:#f5f5f5;
                          padding: 20px;
                        ">

               

                <div>
                    <p style="margin:17px 0px 10px 0px;">
                        Hi <span
                            style="margin:17px 0px 10px 0px;font-size: 16px;font-weight: bold;color: #000;text-transform: capitalize">
                            {{ $user->name }},
                        </span>

                    </p>
                    <p
                        style="font-size: 14px;
                                font-family: Roboto, Helvetica, Arial, sans-serif;
                                color: #000;
                                line-height: 24px;
                                text-align:left;
                              ">
                        We would like to confirm that your account has been registered successfully. Click on the button
                        below to verify your account .

                </div>
                <div
                    style="width:200px; text-align:center;margin:auto; padding:1px;
                              text-decoration:underline;
                              color:#FFF;
                              text-decoration: none;
                              background-color:#5892FF;
                              padding:9px 0;

                              border-radius: 20px;">
                    <a href="{{ url('/verify/company/' . $verificationToken) }}"
                        style="text-decoration:none;color:#FFF;"> Verify your account </a>
                </div>
                <div>
                    <p style="margin: 18px 0px 8px 0; font-size: 16px; color:#000">
                        Thanks &amp; Regards,
                    </p>
                    <h3 style="font-size: 16px; margin: 0; color:#000;margin-bottom: 30px;">
                       Jobs

                    </h3>
                </div>
            </div>

        </div>
        <div>
            <div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

</html>

