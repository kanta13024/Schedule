<?php
// 年月日を取得する
if (isset($_GET["ymd"])) {
    // スケジュールの年月日を取得する
    $ymd = basename($_GET["ymd"]);
    $y = intval(substr($ymd, 0, 4));
    $m = intval(substr($ymd, 4, 2));
    $d = intval(substr($ymd, 6, 2));
    $disp_ymd = "{$y}年{$m}月{$d}日のスケジュール";

    // スケジュールデータを取得する
    $file_name = "date/{$ymd}.txt";
    if (file_exists($file_name)) {
        $schedule = file_get_contents($file_name);
    } else {
        $schedule = "";
    }
} else {
    // カレンダー画面に強制移動する
    header("Location: calendar.php");
}

// スケジュールを更新する
if (isset($_POST["action"]) and $_POST["action"] == "更新する") {
    $schedule = htmlspecialchars($_POST["schedule"], ENT_QUOTES, "UTF-8");

    // スケジュールが入力されたか調べて処理を分岐
    if (!empty($schedule)) {
        // スケジュールが入力されたか調べて処理を分岐
        file_put_contents($file_name, $schedule);
    } else {
        // スケジュールがからの場合はファイルを削除
        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }
    // カレンダー画面へ移動する
    header("Location: calendar.php");
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール帳（２．スケジュール登録）</title>
</head>

<body>
    <h1>スケジュール帳（２．スケジュール登録）</h1>
    <form action="" method="POST">
        <table>
            <tr>
                <td><?php echo $disp_ymd; ?></td>
            </tr>
            <tr>
                <td>
                    <textarea name="schedule" cols="50" rows="10"><?php echo $schedule; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="action" value="更新する">
                    <input type="button" name="back" onclick="history.back()" value="戻る">
                </td>
            </tr>
        </table>
    </form>

</body>

</html>