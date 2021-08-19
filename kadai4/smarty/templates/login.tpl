<html>
    <head>
        <meta charset="utf-8">
        <title>{$title}</title>
    </head>
    <body>
        <h1 class="title">ログインフォーム</h1>
        {if !empty($smarty.get.error)}<p class="error">{$smarty.get.error}</p></br>
        {/if}

        <form method="POST" action="./login_form.php">
            <h3>ID</h3>
            <input type="text" name="id" value="" />

            <h3>パスワード</h3>
            <input type="text" name="password" value=""></br>

            <label class="auto_login_radio"><input class="auto_login" type="radio" name = "rb" value = "auto">自動でログインする</label></br>
            <input class="login_button" type="submit" name = "login" value="ログイン">
        </form>

        <h2>ユーザ一覧</h2>
        {if empty($users)}<p>ユーザは存在しません。</p> </br>
        {else}
            <table border="1">
            {foreach $users as $key => $val}
                <tr >
                    <td>{$val.uid}</td>
                    <td>{$val.name}</td>
                    <td>{$val.password}</td>
                    <td>{$val.registered}</td>
                </tr>
            {/foreach}
            </table>
        {/if}
    </body>
</html>

<style>
    input{
        margin-bottom: 20px;
    }
    input.login_button {
    width: 80px;
    height: 40px;
    margin-top: 30px;
}
</style>