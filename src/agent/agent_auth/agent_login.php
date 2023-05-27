<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../user/assets/styles/login.css" />
    <title>エージェントログイン画面</title>
</head>

<body>
    <header>
        <div class="header_wrapper">
            <div class="header_upper">
                <div class="craft_logo">CRAFT</div>
                <div class="boozer_logo"><img src="../../user/assets/img/boozer_logo_white.png" alt="boozer Inc."></div>
            </div>
        </div>
    </header>
    <main>
        <div class="login_page">
            <div class="form_wrapper">
                <form action="http://localhost:8080/agent/agent_auth/agent_login_check.php" method="post" class="login_form">
                    <div>
                        <label>
                            <input placeholder="メールアドレス" type="text" name="mail" required />
                        </label>
                    </div>
                    <div>
                        <label>
                            <input placeholder="パスワード" type="password" name="pass" required />
                        </label>
                    </div>
                    <button type="submit" class="login_button">ログイン</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
